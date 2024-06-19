@extends('components.layout')

@section('title')
    <title> Student Marketplace | Receipt </title>
@endsection

@section('head')
    <style>
        hr {
            display: block;
            margin-block-start: 0.5em;
            margin-block-end: 0.5em;
            margin-inline-start: auto;
            margin-inline-end: auto;
            unicode-bidi: isolate;
            overflow: hidden;
            border-style: inset;
            border-width: 1px;
        }

        .bold {
            font-weight: bold;
        }

        .container {
            width: 500px;
            padding: 1rem;
            margin: auto;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
            background-color: white;
            box-shadow: 2px 2px 16px var(--clr-secondary-400);
        }

        .details p {
            margin-bottom: 0.5rem;
        }

        .button-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            column-gap: 1rem;
            width: 100%;
        }

        .action-btn {
            padding: 6px 10px;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        #main-page-btn {
            border: 1px solid var(--clr-secondary);
            background-color: transparent;
            transition: background-color .2s;
        }

        #main-page-btn:hover {
            color: white;
            background-color: var(--clr-secondary-800);
        }

        #view-order-btn {
            border: 1px solid transparent;
            color: white;
            background-color: var(--clr-primary);
            transition: background-color .2s;
        }

        #view-order-btn:hover {
            border: 1px solid var(--clr-primary-dark);
            background-color: var(--clr-primary-dark);
            
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="header">
            <h1>Receipt</h1>
        </div>
        <hr />
        <div class="content">
            <div class="details customer">
                <p><span class="bold">Customer Name:</span> {{ $name }}</p>
                <p><span class="bold">Phone Number:</span> {{ $phone }}</p>
                <p><span class="bold">Address:</span> {{ $full_address }}</p>
            </div>
            <hr />
            <div class="details payment">
                <p><span class="bold">Transaction No: </span>{{ $transacno }}</p>
                <p><span class="bold">Issue Bank:</span> {{ $issue_bank }}</p>
                <p><span class="bold">Transcation Amount:</span> RM {{ $transac_amount }}</p>
                <p><span class="bold">Date Time:</span> {{ $dateTime }}</p>
            </div>
            <hr />
            <div class="details order">
                <p><span class="bold">Order Status:</span> Processing</p>
            </div>
        </div>
        <div class="button-section">
            <button type="button" class="action-btn" id="main-page-btn">Back to Main Page</button>
            <button type="button" class="action-btn" id="view-order-btn">View My Order</button>
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $("#main-page-btn").click(function(e) {
                e.preventDefault();
                window.location.href = "{{ route('main') }}";
            });

            $("#view-order-btn").click(function(e) {
                e.preventDefault();
                window.location.href = "{{ route('view.order') }}";
            });
        });
    </script>
@endsection
