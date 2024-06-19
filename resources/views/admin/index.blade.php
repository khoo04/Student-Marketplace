@extends('components.layout')

@section('head')
    <style>
        #navigation {
            width: 88%;
            margin: auto;
            border-radius: 1rem;
            margin-bottom: 2rem;
        }

        .admin-nav-btn {
            display: inline-block;
            padding: 8px 10px;
            border-radius: 0.25rem;
            background: transparent;
            border: 1px solid var(--clr-secondary-900);
            box-shadow: 0px 0px 8px var(--clr-secondary-400);
            cursor: pointer;
        }

        .admin-nav-btn:hover {
            background-color: var(--clr-secondary-400);
        }

        .admin-nav-btn:not(:last-child) {
            margin-right: 0.5rem;
        }

        .action-panel {
            width: 88%;
            margin: auto;
            border: 1px solid black;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }

        .title-section {
            padding: 1rem;
            border-bottom: 1px solid black;
        }

        .content-section {
            padding: 1rem;
            overflow: auto;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
        }

        .content-table .name-column {
            width: 25%;
            text-align: left;
        }

        .content-table .phone-column {
            width: 15%;
            text-align: center;
        }

        .content-table .status-column {
            width: 15%;
            text-align: center;
        }

        .content-table .action-column {
            width: 20%;
            text-align: center;
        }

        .content-table .email-column {
            width: 25%;
            text-align: left;
        }

        .content-table th,
        .content-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .content-table th {
            background-color: #f2f2f2;
        }

        .action-btn-section {
            text-align: center;
        }

        .action-btn {
            margin-right: 5px;
            padding: 8px 12px;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        .status-column.pending {
            color: blue;
        }

        .action-btn.approve {
            color: white;
            background-color: var(--success);
        }

        .action-btn.reject {
            color: white;
            background-color: var(--danger);
        }

        .action-btn.approve:hover {
            background-color: var(--success_hover);
        }

        .action-btn.reject:hover {
            background-color: var(--danger_hover);
        }

        .content-table .product-image-column {
            width: 20%;
        }

        .product-image-column>img {
            width: 100%;
            height: 200px;
            object-fit: contain;
        }

        .content-table .product-name-column {
            width: 10%;
        }

        .content-table .product-desc-column {
            width: 20%;
        }

        .content-table .product-price-column {
            width: 10%;
            text-align: center;
        }

        .content-table .product-category-column {
            width: 10%;
            text-align: center;
        }

        .content-table .product-seller-column {
            width: 10%;
            text-align: center;
        }

        .content-table .order-id-column {
            width: 5%;
            text-align: center;
        }

        .content-table .transc-no-column {
            width: 10%;
        }

        .content-table .order-quantity-column {
            width: 10%;
            text-align: center;
        }

        .content-table .amount-to-pay-column {
            width: 10%;
            text-align: center;
        }

        #pay-to-seller-table .seller-bank-acc-name-column {
            width: 12%;
            text-align: center;
        }

        #pay-to-seller-table .seller-bank-column {
            width: 8%;
            text-align: center;
        }

        #pay-to-seller-table .seller-bank-acc-num-column {
            width: 10%;
            text-align: center;
        }

        #pay-to-seller-table .action-column {
            width: 15%;
        }

        .admin-nav-btn[data-active=true] {
            background-color: var(--clr-primary);
            border: 1px solid var(--clr-primary-dark);
            color: white;
        }

        .view-seller-info-btn {
            background: transparent;
            font-size: 1rem;
            text-decoration: underline;
            color: blue;
            cursor: pointer;
        }

        .view-seller-info-btn:hover {
            color: rgb(0, 0, 192);
        }

        .seller-info {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
            border: 1px solid var(--clr-secondary-400);
            box-shadow: 2px 2px 12px var(--clr-secondary-400);
            background-color: white;
            border-radius: 0.5rem;
            width: 50%;
            padding: 1rem;
            overflow: auto;
        }

        .seller-info h2 {
            text-decoration: underline;
            margin-bottom: 1rem;
        }

        .seller-info p {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .seller-info .content {
            font-weight: normal;
        }

        .seller-info .button-container {
            display: flex;
            justify-content: center;
        }

        .seller-info .button-container>button {
            padding: 8px 12px;
            border-radius: 0.25rem;
            color: white;
            background-color: var(--clr-primary);
            display: inline-block;
            cursor: pointer;
        }

        .seller-info .button-container>button:hover {
            background-color: var(--clr-primary-dark);
        }
    </style>
@endsection

@section('title')
    <title>Student Marketplace | Admin</title>
@endsection
@section('content')
    <div class="flash-message">
        <p id="message"></p>
    </div>
    <div id="navigation">
        <button type="button" class="admin-nav-btn" id="acc-approve-panel" data-active=true><i class="fa-solid fa-user"></i> Account Approval</button>
        <button type="button" class="admin-nav-btn" id="product-approve-panel" data-active="false"><i class="fa-solid fa-briefcase"></i> Product Approval</button>
        <button type="button" class="admin-nav-btn" id="sales-payback-panel" data-active="false"><i class="fa-solid fa-money-bill"></i> Sales Payback</button>
    </div>

    <section class="action-panel">
        <x-admin.account-approval-panel :usersPendingApprove=$usersPendingApprove />
    </section>
@endsection


@section('js')
    <script>
        $(document).ready(function() {

            $("#acc-approve-panel").click(function(e) {
                $(".admin-nav-btn").each(function(index, element) {
                    $(element).attr("data-active", false);;
                });
                $(this).attr("data-active", true);
                renderAccountApprovalPanel();
            });

            $("#product-approve-panel").click(function(e) {
                $(".admin-nav-btn").each(function(index, element) {
                    $(element).attr("data-active", false);;
                });
                $(this).attr("data-active", true);
                renderProductApprovalPanel();
            });

            $("#sales-payback-panel").click(function(e) {
                $(".admin-nav-btn").each(function(index, element) {
                    $(element).attr("data-active", false);;
                });
                $(this).attr("data-active", true);
                renderSalesPaybackPanel();
            });
        });

        function renderAccountApprovalPanel() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.accApprovePanel') }}",
                success: function(response) {
                    $('.action-panel').html(response.panel);
                }
            });
        }

        function renderProductApprovalPanel() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.productApprovePanel') }}",
                success: function(response) {
                    $('.action-panel').html(response.panel);
                }
            });
        }

        function renderSalesPaybackPanel() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.salesPaybackPanel') }}",
                success: function(response) {
                    $('.action-panel').html(response.panel);
                }
            });
        }

        function showFlashMessage(message, type) {
            var flashMessage = $('.flash-message');
            flashMessage.addClass(type);
            var messageElement = flashMessage.find('#message');
            messageElement.text(message);
            flashMessage.show();
            setTimeout(function() {
                flashMessage.hide();
            }, 3000);
        }
    </script>
@endsection
