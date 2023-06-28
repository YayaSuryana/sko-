<?php

namespace App\Repositories;

use App\Models\Profileatlet;

class ProfileatletRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Profileatlet();
    }
}
