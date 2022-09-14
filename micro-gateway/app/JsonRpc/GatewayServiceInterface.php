<?php
declare(strict_types=1);

namespace App\JsonRpc;

interface GatewayServiceInterface
{
    public function check(): string;

}
