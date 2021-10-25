<?php

date_default_timezone_set('Asia/Shanghai');
require __DIR__ . '/vendor/autoload.php';
require 'db.php';

use Goutte\Client;
use think\facade\Db;

$client = new Client();
$lists = Db::name('names')->where('name', 'like', '何%')->where('buyiju_dafen', 0)->select();
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
