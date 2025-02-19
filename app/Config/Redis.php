<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;


class Redis extends BaseConfig
{
    public $default = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => null,
        'database' => 0
    ];
}
