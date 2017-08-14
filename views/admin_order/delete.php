<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header_admin.php';?>
<div class="container">
    <h2>Вы действительно хотите удалить заказ №<?php echo $orderId;?>?</h2>
    <div class="order_del_menu">
        <form action="" method="post" class="middle_form">
            <input type="submit" name="order_delete" value="Да, удалить заказ!" class="btn red_btn delete_btn">
        </form>
        <a href="/admin/order" class="btn blue_btn to_order_list">Вернуться к списку заказол</a>
    </div>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>
</body>
</html>
