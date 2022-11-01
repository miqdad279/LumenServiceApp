<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class ProduksController extends Controller {

    public function index(){

        $produks = Produk::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "produks",
            "result" => $produks
        ];

        return response()->json($produks, 200);
    }
}