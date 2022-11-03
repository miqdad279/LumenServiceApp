<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukusController extends Controller {

    public function index(Request $request){

        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){

            $bukus = Buku::OrderBy("id", "DESC")->paginate(10);

            if($acceptHeader === 'application/json') {

                return response()->json($bukus, 200);
            } else {

                $xml = new \SimpleXMLElement('<bukus/>');
                foreach ($bukus->items('data') as $item) {
                    $xmlItem = $xml->addChild('buku');

                    $xmlItem->addChild('id', $item->id);
                    $xmlItem->addChild('buku_id', $item->buku_id);
                    $xmlItem->addChild('judul_buku', $item->judul_buku);
                    $xmlItem->addChild('penulis', $item->penulis);
                    $xmlItem->addChild('deskripsi', $item->deskripsi);
                    $xmlItem->addChild('harga', $item->harga);
                    $xmlItem->addChild('rilis', $item->rilis);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }
        } else{
            return response('Not Acceptable!', 406);
        }
    }
    
    public function store(Request $request){

        $acceptHeader = $request->header('Accept');

        if($acceptHeader === 'application/json' || $acceptHeader === 'application/xml'){

            $contentTypeHeader = $request->header('Content-Type');

            if($contentTypeHeader === 'application/json') {
                $input = $request->all();
                $buku = Buku::create($input);

                return response()->json($buku, 200);
            } else {
                return response('Unsupported Media Type', 415);
            }
        } else {
            return response('Not Acceptable', 406);
        } 
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