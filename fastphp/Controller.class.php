<?php
/**
 * 控制器基類
 */
class Controller
{
    protected $_controller;
    protected $_action;
    protected $_view;

    // 建構函式，初始化屬性，並例項化對應模型
    public function __construct($controller, $action)
    {
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new View($controller, $action);
    }

    // 分配變數
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    // 渲染檢視
    public function render()
    {
        $this->_view->render();
    }
}
