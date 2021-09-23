<?php

namespace App\Sharp\Policies;

use App\Models\User;

class CompanyDashboardPolicy
{

    /**
     * @param User $user
     * @return bool
     */
    public function view(User $user)
    {
        return $user->hasGroup("boss");
    }
}
