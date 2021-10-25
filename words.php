<?php

date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';
require 'db.php';

use think\facade\Db;

ini_set('memory_limit', '-1');

$data = json_decode(file_get_contents('word.json'), true);
foreach ($data as $word) {
    Db::name('words')->insert($word);
}
echo 'ok';
