<!-- head -->
<?php include ROOT . '/template/head.php';?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
    <div class="container">
        <?php if ($result): ?>
            <p>Данные отредактированы!</p>
        <?php else: ?>
            <?php if (isset($errors) && is_array($errors)): ?>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li> - <?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <div class="signup-form"><!--sign up form-->
                <h2>Редактирование данных</h2>
                <form action="#" method="post" class="middle_form">
                    <div class="data_item">
                        <lable for="email">Почта:</lable>
                        <input type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>"/>
                    </div>
                    <div class="data_item">
                        <lable for="name">Имя:</lable>
                        <input type="text" name="name" placeholder="Имя" value="<?php echo $name; ?>"/>
                    </div>
                    <div class="data_item">
                        <lable for="password">Пароль:</lable>
                        <input type="password" name="password" placeholder="Пароль" value="<?php echo $password; ?>"/>
                    </div>
                    <input type="submit" name="user_edit" class="btn green_btn right" value="Сохранить" class="btn"/>
                </form>
            </div><!--/sign up form-->
        <?php endif; ?>

    </div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>

</body>
</html>
