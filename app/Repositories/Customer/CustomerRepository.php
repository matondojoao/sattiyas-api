<?php

namespace App\Repositories\Customer;

use App\Repositories\Traits\TraitRepository;

class CustomerRepository
{
    use TraitRepository;

    public function getCustomerInfo()
    {
        $user = $this->getAuthUser();

        if ($user) {
            $user->load('billingAddress', 'shippingAddress');
        }

        return $user;
    }

    public function update(array $data)
    {
        $user = $this->getAuthUser();

        if (isset($data['photo'])) {
            $image = $data['photo'];
            $path =  $image->store('avatar', 'public');
            $data['photo_path'] = $path;
        }

        $user->update($data);

        return $user;
    }
}
