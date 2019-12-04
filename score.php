<?php
date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';

use think\Db;
use Goutte\Client;

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

$client = new Client();
$lists = Db::name('names')->where('name', 'like', '何%')->select();//->where('buyiju_dafen', 0)
foreach ($lists as $vo) {
    try {
        $crawler = $client->request('POST', 'https://xmcs.buyiju.com/dafen.php', ['xs' => '何', 'mz' => mb_substr($vo['name'], 1), 'action' => 'test']);
        //$response = $client->getResponse();
        //echo $response->getContent();
        $node = $crawler->filter('.content b font');
        if ($node && $node->count() == 1) {
            $score = $node->text();
            if (preg_match('/^[1-9]d*.d*|0.d*[1-9]d*$/', $score)) {
                Db::name('names')->where('id', $vo['id'])->update([
                    'buyiju_dafen' => $score
                ]);
            }
        }
    } catch (\Exception $e) {

    }
}
echo 'ok';
