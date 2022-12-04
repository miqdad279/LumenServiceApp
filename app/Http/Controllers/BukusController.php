<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;


class BukusController extends Controller {

    public function index(Request $request){

        if(Gate::denies('read-buku')) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are unauthorized'
            ], 403);
        }

        if(Auth::user()->role === 'admin') {
            $bukus = Buku::OrderBy("id", "DESC")->paginate(2)->toArray();
        }else {
            $bukus = Buku::where(['id' => Auth::user()->id])->OrderBy("id", "DESC")->paginate(2)->toArray();
        }

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
        $buku = Buku::create($input);

        // Authtorization

        if(Gate::denies('create-buku', $buku)) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are unauthorized',
            ]);
        }
        // authorization end

        $validationRules = [
            // 'buku_id' => 'required|exists:users,id',
            'buku_id' => 'required|min:3',
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

        // Authtorization

        if(Gate::denies('read-detail-buku', $buku)) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are unauthorized',
            ]);
        }
        // authorization end

        return response()->json($buku, 200);
    }

    public function update(Request $request, $id){
        $input = $request->all();
        $buku = Buku::find($id);
        
        if(!$buku){
            abort(404);
        }

        // Authtorization
        // check if current user is authorized to do this action

        if(Gate::denies('update-buku', $buku)) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are unauthorized',
            ]);
        }
        // authorization end

        $validationRules = [
            'buku_id' => 'required|min:3',
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
        
        $buku->fill($input);
        $buku->save();
        
        return response()->json($buku, 200);
    }
    
    public function destroy($id){
        
        $buku = Buku::find($id);

        if(!$buku){
            abort(404);
        }

        // Authtorization

        if(Gate::denies('delete-buku', $buku)) {
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are unauthorized',
            ]);
        }
        // authorization end
        
        $buku->delete();
        $message = ['message' => 'deleted successfully', 'id' => $id];
        
        return response()->json($message, 200);
    }
}