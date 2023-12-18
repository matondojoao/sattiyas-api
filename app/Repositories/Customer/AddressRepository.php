<?php

namespace App\Repositories\Customer;

use App\Repositories\Traits\TraitRepository;

class AddressRepository
{
    use TraitRepository;

    public function createOrUpdatebillingAddress(array $data)
    {
        $id = $data['id'] ?? null;

        return $this->getAuthUser()->billingAddress()->updateOrCreate(['id' => $id], $data);
    }
}
