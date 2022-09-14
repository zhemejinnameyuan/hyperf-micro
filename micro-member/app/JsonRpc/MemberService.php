<?php

namespace App\JsonRpc;

use Hyperf\Redis\RedisFactory;
use Hyperf\RpcServer\Annotation\RpcService;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;

/**
 * Class CalculatorService
 * @RpcService(name="MemberService", protocol="jsonrpc-http", server="jsonrpc-http",publishTo="nacos")
 */
class MemberService implements MemberServiceInterface
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

    public function userInfo(int $uid): string
    {
        $this->redisClient->set("api-member",'userInfo');

        $client = ApplicationContext::getContainer()->get(ShopServiceInterface::class);
        return $client->getShop(1);
    }
}
