<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Atlet;
use App\Models\Skill;
use App\Models\Fisik;


class DocumentController extends Controller
{
    public function show($id)
    {
        $collection = Atlet::find($id);
        $collection_skill = Skill::where('atlet_id', $id)->first();
        $collection_fisik = Fisik::where('atlet_id', $id)->first();
        return view("stisla.document.index", compact('collection','collection_skill','collection_fisik'));
    }
}
