<!-- head -->
<?php include ROOT . '/template/head.php';?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
<!-- header -->
<?php include ROOT . '/template/header.php';?>
<div class="container">
    <h1>Список ближайших концертов</h1>
    <?php if (!empty($eventList)) : ?>
        <div class="event_list">
            <?php $i = 0; ?>
            <?php foreach ($eventList as $eventItem):?>
            <div class="event_item">
                <h2><?php echo $eventItem["title"]; ?></h2>
                <div class="poster">
                    <?php echo '<img src="'.$img_path.$eventItem["poster"].'"/>'; ?>
                </div>
                <div class="data_item date">
                    <span class="item_name">Дата: </span>
                    <?php echo Helper::formatDateForView($eventItem["date"]); ?>
                </div>
                <div class="data_item time">
                    <span class="item_name">Время: </span>
                    <?php echo Helper::formatTimeForView($eventItem["time"]); ?>
                </div>
                <?php
                echo '<div class="data_item prices"><span class="item_name">Цена: </span>';
                if($noTicketsAvailable[$i]){
                    echo 'Все билеты проданы';
                }
                else{
                echo ($price[$i]) ? $price[$i] . ' руб.' : $minMaxPriceArray[$i]["minPrice"] . " - "
                    . $minMaxPriceArray[$i]["maxPrice"] . ' руб.';
                }
                echo '</div>';
                ?>
                <h3>Анонс</h3>
                <div class="announce">
                    <?php echo $eventItem["announce"]; ?>
                </div>
                <a href="<?php echo 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/'.$eventItem["id"];?>" class="bay_btn btn">Купить билеты</a>
            </div>
            <?php $i++ ; ?>
            <?php endforeach;?>
        </div>

    <?php
    else : echo '<p>Список концертов пуст.</p>';
    endif;
    ?>

</div>

<!-- footer -->
<?php include ROOT . '/template/footer.php';?>
</body>
</html>
