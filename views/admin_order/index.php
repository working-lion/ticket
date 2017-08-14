<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header_admin.php';?>
<div class="container">
    <h1>Список заказов</h1>
    <?php if(!empty($orderList)):?>
        <table class="admin_order_list">
            <tr>
                <th>#</th>
                <th>Почта пользователя</th>
                <th>id концерта</th>
                <th>Дата</th>
                <th>Статус</th>
                <th>Ред-ть</th>
                <th>Удалить</th>
            </tr>
            <?php foreach ($orderList as $orderItem):?>
            <tr>
                <td>
                    <?php echo $orderItem["id"]; ?>
                </td>
                <td>
                    <?php echo $orderItem["userEmail"]; ?>
                </td>
                <td>
                    <?php echo $orderItem["eventId"]; ?>
                </td>
                <td class=""date>
                    <?php echo $orderItem["date"]; ?>
                </td>
                <td>
                    <?php echo ($orderItem["status"]) ? 'Оплачен' : 'В обработке'; ?>
                </td>
                <td class="edit">
                    <a href="order/update/<?php echo $orderItem["id"];?>" class="action_btn edit_btn">edit</a>
                </td>
                <td class="delete">
                    <a href="order/delete/<?php echo $orderItem["id"];?>" class="action_btn delete_btn">del</a>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    <?php
    else : echo '<p>Список заказов пуст.</p>';
    endif;
    ?>

</div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>
</body>
</html>
