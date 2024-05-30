<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request){
        $fpx_buyerEmail = $request->email;
        $fpx_buyerName = $request->name;
        $private_key = "6258342C-47BA-4AD5-9135-9144FBD09395";
        $fpx_txnAmount = $request->amount;

        $order_id = $request->order_id;
        //Generate Order No
        $fpx_sellerExOrderNo = "TRANSC_" . date('Y') . date('m') . date('d') . str_pad($order_id,5,"0",STR_PAD_LEFT);;

        return view('payments.index',compact(
            'fpx_buyerEmail',
            'fpx_buyerName',
            'private_key',
            'fpx_txnAmount',
            'fpx_sellerExOrderNo'
        ));
    }

    public function callback(Request $request){
        //$request
        //return view('payments.receipt');
    }

    public function showTestCallBack(){
        return view('payments.testcallback');
    }
}
