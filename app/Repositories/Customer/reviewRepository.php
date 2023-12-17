<?php

namespace App\Repositories\Customer;

use App\Models\Review;
use App\Repositories\Traits\TraitRepository;

class reviewRepository
{
    use TraitRepository;
    private $entity;

    public function __construct(Review $model)
    {
        $this->entity= $model;
    }

    public function create(array $data)
    {

        $data['user_id'] = $this->getAuthUser()->id;

        return $this->entity->create($data);
    }
}
