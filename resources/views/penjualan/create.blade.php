@extends('home')
@section('content')
    <main class="main" id="main">
        <section class="section dashboard">
            <div class="col-12">
                <div class="row">
                    <div class="card top-selling overflow-auto">
                        <div class="content">
                            <div class="animated fadeIn">
                                <div class="card-header">
                                    <div class="container-fluid mt-3">
                                        <table aria-hidden="true" border="0" cellpadding="0" cellspacing="0"
                                            class="fa fa-text-height" class="fa fa-align-center" width="100%">
                                            <tr>
                                                <td>
                                                    <h3 class="card-title">Tambah Penjualan</h3>
                                                </td>
                                                <td>
                                                    <div align="right"><a class="btn btn-primary btn-sm mb-1"
                                                            href="{{ url('./penjualan') }}">
                                                            <span class="bi bi-arrow-left-circle-fill" style="font-size:16px">
                                                                Back</span></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="col-12">
                                        <div class="card recent-sales overflow-auto">
                                            <div class="card-body">
                                                <form action="{{ url('penjualan') }}" enctype="multipart/form-data"
                                                    method="post">
                                                    {{ csrf_field() }}
                                                    <p>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="name">Nama Pelanggan</label>
                                                        <div class="col-sm-10">
                                                            <input autofocus
                                                                class="form-control @error('customer_name') is-invalid @enderror"
                                                                name="customer_name" required type="text"
                                                                value="{{ old('customer_name') }}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="product_id">Pilih Produk</label>
                                                        <div class="col-sm-10">
                                                            <select id="product_id" name="product_id" class="form-control" required>
                                                                <option value="">Pilih Produk</option>
                                                                @foreach($products as $item)
                                                                    <option value="{{ $item->product_id }}" {{ old('product_id') == $item->product_id ? 'selected' : '' }}
                                                                        {{ $item->qty == 0 ? 'disabled' : '' }}
                                                                        data-min-qty="{{ $item->qty }}">
                                                                        {{ $item->product_name }} {{ $item->qty == 0 ? '(Habis)' : '' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="price">Harga</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" name="price" id="price" type="text" readonly value="{{ old('price') }}">
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="qty">Qty</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control @error('qty') is-invalid @enderror"
                                                                name="qty" id="qty" required type="number"
                                                                value="{{ old('qty') }}" min="1" max="{{ $products->max('qty') }}"
                                                                oninput="checkQty(this.value)">
                                                                @error('qty')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label class="col-sm-2 col-form-label" for="total">Total</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control @error('total') is-invalid @enderror"
                                                                name="total" id="total" type="text" readonly value="{{ old('total') }}">
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary" style="font-size:16px"
                                                        type="submit"><span class="bi bi-save2 green-color"> Save
                                                        </span></button>
                                                </form>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
        
        $('#product_id').on('change', function() {
            var productID = $(this).val();
            if (productID) {
                $.ajax({
                    url: "{{ url('product') }}/" + productID,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.price) {
                            $('#price').val(response.price);
                            updateTotal();
                        } else {
                            $('#price').val(''); 
                            updateTotal();
                        }
                    },
                });
            } else {
                $('#price').val(''); 
                updateTotal();
            }
        });

        
        $('#qty, #price').on('input', function() {
            updateTotal();
        });

        
        function updateTotal() {
            var qty = parseInt($('#qty').val()) || 0; 
            var price = parseFloat($('#price').val()) || 0;

            var total = qty * price; 
            $('#total').val(total.toFixed(0)); 

            //mengurangi qty_stock di tabel product
            $.ajax({
                url: "{{ url('product/updateQtyStock') }}/" + $('#product_id').val(),
                type: 'POST',
                data: {
                    qty: qty
                },
                success: function(response) {
                    if (response.success) {
                        alert('Qty Stock berhasil diupdate');
                    } else {
                        alert('Gagal mengupdate Qty Stock');
                    }
                },
                error: function(xhr, status, error) {
                    console.log("AJAX Error: " + error);
                }
            });
        }
    });
    </script>
@endsection


