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

$lists = Db::name('names')->where('name', 'like', '何%')->select();//->where('buyiju_dafen', 0)
foreach ($lists as $vo) {
    $second_word = mb_substr($vo['name'], 1, 1);
    $third_word = mb_substr($vo['name'], 2, 1);

    //第二个字
    $word = Db::name('words')->where('word', $second_word)->find();
    if (!empty($word)) {
        $second_strokes = $word['strokes'];
        switch ($word['radicals']) {
            case '氵':
                $second_strokes2 = $second_strokes + 1;
                break;
            case '忄':
                $second_strokes2 = $second_strokes + 1;
                break;
            case '钅':
                $second_strokes2 = $second_strokes + 3;
                break;
            case '艹':
                $second_strokes2 = $second_strokes + 3;
                break;
            case '辶':
                $second_strokes2 = $second_strokes + 4;
                break;
            case '扌':
                $second_strokes2 = $second_strokes + 1;
                break;
            case '王':
                $second_strokes2 = $second_strokes + 1;
                break;
            default:
                $second_strokes2 = $second_strokes;
                break;
        }
    } else {
        $second_strokes2 = $second_strokes = 0;
    }

    //第三个字
    if (!empty($third_word)) {
        if ($third_word == $second_word) {
            $third_strokes = $second_strokes;
            $third_strokes2 = $second_strokes2;
        } else {
            $word = Db::name('words')->where('word', $third_word)->find();
            if (!empty($word)) {
                $third_strokes = $word['strokes'];
                switch ($word['radicals']) {
                    case '氵':
                        $third_strokes2 = $third_strokes + 1;
                        break;
                    case '忄':
                        $third_strokes2 = $third_strokes + 1;
                        break;
                    case '钅':
                        $third_strokes2 = $third_strokes + 3;
                        break;
                    case '艹':
                        $third_strokes2 = $third_strokes + 3;
                        break;
                    case '辶':
                        $third_strokes2 = $third_strokes + 4;
                        break;
                    case '扌':
                        $third_strokes2 = $third_strokes + 1;
                        break;
                    case '王':
                        $third_strokes2 = $third_strokes + 1;
                        break;
                    default:
                        $third_strokes2 = $third_strokes;
                        break;
                }
            } else {
                $third_strokes2 = $third_strokes = 0;
            }
        }
    } else {
        $third_strokes2 = $third_strokes = 0;
    }

    Db::name('names')->update([
        'id' => $vo['id'],
        'second_strokes' => $second_strokes,
        'second_strokes2' => $second_strokes2,
        'third_strokes' => $third_strokes,
        'third_strokes2' => $third_strokes2,
    ]);
}
echo 'ok';
