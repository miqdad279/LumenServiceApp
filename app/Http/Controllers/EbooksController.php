<?php

namespace App\Http\Controllers;

use App\Models\Ebook;

class EbooksController extends Controller {

    public function index(){

        $ebooks = Ebook::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "ebooks",
            "result" => $ebooks
        ];

        return response()->json($ebooks, 200);
    }
}