<!-- head -->
<?php include ROOT . '/template/head.php'; ?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
    <!-- header -->
    <?php include ROOT . '/template/header.php'; ?>
    <div class="container">
        <h1>Ближайшие концерты</h1>
        <?php EventController::actionPrintList(); ?>
    </div>

    <!-- footer -->
    <?php include ROOT . '/template/footer.php'; ?>
</body>
</html>
