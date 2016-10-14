<?php
require __DIR__.'bootstrap.php';



$total = 10000;
for($i=0;$i<$total;$i++){
    $mysql_queue->push("test".$i);
}

