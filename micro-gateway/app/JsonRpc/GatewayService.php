<?php

namespace App\JsonRpc;

use Hyperf\Redis\RedisFactory;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;

/**
 * Class CalculatorService
 * @RpcService(name="GatewayService", protocol="jsonrpc-http", server="jsonrpc-http",publishTo="nacos")
 */
class GatewayService implements GatewayServiceInterface
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

    public function check(): string
    {
        return 'gateway-info';
    }

}
