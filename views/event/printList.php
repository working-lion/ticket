<?php

$img_path = $_SESSION["img_path"];
$css_path = $_SESSION["css_path"];

if(!empty($eventList)){

    echo '<div class = "event_list">';
    $i = 0;// индекс концерта
    foreach ($eventList as $eventItem) {
        echo '<div class="event_item">
        <h2>' . $eventItem["title"] . '</h2>
        <div class="poster">
            <img src="' . $img_path . $eventItem["poster"] . '"/>
        </div>
        <div class="data_item date"><span class="item_name">Дата: </span>' .
            Helper::formatDateForView($eventItem["date"]) .
        '</div>
        <div class="data_item time"><span class="item_name">Время: </span>' .
            Helper::formatTimeForView($eventItem["time"]) .
        '</div>';
        echo '<div class="data_item prices"><span class="item_name">Цена: </span>';
        if($noTicketsAvailable[$i]){
            echo 'Все билеты проданы';
        }
        else{
        echo ($price[$i]) ? $price[$i]. ' руб.' : $minMaxPriceArray[$i]["minPrice"] . " - "
            . $minMaxPriceArray[$i]["maxPrice"]. ' руб.';
        }
        echo '</div>
        <div class="data_item">
            <h3>Анонс</h3>
            <div class="announce">' .
                $eventItem["announce"] .
            '</div>
        </div>';
        echo '<a href=" /event/' . $eventItem["id"] . '" class="bay_btn btn">Купить билеты</a>
    </div>';
        $i++;
    }
    echo '</div>';
    echo '<a href="/event" class="to_event_list">Перейти к списку концертов</a>';
}
else {
    echo '<p>Список концертов пока пуст.</p>';
}
