<ul>
<?php foreach ($res as $key => $value) {
    echo '<li>'.$value['CARRIER'].PHP_EOL.'</li>';
    echo '<li>'.$value['SERVICE LEVEL'].PHP_EOL.'</li>';
    echo '<li>'.$value['RATE TYPE'].PHP_EOL.'</li>';
    echo '<li>'.$value['TOTAL'].PHP_EOL.'</li>';
    echo '<li>'.$value['TRANSIT TIME'].PHP_EOL.'</li>';
}

?>

</ul>
