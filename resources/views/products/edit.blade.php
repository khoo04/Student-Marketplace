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
        .form-group input[type="file"],
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: none;
        }

        .form-group input[type="number"] {
            display: block;
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            resize: none;
        }

        .form-group input[type="radio"] {
            margin-right: 10px;
        }

        .form-group input[type="file"] {
            padding: 3px;
        }

        .form-group .radio-label {
            display: inline-block;
            margin-right: 20px;
        }

        .form-group .price-container {
            display: flex;
            align-items: stretch;
        }

        .form-group .price-container span {
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            padding: 10px;
            border-right: 0;
        }

        .form-group .price-container input {
            border-radius: 0 4px 4px 0;
            border-left: 0;
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
            transition: background-color .2s;
        }

        .form-group .submit-btn:hover {
            background-color: var(--clr-primary-dark);
        }

        .cancel-btn{
            margin-top: 0.5rem;
            width: 100%;
            padding: 10px;
            background-color: transparent;
            border: 1px solid var(--clr-secondary);
            border-radius: 4px;
            color: black;
            font-size: 16px;
            cursor: pointer;
            transition: background-color .2s;
        }

        .cancel-btn:hover{
            background-color: var(--clr-secondary-600);
            color: white;
        }

        .text-hint {
            font-size: 12px;
            color: #888;
        }

        .preview-image {
            width: 100px;
            height: 100px;
        }

        .delete-btn {
            padding: 0;
            background: transparent;
            color: red;
            font-weight: 500;
            cursor: pointer;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('title')
    <title>Student Marketplace | Add Product</title>
@endsection

@section('content')
    <div class="container">
        <h2>Edit Product</h2>
        <form action="{{ route('products.update', ['product' => $product]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="productName">Product Name</label>
                <input type="text" id="productName" name="productName" required
                    placeholder="e.g., Apple MacBook Pro 16-inch, 16GB RAM, Silver" value="{{ $product->name }}">
                <div class="text-hint">Brand Name + Product Type + Key Feature (Materials, Colors, Size, Model)</div>
                @error('productName')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="productDescription">Product Description</label>
                <textarea id="productDescription" name="productDescription" rows="4" required
                    placeholder="e.g., A high-performance laptop with a 16-inch display, ideal for professionals.">{{ $product->description }}</textarea>
                <div class="text-hint">Detailed description of the product, including features and condition.</div>
                @error('productDescription')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="productQuantity">Quantity</label>
                <input type="number" id="productQuantity" name="productQuantity" required placeholder="e.g., 10"
                    min="1" max="5000" value="{{ $product->quantity_available }}">
                    <div class="text-hint">Number of items available for sale. Minimum: 1 and Maximum: 5000</div>
                @error('productQuantity')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="productPrice">Price</label>
                <div class="price-container">
                    <span>RM</span>
                    <input type="number" id="productPrice" name="productPrice" min="1" step="0.01" required
                        placeholder="e.g., 999.99" value="{{ $product->price }}">
                </div>
                <div class="text-hint">Price of the product in Malaysian Ringgit (RM).</div>
                @error('productPrice')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="productCategory">Category</label>
                <select id="productCategory" name="productCategory" required>
                    <option disabled>Select Category</option>
                    @foreach ($categories as $category)
                        @if ($product->category_id == $category->id)
                            <option value="{{ $product->category_id }}" selected>{{ $product->category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
                <div class="text-hint">Select the appropriate category for your product.</div>
                @error('productCategory')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label>Condition</label>
                @if ($product->condition == 'new')
                    <label class="radio-label"><input type="radio" name="condition" value="new" checked required>
                        New</label>
                    <label class="radio-label"><input type="radio" name="condition" value="used" required> Used</label>
                @else
                    <label class="radio-label"><input type="radio" name="condition" value="new" required> New</label>
                    <label class="radio-label"><input type="radio" name="condition" value="used" checked required>
                        Used</label>
                @endif

                @error('condition')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                @php
                    if ($product->images != null) {
                        $imagePaths = explode(',', $product->images);
                        // Ensure imagePaths array has at least 3 elements
                        for ($i = 0; $i < 3; $i++) {
                            if (!isset($imagePaths[$i])) {
                                $imagePaths[$i] = null;
                            }
                        }
                    } else {
                        $imagePaths = null;
                    }
                @endphp
                <label for="productImage1">Product Image 1 (Required)</label>
                @if ($imagePaths != null && $imagePaths[0] != null)
                    <img class="preview-image" src="{{ asset('storage/' . $imagePaths[0]) }}">
                @endif
                <input type="file" id="productImage1" name="productImage1" accept="image/*">
                @error('productImage1')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="productImage2">Product Image 2 (Optional)</label>
                @if ($imagePaths != null && $imagePaths[1] != null)
                    <div style="margin-bottom: 0.5rem">
                        <img class="preview-image" src="{{ asset('storage/' . $imagePaths[1]) }}">
                        <button type="button" class="delete-btn" data-index="1">Delete Image</button>
                    </div>
                @endif
                <input type="file" id="productImage2" name="productImage2" accept="image/*">
                @error('productImage2')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="productImage3">Product Image 3 (Optional)</label>
                @if ($imagePaths != null && $imagePaths[2] != null)
                    <div style="margin-bottom: 0.5rem">
                        <img class="preview-image" src="{{ asset('storage/' . $imagePaths[2]) }}">
                        <button type="button" class="delete-btn" data-index="2">Delete Image</button>
                    </div>
                @endif
                <input type="file" id="productImage3" name="productImage3" accept="image/*">
                @error('productImage3')
                    <p class="form-error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="submit-btn">Edit Product</button>
                <button type="button" class="cancel-btn">Cancel</button>
            </div>
        </form>
    </div>

    <form action="{{ route('products.updateImage', ['product' => $product->id, 'index' => 'index']) }}"
        id="delete-image-form" method="POST">
        @csrf
        @method('PUT')
    </form>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $(".delete-btn").on("click", function() {
                index = $(this).data('index');
                form = $("#delete-image-form");
                actionUrl = form.attr('action').replace('index', index);
                form.attr('action', actionUrl);
                form.submit();
            });

            $(".cancel-btn").click(function(){
                window.location.replace("{{route('products')}}");
            });
        });
    </script>
@endsection
