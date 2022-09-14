<?php
declare(strict_types=1);

namespace App\JsonRpc;

interface ShopServiceInterface
{

    public function getShop(int $id): string;

    public function buyShop(int $id): string;
}
