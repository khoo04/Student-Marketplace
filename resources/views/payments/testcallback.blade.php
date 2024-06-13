<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Call Page Page</title>
</head>
<body>
    <form action="{{route("payments.callback")}}" method="post">
        @csrf
        <input type="text" name="Status" value="Success" />
        <input type="text" name="Fpx_SellerOrderNo" value="TRANSC_2024060800012" />
        <input type="text" name="TransactionAmount" value="1.70" />
        <input type="hidden" name="Fpx_SellerExOrderNo" value="DirectPayTest20231227201201" />
        <input type="hidden" name="Fpx_DebitAuthCode" value="00" />
        <input type="hidden" name="Fpx_BuyerBankBranch" value="BANK ISLAM" />
        <input type="hidden" name="Fpx_FpxTxnId" value="2311151056590237" />
        <input type="hidden" name="DateTime" value="11/15/2023 1:57:08 PM" />
        <input type="submit" value="Submit" />
    </form>
</body>
</html>