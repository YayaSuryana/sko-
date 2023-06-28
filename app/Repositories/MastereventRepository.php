<?php

namespace App\Repositories;

use App\Models\Masterevent;

class MastereventRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Masterevent();
    }
}
