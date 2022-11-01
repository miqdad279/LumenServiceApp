<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;

class KeranjangsController extends Controller {

    public function index(){

        $keranjangs = Keranjang::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "keranjangs",
            "result" => $keranjangs
        ];

        return response()->json($keranjangs, 200);
    }
}