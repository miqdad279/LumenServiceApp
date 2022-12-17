<?php

namespace App\Http\Controllers\PublicController;

use App\Models\Buku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukusController extends Controller {

    public function index(Request $request){
        $bukus = Buku::with('user')->OrderBy("id", "DESC")->paginate(10)->toArray();

        $response = [
            "total_count" => $bukus["total"],
            "limit" => $bukus["per_page"],
            "pagination" => [
                "next_page" => $bukus["next_page_url"],
                "current_page" => $bukus["current_page"]
            ],
            "data" => $bukus["data"],
        ];
        return response()->json($response, 200);
    }

    public function show($id){
        $buku = Buku::with(['user' => function($query){
            $query->select('id', 'name');
        } ])->find($id);

        if(!$buku){
            abort(404);
        }
        return response()->json($buku, 200);
    }
}