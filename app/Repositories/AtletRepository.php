<?php

namespace App\Repositories;

use App\Models\Atlet;

class AtletRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Atlet();
    }
}
