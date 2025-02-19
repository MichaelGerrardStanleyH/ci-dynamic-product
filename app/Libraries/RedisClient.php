<?php

namespace App\Libraries;

use Predis\Client;
use Config\Redis as RedisConfig;

class RedisClient
{

    protected $redis;

    public function __construct()
    {
        // Ambil konfigurasi Redis
        $config = new RedisConfig();
        $this->redis = new Client([
            'scheme'   => 'tcp',
            'host'     => $config->default['host'],
            'port'     => $config->default['port'],
            'password' => $config->default['password'],
            'database' => $config->default['database']
        ]);
    }

    public function set($key, $value, $ttl = 3600)
    {
        $this->redis->set($key, $value);
        $this->redis->expire($key, $ttl);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function delete($key)
    {
        $this->redis->del([$key]);
    }
}
