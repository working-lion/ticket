<!-- head -->
<?php include ROOT . '/template/head.php'; ?>
<?php //require_once(ROOT . '/template/head.php');?>
<body>
    <!-- header -->
    <?php include ROOT . '/template/header.php'; ?>

    <div class="container event_id">
        <?php if(!empty($eventItem)) : ?>
        <h1><?php echo $eventItem["title"]; ?></h1>
        <div class="event_item_id">
            <div class="poster">
                <?php echo '<img src="' . $img_path . $eventItem["poster"] . '"/>'; ?>
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
            <h3>Цены: </h3>
            <div class="data_item price"><span class="item_name">Ряд 1-5: </span>
                <?php echo $priceList[0]["price"] . ' руб.'; ?>
            </div>
            <div class="data_item price"><span class="item_name">Ряд 6-10: </span>
                <?php echo $priceList[1]["price"] . ' руб.'; ?>
            </div>
            <div class="data_item price"><span class="item_name">Ряд 11-15: </span>
                <?php echo $priceList[2]["price"] . ' руб.'; ?>
            </div>
            <h3>Коротко о концерте</h3>
            <div class="announce">
                <?php echo $eventItem["announce"]; ?>
            </div>
            <div class="available_places">
                <h2>Схема зала</h2>
                <form action="" method="post">
                    <input type="hidden" name="eventId" value="<?php echo $eventId; ?>">
                    <table class="ticket_list">
                        <?php
                        //ВНИМАТЕЛЬНЕЕ с индексами (места - с 1, массивы - с 0)
                        for ($i = 1; $i < $roomSizeArray["row_count"] + 1; $i++) {
                            echo '<tr>';
                            for ($j = 1; $j < $roomSizeArray["place_count"] + 1; $j++) {
                                echo '<td class="checkbox"><input type="checkbox" id="' . $i . $j .
                                '" class="plaseListCheckbox" value="' . $i . '_' . $j . '" name="checkedTicketList[]" ' .
                                ((!empty($boughtTickets[$i][$j])) ? 'disabled' : '') .
                                '><label for="' . $i . $j . '"><span class="place_index index_row">' . $i .
                                '</span><span class="place_index">' . $j . '</span></label></td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                    <?php echo (!empty($error) ? '<p class="error">' . $error . '</p>' : ''); ?>
                    <input type="submit" name="go_to_order" class="btn btn green_btn"
                        value="Оформить заказ" <?php echo ($noTicketsAvailable) ?
                        'onclick="this.disabled=true;"' : ''; ?>>
                </form>

            </div>
        </div>
        <?php else : echo 'Концерт не найден.';
        endif;
        ?>
    </div>


    <!-- footer -->
    <?php include ROOT . '/template/footer.php'; ?>
</body>
</html>
