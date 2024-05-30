@props(['products'])
<div class="title-container">
    <h1>My Product List</h1>
    <a href="{{ route('products.create') }}"><i class="fa-solid fa-circle-plus"></i> Add Product</a>
</div>
<div class="control-container">
    <table class="product-list">
        <thead>
            <tr>
                <th style="width:10%">No</th>
                <th style="width:20%">Image</th>
                <th style="width:25%">Product Name</th>
                <th style="width:12.5%">Quantity</th>
                <th style="width:12.5%">Price</th>
                <th style="width:20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @foreach ($products as $product)
                @php
                    $images = explode(',', $product->images);
                    $image = $images[0];
                @endphp
                <tr>
                    <td>{{ $count++ }}</td>
                    <td><img src="{{ $image == null ? asset('images/No-Image-Placeholder.svg') : asset('storage/' . $image) }}"
                            alt="product image"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->quantity_available }}</td>
                    <td>RM {{ $product->price }}</td>
                    <td>
                        <div class="action-btn-section">
                            <a href="edit_product.html" title="Edit Product" class="edit-btn"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <button title="Delete Product" class="delete-btn"" data-open-modal
                                data-id="{{ $product->id }}"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<dialog data-modal class="delete-confirm-dialog">
    <form method="POST" action="{{route('products.destory')}}">
        @csrf
        @method('DELETE')
        <p>Do you want delete this product ?</p>
        <input type="hidden" name="pID" value="">
        <div class="modal-footer">
            <button type="button" class="action-btn" data-close-modal id="cancel-btn">Cancel</button>
            <button type="submit" class="action-btn" id="submit-btn">Confirm</button>
        </div>
    </form>
</dialog>

<script>
    $("[data-open-modal]").on("click", function() {
        $("input[name=pID]").val($(this).data("id"));
        modal.showModal();
    });
    const openModalButton = document.querySelector("[data-open-modal]")
    const closeModalButton = document.querySelector("[data-close-modal]")
    const modal = document.querySelector("[data-modal]")


    closeModalButton.addEventListener("click", () => {
        modal.close();
    })
</script>
