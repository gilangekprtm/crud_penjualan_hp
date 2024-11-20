@extends('home')

@section('content')
@include('sweetalert::alert')
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if(session()->has('success'))
                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
                    <script>
                        Swal.fire({
                            title: "Good job!",
                            text: "{{ session('success') }}",
                            icon: "success"
                        });
                    </script>
                @endif
                <h3 class="mt-5">Penjualan</h3>
                <a href="{{url('penjualan/create')}}" class="btn btn-primary my-3">Tambah Data</a>
            </div>
        </div>
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Total</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                @foreach ($penjualan as $item)
                <tr>
                    <th scope="row">{{ $i++ }}</th>
                    <td>{{ $item->customer_name }}</td>
                    <td>{{ $item->product_name }}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->qty}}</td>
                    <td>{{$item->total}}</td>
                    <td>
                        <a class="btn btn-success btn-sm"
                            href="{{ url('penjualan/' . $item->sales_id . '/edit') }}">
                            <span class="bi bi-pencil-square" style="font-size:12px"></span>
                        </a>
                        <a href="{{ url('penjualan', $item->sales_id) }}" class="btn btn-danger bi bi-trash btn-sm" data-confirm-delete="true"></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
