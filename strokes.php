<?php
date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';

use think\facade\Db;

// 数据库配置信息设置（全局有效）
Db::setConfig([
    // 默认数据连接标识
    'default'     => 'mysql',
    // 数据库连接信息
    'connections' => [
        'mysql' => [
            // 数据库类型
            'type'     => 'mysql',
            // 主机地址
            'hostname' => '127.0.0.1',
            // 用户名
            'username' => 'root',
            // 密码
            'password'       => 'root',
            // 数据库名
            'database' => 'myphp',
            // 数据库编码默认采用utf8
            'charset'  => 'utf8',
            // 数据库表前缀
            'prefix'   => 'youyin_',
            // 数据库调试模式
            'debug'    => true,
        ],
    ],
]);

$lists = Db::name('names')->where('name', 'like', '何%')->select();//->where('buyiju_dafen', 0)
foreach ($lists as $vo) {
    $second_word = mb_substr($vo['name'], 1, 1);
    $third_word = mb_substr($vo['name'], 2, 1);

    //第二个字
    list($second_strokes, $second_strokes2) = get_word_strokes($second_word);
    //第三个字
    if ($third_word == $second_word) {
        list($third_strokes, $third_strokes2) = [$second_strokes, $second_strokes2];
    } else {
        list($third_strokes, $third_strokes2) = get_word_strokes($third_word);
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

function get_word_strokes($word)
{
    $word = Db::name('words')->where('word', $word)->find();
    if (!empty($word)) {
        $strokes = $word['strokes'];
        switch ($word['radicals']) {
            case '氵':
                $strokes2 = $strokes + 1;
                break;
            case '忄':
                $strokes2 = $strokes + 1;
                break;
            case '钅':
                $strokes2 = $strokes + 3;
                break;
            case '艹':
                $strokes2 = $strokes + 3;
                break;
            case '辶':
                $strokes2 = $strokes + 4;
                break;
            case '扌':
                $strokes2 = $strokes + 1;
                break;
            case '王':
                $strokes2 = $strokes + 1;
                break;
            default:
                $strokes2 = $strokes;
                break;
        }
    } else {
        $strokes2 = $strokes = 0;
    }
    return [$strokes, $strokes2];
}
