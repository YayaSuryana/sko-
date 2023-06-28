<?php

namespace App\Repositories;

use App\Models\Athlete;

class AthleteRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Athlete();
    }
}
