<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Request $request){
        $fpx_buyerEmail = $request->email;
        $fpx_buyerName = $request->name;
        $private_key = "6258342C-47BA-4AD5-9135-9144FBD09395";
        $fpx_txnAmount = $request->amount;
        $buyer_id = auth()->user()->id;
        $order_id = $request->Oid;
        $address_id = $request->addressID;
        //Generate Order No
        $fpx_sellerExOrderNo = "TRANSC_" . date('Y') . date('m') . date('d') . str_pad($order_id,5,"0",STR_PAD_LEFT);;

        $payment = Payment::where('transaction_no',$fpx_sellerExOrderNo)->first();

        if (!$payment){
            Payment::create([
                'total_payment' => $fpx_txnAmount,
                'payment_status' => 'pending',
                'order_id' => $order_id,
                'user_id' => $buyer_id,
                'transaction_no' => $fpx_sellerExOrderNo,
                'isPaid' => false,
            ]);
        }
        
        Order::find($order_id)->update(['address_id' => $address_id]);

        return view('payments.index',compact(
            'fpx_buyerEmail',
            'fpx_buyerName',
            'private_key',
            'fpx_txnAmount',
            'fpx_sellerExOrderNo'
        ));
    }

    public function callback(Request $request){
        $status = $request->Status;
        $user = auth()->user();
        $name = $user->first_name . ' ' . $user->last_name;
        $phone = $user->phone_num;
        $transacno = $request->Fpx_SellerOrderNo;
        $issue_bank = $request->Fpx_BuyerBankBranch;
        $transac_amount = $request->TransactionAmount;
        $dateTime = $request->DateTime;

        $payment = Payment::where('transaction_no',$transacno)->first();
        if ($status == 'Success'){
            $payment->payment_status = 'success';
            $payment->save();
            
            $payment->order()->update(['order_status' => 'processing']);
            return view('payments.receipt',compact('status','name','phone','transacno','issue_bank','transac_amount','dateTime'));
        }else if($status == 'Failed'){
            $payment->payment_status = 'failed';
            $payment->save();
            redirect()->route('main')->with(['message' =>'Payment failed!', 'type' => 'alert']);
        }
    }

    public function showTestCallBack(){
        return view('payments.testcallback');
    }
}
