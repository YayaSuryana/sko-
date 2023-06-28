<?php

namespace App\Repositories;

use App\Models\Kode;

class KodeRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Kode();
    }
}
