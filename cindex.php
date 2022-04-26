<?php
include 'dbconnect.php';
$start = microtime(true);
// $mysqli = mysqli_connect('127.0.0.1', 'root', 'Caydathan_81', 'salebookonl');

$cache_file = "cache/index.cache.php";
if (file_exists($cache_file)) {
    echo "From cache";
    include($cache_file);
} else {
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

    $handle = fopen($cache_file, 'w');
    fwrite($handle, $str);
    fclose($handle);
    echo "cache created";
    echo $str;
}

$end = microtime(true);
echo round($end - $start, 4);
