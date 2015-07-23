<?php

$fd = fopen('crisis.csv', 'rb');
while ($line = fgetcsv($fd)) {
    $line[1] = str_replace('\n', "\n", $line[1]);
    print_r($line);
}
fclose($fd);
