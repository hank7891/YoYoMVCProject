<?php
/**
 * fastphp框架核心
 */
class Fastphp
{
    protected $_config = [];

    public function __construct($config)
    {
        $this->_config = $config;
    }

    // 執行程式
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->route();
    }

    // 路由處理
    public function route()
    {
        $controllerName = $this->_config['defaultController'];
        $actionName = $this->_config['defaultAction'];
        $param = array();

        $url = $_SERVER['REQUEST_URI'];
        // 清除?之後的內容
        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);
        // 刪除前後的“/”
        $url = trim($url, '/');

        if ($url) {
            // 使用“/”分割字串，並儲存在陣列中
            $urlArray = explode('/', $url);
            // 刪除空的陣列元素
            $urlArray = array_filter($urlArray);

            // 獲取控制器名
            $controllerName = ucfirst($urlArray[0]);

            // 獲取動作名
            array_shift($urlArray);
            $actionName = $urlArray ? $urlArray[0] : $actionName;

            // 獲取URL引數
            array_shift($urlArray);
            $param = $urlArray ? $urlArray : array();
        }

        // 判斷控制器和操作是否存在
        $controller = $controllerName . 'Controller';
        if (!class_exists($controller)) {
            exit($controller . '控制器不存在');
        }
        if (!method_exists($controller, $actionName)) {
            exit($actionName . '方法不存在');
        }

        // 如果控制器和操作名存在，則例項化控制器，因為控制器物件裡面
        // 還會用到控制器名和操作名，所以例項化的時候把他們倆的名稱也
        // 傳進去。結合Controller基類一起看
        $dispatch = new $controller($controllerName, $actionName);

        // $dispatch儲存控制器例項化後的物件，我們就可以呼叫它的方法，
        // 也可以像方法中傳入引數，以下等同於：$dispatch->$actionName($param)
        call_user_func_array(array($dispatch, $actionName), $param);
    }

    // 檢測開發環境
    public function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors', 'On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors', 'Off');
            ini_set('log_errors', 'On');
        }
    }

    // 刪除敏感字元
    public function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map(array($this, 'stripSlashesDeep'), $value) : stripslashes($value);
        return $value;
    }

    // 檢測敏感字元並刪除
    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->stripSlashesDeep($_GET) : '';
            $_POST = isset($_POST) ? $this->stripSlashesDeep($_POST) : '';
            $_COOKIE = isset($_COOKIE) ? $this->stripSlashesDeep($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->stripSlashesDeep($_SESSION) : '';
        }
    }

    // 檢測自定義全域性變數並移除。因為 register_globals 已經棄用，如果
    // 已經棄用的 register_globals 指令被設定為 on，那麼區域性變數也將
    // 在指令碼的全域性作用域中可用。 例如， $_POST['foo'] 也將以 $foo 的
    // 形式存在，這樣寫是不好的實現，會影響程式碼中的其他變數。 相關資訊，
    // 參考: http://php.net/manual/zh/faq.using.php#faq.register-globals
    public function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    // 配置資料庫資訊
    public function setDbConfig()
    {
        if (isset($this->_config['db'])) {
            Model::$dbConfig = $this->_config['db'];
        }
    }

    // 自動載入控制器和模型類
    public static function loadClass($class)
    {
        $frameworks = __DIR__ . '/' . $class . '.php';
        $controllers = APP_PATH . 'application/controllers/' . $class . '.php';
        $models = APP_PATH . 'application/models/' . $class . '.php';

        if (file_exists($frameworks)) {
            // 載入框架核心類
            include $frameworks;
        } elseif (file_exists($controllers)) {
            // 載入應用控制器類
            include $controllers;
        } elseif (file_exists($models)) {
            //載入應用模型類
            include $models;
        } else {
            // 錯誤程式碼
        }
    }
}
