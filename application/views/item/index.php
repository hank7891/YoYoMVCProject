<form action="/item/add" method="post">
    <input type="text" value="點選新增" onclick="this.value=''" name="value">
    <input type="submit" value="新增">
</form>
<br/>
<?php foreach ($items as $item): ?>
    <a class="big" href="/item/view/<?php echo $item['id'] ?>" title="點選修改">
        <span class="item">
            <?php echo $item['id'] ?>
            <?php echo $item['item_name'] ?>
        </span>
    </a>
    ----
    <a class="big" href="/item/delete/<?php echo $item['id']?>">刪除</a>
<br/>
<?php endforeach ?>