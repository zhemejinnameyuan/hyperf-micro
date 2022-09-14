<?php
declare(strict_types=1);

namespace App\JsonRpc;

interface MemberServiceInterface
{
    public function userInfo(int $uid): string;

}
