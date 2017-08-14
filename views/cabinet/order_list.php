<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
<div class="container">
    <h1>Список Ваших заказов</h1>

    <?php if (!empty($orderList)):?>
        <table>
            <tr>
                <th>#</th>
                <th>Концерты</th>
                <th>Дата</th>
                <th>Цена</th>
            </tr>
            <?php
                $i = 1;
                foreach ($orderList as $order){
                    echo '<tr>
                            <td>'.$i.'</td>
                            <td>'.$eventList[$i-1]["title"].'</td>
                            <td>'.Helper::formatOrderDateForView($order["date"]).'</td>
                            <td>'.$order["summ"].' руб.</td>
                        </tr>';
                    $i ++;
                }
            ?>
            <tr class="sum">
                <td colspan="3">Сумма:</td>
                <td><?php echo $totalSumm;?> руб.</td>
            </tr>
        </table>
    <?php else:
        echo '<p>Вы пока не сделали ни одного заказа</p>';
        echo '<a href="/event/">Перейти к списку концертов</a>';
    ?>
    <?php endif;?>

</div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>
</body>
</html>
