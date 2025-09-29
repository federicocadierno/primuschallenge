<ul>
<?php foreach ($res['formatted'] as $key => $value) {
    echo '<li>'.$value['CARRIER'].PHP_EOL.'</li>';
    echo '<li>'.$value['SERVICE LEVEL'].PHP_EOL.'</li>';
    echo '<li>'.$value['RATE TYPE'].PHP_EOL.'</li>';
    echo '<li>'.$value['TOTAL'].PHP_EOL.'</li>';
    echo '<li>'.$value['TRANSIT TIME'].PHP_EOL.'</li>';
}

?>
</ul>
<hr />
<h2>Cheapest Rates Per Service Level</h2>
<ul>
<?php foreach ($res['cheapest'] as $key => $value) {
    echo '<li>'.$value['CARRIER'].PHP_EOL.'</li>';
    echo '<li>'.$value['SERVICE LEVEL'].PHP_EOL.'</li>';
    echo '<li>'.$value['RATE TYPE'].PHP_EOL.'</li>';
    echo '<li>'.$value['TOTAL'].PHP_EOL.'</li>';
    echo '<li>'.$value['TRANSIT TIME'].PHP_EOL.'</li>';
}

?>
</ul>