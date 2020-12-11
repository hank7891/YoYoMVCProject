<?php

class Model extends Sql
{
    protected $_model;
    protected $_table;
    public static $dbConfig = [];

    public function __construct()
    {
        // 連線資料庫
        $this->connect(self::$dbConfig['host'], self::$dbConfig['username'], self::$dbConfig['password'],
            self::$dbConfig['dbname']);

        // 獲取資料庫表名
        if (!$this->_table) {
            // 獲取模型類名稱
            $this->_model = get_class($this);
            // 刪除類名最後的 Model 字元
            $this->_model = substr($this->_model, 0, -5);

            // 資料庫表名與類名一致
            $this->_table = strtolower($this->_model);
        }
    }
}
