<?php

namespace App\JsonRpc;

use Hyperf\Redis\RedisFactory;
use Hyperf\RpcServer\Annotation\RpcService;
use Psr\Container\ContainerInterface;

/**
 * Class CalculatorService
 * @RpcService(name="ShopService", protocol="jsonrpc-http", server="jsonrpc-http",publishTo="nacos")
 */
class ShopService implements ShopServiceInterface
{
    /**
     * 容器
     * @var ContainerInterface
     */
    public $container;

    /**
     * redis客户端
     * @var RedisFactory
     */
    public $redisClient;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->redisClient = $this->container->get(RedisFactory::class)->get('default');
    }

    public function getShop(int $id): string
    {
        $this->redisClient->set("api-shop", time());
        return 'shop-info:' . time();
    }

    public function buyShop(int $id): string
    {
        $this->redisClient->set("api-buy-shop", time());
        return 'buyShop-info:' . time();
    }

}
