<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header_admin.php';?>
<div class="container">
    <?php ?>

    <?php if ($result): ?>
        <p class="ok_message"><i class="fa fa-check-square-o" aria-hidden="true"></i>Концерт успешно отредактирован!</p>
    <?php else: ?>
        <?php if (isset($errors) && is_array($errors)): ?>
            <ul class="errors">
                <?php foreach ($errors as $error): ?>
                    <li> - <?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <h2>Страница редактирования концерта №<?php echo $eventId;?></h2>

    <form action="" method="post" class="middle_form" enctype="multipart/form-data">
        <div class="data_item">
            <label for="poster">Постер:</label>
            <!--максимальный размер файла-->
            <input type="file" name="poster" value="<?php echo $poster;?>">
        </div>
        <div class="data_item">
            <label for="title">Заголовок:</label>
            <input type="text" name="title" value="<?php echo $title; ?>" required>
        </div>
        <div class="data_item priceList">
            <h2>Цены:</h2>
            <div class="price">
                <label for="price1">Цена с ряда 1 по ряд 5:</label>
                <input type="number" name="price1" value="<?php echo
                ($priceList[0]["price"])? $priceList[0]["price"]: '1500'; ?>"
                min="0" required>
            </div>
            <div class="price">
                <label for="price2">Цена с ряда 6 по ряд 10:</label>
                <input type="number" name="price2" value="<?php echo
                ($priceList[1]["price"])? $priceList[1]["price"]: '1000'; ?>"
                min="0" required>
            </div>
            <div class="price">
                <label for="price3">Цена с ряда 11 по ряд 15:</label>
                <input type="number" name="price3" value="<?php echo
                ($priceList[2]["price"])? $priceList[2]["price"]: '700'; ?>"
                min="0" required>
            </div>
        </div>
        <div class="data_item">
            <label for="date">Дата:</label>
            <input type="date" name="date" value="<?php echo $date; ?>" required>
        </div>
        <div class="data_item">
            <label for="date">Время:</label>
            <input type="time" name="time" value="<?php echo $time; ?>" required>
        </div>
        <div class="data_item">
            <label for="room_id">Зал:</label>
            <select name="roomId" value="<?php echo $roomId; ?>">
                <?php
                foreach ($roomList as $room) {
                    echo '<option value="'.$room["id"].'"'.
                        (($roomId == $room["id"]) ? ' selected':'').'>'
                        .$room["id"].'</option>';
                }
                ?>
            </select>
        </div>
        <div class="data_item">
            <label for="announce">Анонс:</label>
            <textarea name="announce"><?php echo $announce; ?></textarea>
        </div>
        <input type="submit" name="event_update" value="Сохранить изменения" class="btn green_btn right">
    </form>
           <!-- <td class="poster">
                <?php //echo '<img src="'.$img_path.$eventItem["poster"].'"/>'; ?>
            </td>-->
    <?php endif; ?>
</div>

<!-- footer -->
<?php include ROOT . '/template/footer_admin.php';?>
</body>
</html>
