<?php

namespace App\Repositories\Traits;

trait TraitRepository
{
    public function getAuthUser()
    {
        return auth()->user();
    }
}
