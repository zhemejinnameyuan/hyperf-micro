<?php
declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use App\JsonRpc\GatewayService;
use App\JsonRpc\GatewayServiceInterface;
use App\JsonRpc\ShopServiceInterface;
use App\JsonRpc\MemberServiceInterface;
use Hyperf\RateLimit\Annotation\RateLimit;
use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Container\ContainerInterface;

class IndexController extends AbstractController
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


    public function index()
    {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        return [
            'method' => $method,
            'message' => "Hello {$user}.",
        ];
    }

    public function shop()
    {
        $client = ApplicationContext::getContainer()->get(ShopServiceInterface::class);
        return $client->getShop(1);
    }

    public function buyShop()
    {
        $client = ApplicationContext::getContainer()->get(ShopServiceInterface::class);
        return $client->buyShop(1);
    }

    /**
     * @return string
     * @RateLimit(create=1, capacity=3)
     */
    public function member()
    {
        $this->redisClient->set("api-gateway", 'member');
        $client = ApplicationContext::getContainer()->get(MemberServiceInterface::class);
        return $client->userInfo(1);
    }

    public function gateway()
    {
        $client = ApplicationContext::getContainer()->get(GatewayServiceInterface::class);
        return $client->check();
    }
}
