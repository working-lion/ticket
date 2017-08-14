<!-- head -->
<?php include ROOT . '/template/head.php';?>

<body>
    <?php include ROOT . '/template/header_admin.php';?>
    <div class="container">
        <h1>Панель администратора.</h1>
        <ul class="content_menu">
            <li><a href="admin/event/create" class="add_event_link"><i class="fa fa-plus-square-o" aria-hidden="true"></i>Добавить концерт</a></li>
            <li><a href="admin/event" class="event_list_link"><i class="fa fa-list" aria-hidden="true"></i>Список концертов</a></li>
            <li><a href="admin/order" class="order_list_link"><i class="fa fa-list-alt" aria-hidden="true"></i>Список заказов</a></li>
        </ul>
    </div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>

</body>
</html>
