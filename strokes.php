<?php

date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';
require 'db.php';

use think\facade\Db;

$lists = Db::name('names')->where('name', 'like', '何%')->select();
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
