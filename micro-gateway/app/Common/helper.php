<?php
declare(strict_types=1);

if (!function_exists('container')) {
    /**
     * 容器实例
     * @return \Psr\Container\ContainerInterface
     */
    function container(): object
    {
        return \Hyperf\Utils\ApplicationContext::getContainer();
    }
}

if (!function_exists('logger')) {
    /**
     * 记录日志
     * @param string $prefix 前缀
     * @return \Psr\Log\LoggerInterface
     */
    function logger($prefix = 'hyperf'): object
    {
        return container()->get(\Hyperf\Logger\LoggerFactory::class)->get($prefix);
    }
}

if (!function_exists('response_success')) {
    /**
     * 返回成功
     * @param $msg
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    function response_success($msg, $data = [], $code = 0): object
    {
        $responseData = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
        ];

        return container()->get(\Hyperf\HttpServer\Contract\ResponseInterface::class)->json($responseData);
    }
}

if (!function_exists('response_error')) {
    /**
     * 返回失败
     * @param $msg
     * @param array $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    function response_error($msg, $data = [], $code = 1): object
    {
        $responseData = [
            'code' => $code,
            'data' => $data,
            'msg' => $msg,
        ];

        return container()->get(\Hyperf\HttpServer\Contract\ResponseInterface::class)->json($responseData);
    }
}

if (!function_exists('hyperf_md5')) {
    /**
     * 加强版 md5
     * @param string $str 要加密的字符串
     * @param string $key 加密key
     * @return string
     */
    function hyperf_md5($str, $key = 'hyperf'): string
    {
        return '' === $str ? '' : md5(sha1($str) . $key);
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */
    function get_client_ip($type = 0, $adv = false): string
    {
        $server = container()->get(\Hyperf\HttpServer\Contract\RequestInterface::class)->getServerParams();

        $type = $type ? 1 : 0;
        static $ip = null;
        if (null !== $ip) {
            return $ip[$type];
        }

        if ($adv) {
            if ($server['proxy_add_x_forwarded_for']) {
                $arr = explode(',', $server['proxy_add_x_forwarded_for']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }
                $ip = trim($arr[0]);
            } else if ($server['http_x_forwarded_for']) {
                $arr = explode(',', $server['http_x_forwarded_for']);
                $pos = array_search('unknown', $arr);
                if (false !== $pos) {
                    unset($arr[$pos]);
                }

                $ip = trim($arr[0]);
            } elseif (isset($server['http_client_ip'])) {
                $ip = $server['http_client_ip'];
            } elseif (isset($server['remote_addr'])) {
                $ip = $server['remote_addr'];
            }
        } elseif (isset($server['remote_addr'])) {
            $ip = $server['remote_addr'];
        }
        // IP地址合法验证,兼容ipv6
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6) !== false) {
            $long = sprintf("%u", ip2long($ip));
            $ip = $long ? array($ip, $long) : array($ip, 0);
            return $ip[$type];
        } else {
            return '0.0.0.0';
        }
    }
}
