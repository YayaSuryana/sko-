<?php

namespace App\Repositories;

use App\Models\Cabor;

class CaborRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Cabor();
    }
}
