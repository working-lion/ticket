<!-- head -->
<?php include ROOT . '/template/head.php';?>

<body>
    <?php include ROOT . '/template/header.php';?>
    <div class="container">
        <h1>Кабинет пользователя</h1>
        <h3>Привет, <?php echo $user['name'];?>!</h3>
        <ul class="content_menu">
            <li><a href="/cabinet/edit" class="edit_user_data"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Редактировать данные</a></li>
            <li><a href="/cabinet/list" class="to_order_list"><i class="fa fa-list" aria-hidden="true"></i>Список заказов</a></li>
        </ul>
    </div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>

</body>
</html>
