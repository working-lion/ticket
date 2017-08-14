<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header_admin.php';?>
<div class="container">

    <?php if ($result): ?>
        <p>Заказ успешно отредактирован!</p>
    <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h2>Страница изменения статуса заказа №<?php echo $orderId;?></h2>
    <form action="" method="post" class="middle_form">
        <div class="data_item">
            <label for="title">Статус:</label>
            <select name="status">
                <option <?php echo ($status == 0) ? 'selected="selected"': ''?> value="0">В обработке</option>
                <option <?php echo ($status == 1) ? 'selected="selected"': ''?> value="1">Оплачен</option>
            </select>
        </div>
        <input type="submit" name="update_order" value="Сохранить изменения" class="btn green_btn update_order">
    </form>
    <a href="/admin/order" class="btn blue_btn to_order_list">Вернуться к списку заказол</a>
    <?php endif; ?>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>
</body>
</html>
