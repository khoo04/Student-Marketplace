<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(){
        return view('payments.show');
    }
    public function create(){
        $fpx_buyerEmail = "khoozhenxian@gmail.com";
        $fpx_buyerName = "Khoo Zhen Xian";
        $private_key = env('PRIVATE_KEY');
        $fpx_txnAmount = 1.00;
        $fpx_sellerExOrderNo = "ABC000000001";
        return view('payments.index',compact(
            'fpx_buyerEmail',
            'fpx_buyerName',
            'private_key',
            'fpx_txnAmount',
            'fpx_sellerExOrderNo'
        ));
    }
}
