<?php
date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';

use think\Db;

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

ini_set('memory_limit', '-1');

$data = json_decode(file_get_contents('word.json'), true);
foreach ($data as $word) {
    Db::name('words')->insert($word);
}
echo 'ok';
