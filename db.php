<?php

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
            'password' => 'root',
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
