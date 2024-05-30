<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Redirect To Payment Gateway</title>
</head>
<body>
    <div class="container" style="margin-top: 5%;">
    <form name="form1" id="form1" method="post" action="https://directpay.my/fpx/pay">
        @csrf
        <input type=hidden value="{{ $fpx_buyerName }}" name="BuyerName">
        <input type=hidden value="{{ $fpx_buyerEmail }}" name="BuyerEmail">
        <input type=hidden value="{{$private_key}}" name="PrivateKey">
        <input type=hidden value="{{ $fpx_txnAmount }}" name="Amount">
        <input type=hidden value="{{$fpx_sellerExOrderNo}}" name="SellerOrderNo">

    </form>
</div>

<script>
    var values = $("#form1").serialize();
    $('#form1').submit();
</script>
</body>
</html>
