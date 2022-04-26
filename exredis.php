<?php 
include 'dbconnect.php';
require_once 'layout/header.php';
require "vendor/predis/predis/autoload.php";
Predis\Autoloader::register();
try {
    $table = "Books";
    $redis = new Predis\Client();
    if (($redis->exists($table)) && ($redis->llen($table) > 0)) {
        $arList = $redis->lrange($table, 0, -1);
    }else{
        $mysqli = new Database();
        $mysqli->select('books', '*',null, null, 'id', 5);
        $rows = $mysqli->getResult();
        $str = "<table class='table-hover'>";
        $str .= "<tr>
                    <th class='col-3'>title</th>
                    <th class='col-2'>image</th>
                    <th class='col-1'>price</th>
                    <th class='col-1'></th>
                </tr>";
        foreach ($rows as $row) {
            $str .= "<tr><td>" . $row['title'] . "</td>
                    <td> <img style='width: 150px' src='" . $row['avatar'] . "'> </td>
                    <td>" . $row['price'] . "</td><td></td></tr>";
        }
        $str .= "</table>";
        
        $redis->lpush($table, $str);
        $arList = $redis->lrange($table, 0, 1);
    }
    
   foreach ($arList as $key => $value) {
       echo "<pre>";
        print_r($value);
   }
    
} catch (Exception $e) {
    echo "couldnot connect";
    echo $e->getMessage();
}
require_once 'layout/footer.php';
?>