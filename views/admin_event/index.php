<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header_admin.php';?>
<div class="container">
    <h1>Список концертов</h1>
    <?php if(!empty($eventList)): ?>
        <table class="admin_event_list">
            <tr>
                <th>Постер</th>
                <th>Заголовок</th>
                <th>Цены</th>
                <th>Дата</th>
                <th>Зал</th>
                <th>Анонс</th>
                <th>Ред-ть</th>
                <th>Удалить</th>
            </tr>
            <?php $i = 0; ?>
            <?php foreach ($eventList as $eventItem):?>
            <tr>
                <td class="poster">
                    <div class="poster">
                        <?php echo '<img src="'.$img_path.$eventItem["poster"].'"/>'; ?>
                    </div>
                </td>
                <td class="title"><?php echo $eventItem["title"]; ?></td>
                <td class="price_zones">
                    <div class="price">
                        <span class="price_title">Ряд 1-5: </span>
                        <span><?php echo $priceList[$i][0]["price"] . '<span class="curr">руб.</span>'; ?></span>
                    </div>
                    <div class="price">
                        <span class="price_title">Ряд 6-10: </span>
                        <span><?php echo $priceList[$i][1]["price"] . '<span class="curr">руб.</span>'; ?></span>
                    </div>
                    <div class="price">
                        <span class="price_title">Ряд 11-15: </span>
                        <span><?php echo $priceList[$i][2]["price"] . '<span class="curr">руб.</span>'; ?></span>
                    </div>
                </td>
                <td class="date">
                    <?php echo Helper::formatDateForView($eventItem["date"]) . '<br>' .
                    Helper::formatTimeForView($eventItem["time"]); ?>
                </td>
                <td class="room">
                    <?php echo $eventItem["roomId"]; ?>
                </td>
                <td class="announce">
                    <div class="admin_table_anounce">
                        <?php echo $eventItem["announce"]; ?>
                    </div>
                </td>
                <td class="edit">
                    <a href="event/update/<?php echo $eventItem["id"];?>" class="action_btn edit_btn">edit</a>
                </td>
                <td class="delete">
                    <a href="event/delete/<?php echo $eventItem["id"];?>" class="action_btn delete_btn">del</a>
                </td>
            </tr>
            <?php $i++ ; ?>
            <?php endforeach;?>
        </table>
    <?php
    else : echo '<p>Список концертов пуст.</p>';
    endif;
    ?>

</div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>
</body>
</html>
