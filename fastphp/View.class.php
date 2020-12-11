<?php
/**
 * 檢視基類
 */
class View
{
    protected $variables = array();
    protected $_controller;
    protected $_action;

    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
    }

    // 分配變數
    public function assign($name, $value)
    {
        $this->variables[$name] = $value;
    }

    // 渲染顯示
    public function render()
    {
        extract($this->variables);
        $defaultHeader = APP_PATH . 'application/views/header.php';
        $defaultFooter = APP_PATH . 'application/views/footer.php';

        $controllerHeader = APP_PATH . 'application/views/' . $this->_controller . '/header.php';
        $controllerFooter = APP_PATH . 'application/views/' . $this->_controller . '/footer.php';
        $controllerLayout = APP_PATH . 'application/views/' . $this->_controller . '/' . $this->_action . '.php';

        // 頁標頭檔案
        if (file_exists($controllerHeader)) {
            include $controllerHeader;
        } else {
            include $defaultHeader;
        }

        include $controllerLayout;

        // 頁尾檔案
        if (file_exists($controllerFooter)) {
            include $controllerFooter;
        } else {
            include $defaultFooter;
        }
    }
}
