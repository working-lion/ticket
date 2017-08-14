<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header_admin.php';?>
<div class="container">
    <h2>Вы действительно хотите удалить концерт №<?php echo $eventId;?>?</h2>
    <div class="delete_buttons">
        <form action="" method="post" class="middle_form">
            <input type="submit" name="event_delete" value="Да, удалить концерт!" class="btn red_btn delete_btn">
        </form>
        <a href="/admin/event" class="btn blue_btn">Вернуться к списку концертов</a>
    </div>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>
</body>
</html>
