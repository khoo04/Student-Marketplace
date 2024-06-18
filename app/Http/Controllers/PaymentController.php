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
        $private_key = env('PRIVATE_KEY');
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
            $productID = $payment->order->product->id;

            $cart = $user->cart;
            $product = $cart->products()->where('product_id', $productID)->first();
    
            if ($product) {
                //Detach product from cart since is purchased
                $cart->products()->detach($productID);
            }

            $payment->payment_status = 'success';
            $payment->save();
            
            $payment->order()->update(['order_status' => 'processing']);

            $order = $payment->order;
            $product = $order->product;

            $new_quantity = $product->quantity_available - $order->quantity;
            $product->update(['quantity_available' => $new_quantity]);

            //Get address
            $address = $order->address;
            $full_address = $address->address_line_1 . ', ';
            $full_address .= $address->address_line_2 == null ? '' : $address->address_line_2 . ', ';
            $full_address .= $address->zip_code . ' ';
            $full_address .= $address->city . ', ';
            $full_address .= $address->state;
            
            return view('payments.receipt',compact('status','name','full_address','phone','transacno','issue_bank','transac_amount','dateTime'));
        }else if($status == 'Failed'){
            $payment->payment_status = 'failed';
            $payment->save();
            return redirect()->route('main')->with(['message' =>'Payment failed!', 'type' => 'alert']);
        }
    }

    public function showTestCallBack(){
        return view('payments.testcallback');
    }

    public function updateIsPaidStatus(Request $request){
        $transac_no = $request->input('transaction_no');

        $payment = Payment::where('transaction_no',$transac_no)->first();

        if ($payment){
            $payment->isPaid = true;
            $payment->save();
            return response()->json(['success' => true, 'payment' => $payment->toArray(), 'transaction_no' => $transac_no]);
        }
    }
}
