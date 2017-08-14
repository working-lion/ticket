<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
<div class="container make_order">
    <h1>Страница оформления заказа</h1>
    <div class="make_order_id">
        <div class="data_item date"><span class="item_name">Концерт: </span>
            <?php echo $eventItem["title"]; ?>
        </div>
        <div class="data_item date"><span class="item_name">Дата: </span>
            <?php echo Helper::formatDateForView($eventItem["date"]); ?>
        </div>
        <div class="data_item time"><span class="item_name">Время: </span>
            <?php echo Helper::formatTimeForView($eventItem["time"]); ?>
        </div>
        <div class="data_item room"><span class="item_name">Зал: </span>
            <?php echo $eventItem["room_id"]; ?>
        </div>
    </div>
    <table class="order_ticket_list">
        <tr>
            <th>#</th>
            <th>Ряд</th>
            <th>Место</th>
            <th>Цена</th>
        </tr>
        <?php
            $i = 1;
            foreach ($ticketList as $ticket){
                echo '<tr>
                    <td>'.$i.'</td>
                    <td>'.$ticket["row"].'</td>
                    <td>'.$ticket["place"].'</td>
                    <td>'.$ticket["price"] . ' руб.</td>
                </tr>';
                $i++;
            }
        ?>
        <tr class="sum">
            <td colspan="3">Сумма:</td>
            <td><?php echo $summ_order . ' руб.'; ?></td>
        </tr>
    </table>
    <form action="" method="post">
        <div class="data_item">
            <label for="email">Введите e-mail:</label>
            <?php
                foreach ($errors as $error){
                    echo '<p class="error">'.$error.'</p>';
                }
            ?>
            <input type="email" name="email" value="<?php echo $email; ?>" required>
        </div>
        <input type="submit" name="make_order" value="Оформить заказ" class="btn green_btn">
    </form>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>
</body>
</html>
