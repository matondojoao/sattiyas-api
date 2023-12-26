<?php

namespace App\Repositories\Public;

use App\Models\Newsletter;

class NewsletterRepository
{
    private $entity;

    public function __construct(Newsletter $model)
    {
        $this->entity = $model;
    }
    public function subscribe(array $data)
    {
        return $this->entity->create($data);
    }
}
