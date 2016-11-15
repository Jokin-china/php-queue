<?php
require __DIR__.'/bootstrap.php';




$total = 10;
for($i=0;$i<$total;$i++){
    $mysql_queue->push("test".$i,5);
}

