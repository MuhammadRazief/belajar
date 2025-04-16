@extends('views.main')
@section('title', '| penjualan')
@section('breadcrumb1', 'penjualan')
@section('breadcrumb2', 'penjualan')

@section('content')
    <div class="row">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center container">
                            <div class="row">
                                @foreach ($products as $product)
                                    <div class="col-lg-4 col-md-6">
                                        <div class="card">
                                            <p hidden class="product_id">{{ $product->id }}</p>
                                            <div class="bg-image">
                                                <img src="{{ asset('storage/img/' . $product->img) }}" class="w-50 mt-3"
                                                    alt="">
                                            </div>
                                            <div class="card-body">
                                                <div class="card-title mb-3">{{ $product->name }}</div>
                                                <p>Stock <span class="prdct_stock">{{ $product->stock }}</span></p>
                                                <h6 class="mb-3 product_price">{{ 'Rp. ' . number_format($product->price, 0, ',', '.') }}</h6>
                                                <center>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td style="padding: 0px 10px 0px 10px; cursor: pointer;"
                                                                    class="prdct_mint">
                                                                    <b>-</b>
                                                                </td>
                                                                <td style="padding: 0px 10px 0px 10px;" class="prdct_sum">0
                                                                </td>
                                                                <td style="padding: 0px 10px 0px 10px; cursor: pointer;"
                                                                    class="prdct_plus">
                                                                    <b>+</b>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </center>
                                                <p class="mt-3">
                                                    Sub Total
                                                    <b class="sub_total">Rp. 0 ,-</b>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <form action="{{ route('sales.store') }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <div id="hidden-inputs"></div> <!-- Tempat menyimpan input hidden -->
                                    <button type="submit" class="btn btn-primary">Selanjutnya</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $(".prdct_plus, .prdct_mint").click(function() {
            var card = $(this).closest(".card");
            var quantityElement = card.find(".prdct_sum");
            var stock = parseInt(card.find(".prdct_stock").text().trim()); // Ambil stok
            var price = parseFloat(card.find(".product_price").text().replace(/[^\d]/g, '')); // Ambil harga
            var quantity = parseInt(quantityElement.text()); // Ambil jumlah saat ini
            var productId = card.find(".product_id").text().trim(); // Ambil ID produk
            var productName = card.find(".card-title").text().trim(); // Ambil nama produk

            if ($(this).hasClass("prdct_plus")) {
                if (quantity < stock) {
                    quantity++;
                } else {
                    alert("Stok tidak mencukupi!");
                    return;
                }
            } else if ($(this).hasClass("prdct_mint") && quantity > 0) {
                quantity--;
            }

            quantityElement.text(quantity);
            var subtotal = quantity * price;
            card.find(".sub_total").text("Rp. " + subtotal.toLocaleString() + " ,-");

            updateHiddenInputs(productId, productName, price, quantity, subtotal);
        });

        function updateHiddenInputs(productId, productName, price, quantity, totalPrice) {
            var hiddenInputsContainer = $("#hidden-inputs");
            var existingInput = hiddenInputsContainer.find("input[data-id='" + productId + "']");

            var inputValue = productId + ";" + productName + ";" + price + ";" + quantity + ";" + totalPrice;

            if (existingInput.length > 0) {
                if (quantity > 0) {
                    existingInput.val(inputValue);
                } else {
                    existingInput.remove(); // Hapus input jika quantity = 0
                }
            } else if (quantity > 0) {
                hiddenInputsContainer.append('<input type="hidden" name="products[]" data-id="' + productId + '" value="' +
                    inputValue + '">');
            }
        }
    </script>
@endpush