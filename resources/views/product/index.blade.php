@extends('home')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="mt-5">Product</h3>
            </div>
        </div>
        <table class="table table-striped ">
            <thead>
                <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">QTY Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($product as $item)
                <tr>
                    <th scope="row">{{ $item->product_id }}</th>
                    <td>{{ $item->product_name }}</td>
                    <td>{{$item->price}}</td>
                    <td>{{$item->qty}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection