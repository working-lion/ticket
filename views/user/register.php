<!-- head -->
<?php include ROOT . '/template/head.php';?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
<div class="container">
    <h1>Регистрация на сайте</h1>
    <?php if ($result): ?>
        <p>Вы зарегистрированы!</p>
    <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <div class="registr_form"><!--sign up form-->
            <form action="" method="post" class="middle_form">
                <div class="data_item">
                    <label for="name">Имя:</label>
                    <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                </div>
                <div class="data_item">
                    <label for="email">E-mail:</label>
                    <input type="email" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
                </div>
                <div class="data_item">
                    <label for="paddword">Пароль</label>
                    <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                </div>
                    <input type="submit" name="submit" class="btn blue_btn right" value="Регистрация" class="btn"/>
            </form>
        </div><!--/sign up form-->
    <?php endif; ?>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>
</body>
</html>
