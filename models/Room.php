<?php

class Room {
    /**
     * Возвращает количество рядов и мест в зале
     */
    public static function getRoomSize($roomId) {
        $db = Db::getConnection();
        
        $roomSizeArray = array();
        //считываем данные о билетах
        $sql = 'SELECT row_count, place_count FROM room WHERE id = :roomId';
        
        $result = $db->prepare($sql);
        $result->bindParam(':roomId', $roomId, PDO::PARAM_INT);
        $result->execute();
        
        $row = $result->fetch();
        
        $roomSizeArray["row_count"] = $row["row_count"];
        $roomSizeArray["place_count"] = $row["place_count"];
                  
        return $roomSizeArray;
    }
    
    /**
     * Возвращает массив залов
     */
    public static function getRoomList() {
        $db = Db::getConnection();
        
        $roomList = array();
        //считываем данные о билетах
        $sql = 'SELECT * FROM room';
        
        $result = $db->prepare($sql);
        $result->execute();
        
        $i = 0;
        while($row = $result->fetch()){
            $roomList[$i]["id"] = $row["id"];
            $roomList[$i]["row_count"] = $row["row_count"];
            $roomList[$i]["place_count"] = $row["place_count"];
            $i++;
        }
        return $roomList;
    }
}

