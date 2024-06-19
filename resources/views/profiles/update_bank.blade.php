@extends('components.layout')

@section('head')
    <style>
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
        }

        .form-group .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: var(--clr-primary);
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group .submit-btn:hover {
            background-color: var(--clr-primary-dark);
        }

        .text-hint {
            font-size: 12px;
            color: #888;
        }
    </style>
@endsection

@section('title')
<title>Student Marketplace | Update Bank Details</title>
@endsection
@section('content')
    @include('components.flash-message')
    <div class="container">
        <h2>Update Bank Details</h2>
        <form action="{{ route('profile.updateBankDetails') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="issue_bank">Issue Bank Name</label>
                <select name="issue_bank" id="issue_bank">
                    <option value="Affin Bank Berhad">Affin Bank Berhad</option>
                    <option value="Agrobank">Agrobank</option>
                    <option value="Alliance Bank Malaysia Berhad">Alliance Bank Malaysia Berhad</option>
                    <option value="AmBank (M) Berhad">AmBank (M) Berhad</option>
                    <option value="Bank Islam Malaysia Berhad">Bank Islam Malaysia Berhad</option>
                    <option value="Bank Muamalat Malaysia Berhad">Bank Muamalat Malaysia Berhad</option>
                    <option value="Bank Simpanan Nasional">Bank Simpanan Nasional</option>
                    <option value="CIMB Bank Berhad">CIMB Bank Berhad</option>
                    <option value="Citibank Berhad">Citibank Berhad</option>
                    <option value="Hong Leong Bank Berhad">Hong Leong Bank Berhad</option>
                    <option value="HSBC Bank Malaysia Berhad">HSBC Bank Malaysia Berhad</option>
                    <option value="Malayan Banking Berhad">Malayan Banking Berhad</option>
                    <option value="OCBC Bank (Malaysia) Berhad">OCBC Bank (Malaysia) Berhad</option>
                    <option value="Public Bank Berhad">Public Bank Berhad</option>
                    <option value="RHB Bank Berhad">RHB Bank Berhad</option>
                    <option value="Standard Chartered Bank Malaysia Berhad">Standard Chartered Bank Malaysia Berhad</option>
                    <option value="United Overseas Bank (Malaysia) Berhad">United Overseas Bank (Malaysia) Berhad</option>
                </select>
                @error('issue_bank')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="bankAccHolderName">Account Holder Name</label>
                <input type="text" id="bankAccHolderName" name="bankAccHolderName" required
                    placeholder="e.g. Yong Thay Tau">
                @error('bankAccHolderName')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="bankAccNum">Bank Account Number</label>
                <input type="text" id="bankAccNum" name="bankAccNum" required placeholder="e.g. 1-43241-3254523-9">
                @error('bankAccNum')
                <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <div class="text-hint" style="margin-bottom: 0.5rem">The bank details cannot be changed after this.</div>
                <button type="submit" class="submit-btn">Update Bank Details</button>
            </div>
        </form>
    </div>
@endsection
