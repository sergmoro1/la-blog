<?php

namespace App\Console\Commands\Rbac\Rules;

use Illuminate\Support\Facades\Auth;
use Yiisoft\Rbac\Item;
use Yiisoft\Rbac\RuleContext;
use Yiisoft\Rbac\RuleInterface;
use App\Models\User;
 
/**
 * Checks if current user is admin.
 */
class AdminRule implements RuleInterface
{
    public function execute(?string $userId, Item $item, RuleContext $context): bool
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            return $role == User::ROLE_ADMIN;
        }
        return false;
    }
}
