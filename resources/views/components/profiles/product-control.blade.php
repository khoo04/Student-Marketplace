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
                <th style="width:10%">Approval Status</th>
                <th style="width:15%">Image</th>
                <th style="width:20%">Product Name</th>
                <th style="width:12.5%">Quantity</th>
                <th style="width:12.5%">Price</th>
                <th style="width:20%">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($products) == 0)
                <tr>
                    <td colspan="7">
                        <p style="text-align: center">Not Record Found</p>
                    </td>
                </tr>
            @else
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
                        <td>
                            <p class="center {{ $product->approve_status }}">{{ ucfirst($product->approve_status) }}</p>
                        </td>
                        <td><img src="{{ $image == null ? asset('images/No-Image-Placeholder.svg') : asset('storage/' . $image) }}"
                                alt="product image"></td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->quantity_available }}</td>
                        <td>RM {{ $product->price }}</td>
                        <td>
                            <div class="action-btn-section">
                                <a href="{{ route('products.edit', ['product' => $product->id]) }}" title="Edit Product"
                                    class="edit-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button title="Delete Product" class="delete-btn"" data-open-modal
                                    data-id="{{ $product->id }}"><i class="fa-solid fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                @endforeach


            @endif
        </tbody>
    </table>
</div>

<dialog data-modal class="delete-confirm-dialog">
    <form method="POST" action="{{ route('products.destory') }}">
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
    $(document).ready(function() {
        const deleteDialog = document.querySelector('.delete-confirm-dialog');

        $("[data-open-modal]").on("click", function() {

            $("input[name=pID]").val($(this).data("id"));
            deleteDialog.showModal();
        });

        $("[data-close-modal]").on("click", function() {
            deleteDialog.close();
        })

        function dialogBackDropClose(dialog) {
            dialog.addEventListener("click", e => {
                const dialogDimensions = dialog.getBoundingClientRect()
                if (
                    e.clientX < dialogDimensions.left ||
                    e.clientX > dialogDimensions.right ||
                    e.clientY < dialogDimensions.top ||
                    e.clientY > dialogDimensions.bottom
                ) {
                    dialog.close()
                }
            });
        }
        
        dialogBackDropClose(deleteDialog);

    });
</script>
