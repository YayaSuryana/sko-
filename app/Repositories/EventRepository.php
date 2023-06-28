<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Event();
    }
}
