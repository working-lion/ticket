<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
<div class="container">
    <h1>Страница сообщения о записи заказа.</h1>
    <h2>Заказ успешно оформлен!</h2>
    <p>Номер заказа: <?php echo $order["id"];?></p>
    <p>Дата оформелия заказа: <?php echo Helper::formatOrderDateForView($order["date"]);?></p>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>
</body>
</html>
