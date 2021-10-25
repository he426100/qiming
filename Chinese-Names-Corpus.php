<?php

date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';
require 'db.php';

use think\facade\Db;

$i = 0;
$sex = ['女', '男', '未知'];
$file = fopen("Chinese_Names_Corpus_Gender（120W）.txt", "r") or exit("Unable to open file!");
//Output a line of the file until the end is reached
//feof() check if file read end EOF
while (!feof($file)) {
    $row = trim(fgets($file));
    if (++$i <= 832582) {
        continue;
    }
    $data = explode(',', $row);
    if (count($data) != 2 || !in_array($data[1], $sex)) {
        continue;
    }
    Db::name('names')->insert([
        'name' => $data[0],
        'sex' => $data[1] == '女' ? 0 : ($data[1] == '男' ? 1 : 2)
    ]);
}
fclose($file);

echo 'ok';
// $lists = Db::name('names')->where('name', 'like', '朱%')->select();
// foreach ($lists as $vo) {
//     file_put_contents('朱.txt', $vo['name'].','.$sex[$vo['sex']].PHP_EOL, FILE_APPEND);
// }
// echo 'ok';
