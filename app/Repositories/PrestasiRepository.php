<?php

namespace App\Repositories;

use App\Models\Prestasi;

class PrestasiRepository extends Repository
{

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Prestasi();
    }
}
