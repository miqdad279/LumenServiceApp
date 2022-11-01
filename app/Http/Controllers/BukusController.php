<?php

namespace App\Http\Controllers;

use App\Models\Buku;

class BukusController extends Controller {

    public function index(){

        $bukus = Buku::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "bukus",
            "result" => $bukus
        ];

        return response()->json($bukus, 200);
    }
}