<?php

date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';

use think\facade\Db;

Db::setConfig([
    // 数据库类型
    'type'           => 'mysql',
    // 服务器地址
    'hostname'       => '127.0.0.1',
    // 数据库名
    'database'       => 'myphp',
    // 用户名
    'username'       => 'root',
    // 密码
    'password'       => 'root',
    // 端口
    'hostport'       => '',
    // 连接dsn
    'dsn'            => '',
    // 数据库连接参数
    'params'         => [],
    // 数据库编码默认采用utf8
    'charset'        => 'utf8',
    // 数据库表前缀
    'prefix'         => 'youyin_',
    // 数据库调试模式
    'debug'          => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
]);

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
