<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CustomersController extends Controller {

    public function index(){

        $customers = Customer::OrderBy("id", "DESC")->paginate(10);

        $outPut = [
            "message" => "customers",
            "result" => $customers
        ];

        return response()->json($customers, 200);
    }
}