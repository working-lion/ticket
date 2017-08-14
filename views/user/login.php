<!-- head -->
<?php include ROOT . '/template/head.php';?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
    <div class="container">
        <?php if (isset($errors) && is_array($errors)): ?>
        <ul class="errors">
            <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <div class="signup-form"><!--sign up form-->
            <h2>Вход на сайт</h2>
            <form action="" method="post" class="middle_form">
                <div class="data_item">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
                </div>
                <div class="data_item">
                    <label for="password">Пароль:</label>
                    <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                </div>
                <input type="submit" name="user_login" class="btn blue_btn right" value="Вход" class="btn"/>
            </form>
        </div><!--/sign up form-->
    </div>
<?php include ROOT . '/template/footer.php'; ?>

</body>
</html>
