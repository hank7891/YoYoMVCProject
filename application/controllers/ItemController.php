<?php

class ItemController extends Controller
{
    // 首頁方法，測試框架自定義DB查詢
    public function index()
    {
        $items = (new ItemModel)->selectAll();

        $this->assign('title', '全部條目');
        $this->assign('items', $items);
        $this->render();
    }

    // 新增記錄，測試框架DB記錄建立（Create）
    public function add()
    {
        $data['item_name'] = $_POST['value'];
        $count = (new ItemModel)->add($data);

        $this->assign('title', '新增成功');
        $this->assign('count', $count);
        $this->render();
    }

    // 檢視記錄，測試框架DB記錄讀取（Read）
    public function view($id = null)
    {
        $item = (new ItemModel)->select($id);

        $this->assign('title', '正在檢視' . $item['item_name']);
        $this->assign('item', $item);
        $this->render();
    }

    // 更新記錄，測試框架DB記錄更新（Update）
    public function update()
    {
        $data = array('id' => $_POST['id'], 'item_name' => $_POST['value']);
        $count = (new ItemModel)->update($data['id'], $data);

        $this->assign('title', '修改成功');
        $this->assign('count', $count);
        $this->render();
    }

    // 刪除記錄，測試框架DB記錄刪除（Delete）
    public function delete($id = null)
    {
        $count = (new ItemModel)->delete($id);

        $this->assign('title', '刪除成功');
        $this->assign('count', $count);
        $this->render();
    }
}
