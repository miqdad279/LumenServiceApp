<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class BukusController extends Controller {

    public function index(){

        $bukus = Buku::OrderBy("id", "DESC")->paginate(2)->toArray();
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
    
    public function store(Request $request){
        $input = $request->all();
        $validationRules = [
            'buku_id' => 'required|exists:users,id',
            'judul_buku' => 'required|min:5',
            'penulis' => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'harga' => 'required|min:5',
            'rilis' => 'required|min:4',
        ];

        $validator = Validator::make($input, $validationRules);

        if($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        
        $buku = Buku::create($input);
        return response()->json($buku, 200);
    }

    public function show($id){
        $buku = Buku::find($id);

        if(!$buku){
            abort(404);
        }

        return response()->json($buku, 200);
    }

    public function update(Request $request, $id){
        $input = $request->all();
        $buku = Buku::find($id);
        
        if(!$buku){
            abort(404);
        }
        
        $buku->fill($input);
        $buku->save();
        
        return response()->json($buku, 200);
    }
    
    public function destroy($id){
        
        $buku = Buku::find($id);

        if(!$buku){
            abort(404);
        }
        
        $buku->delete();
        $message = ['message' => 'deleted successfully', 'buku_id'];
        
        return response()->json($buku, 200);
    }
}