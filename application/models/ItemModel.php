<?php

/**
 * 使用者模組，一般與資料庫表名對應
 * 例如表名為：item，那麼Model類名應該為：ItemModel
 * 也可以新增一個$_table屬性指定表名
 */
class ItemModel extends Model
{
    public $_table = 'item';
}
