<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukusController extends Controller {

    public function index(){

        $bukus = Buku::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "bukus",
            "result" => $bukus
        ];

        return response()->json($bukus, 200);
    }
    
    public function store(Request $request){
        $input = $request->all();
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

    
    // public function update(Request $request, $id)
    // {
        //     $acceptHeader = $request->header('Accept');
        
        //     if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){
            //         $contentTypeHeader = $request->header('Content-Type');
            
            //         if($contentTypeHeader === 'application/json'){
                //             $input = $request->all();
                
    //             $buku = Buku::find($id);

    //             if(!$buku){
    //                 abort(404);
    //             }

    //             $buku->fill($input);
    //             $buku->save();

    //             return response()->json($buku, 200);
    //         } else {
    //             return response('Unsupported Media Type', 415);
    //         }
    //     } else {
    //         return response('Not Acceptable', 486);
    //     }
    // }

}