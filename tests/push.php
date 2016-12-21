<?php
require __DIR__.'/bootstrap.php';




$total = 10;
for($i=0;$i<$total;$i++){
    $queue->push("test".$i,5);
}

