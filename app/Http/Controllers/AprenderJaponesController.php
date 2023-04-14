<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\AprenderJapones;

class AprenderJaponesController extends Controller
{

    function index(){

        $datos = AprenderJapones::where('id','>=',1)->get();
        $seleccionado = random_int(0, sizeof($datos));

        return view('aprender-japones-index',[
            "datos" => $datos,
            "seleccionado" => $seleccionado
        ]);
    }
}

