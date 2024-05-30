@extends('layouts.app')

@section('content')

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Orders</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                        <tr>
                            <th>Овог</th>
                            <th>Нэр</th>
                            <th>Email</th>
                            <th>Утасны дугаар</th>
                            <th>Дүүрэг</th>
                            <th>Хороо</th>
                            <th>Хаяг</th>
                            <th>Payment Method</th>
                            <th>Захиалсан огноо</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($order_data)
                        @foreach($order_data as $item)
                            <tr data-id="{{ $item->id }}">
                                <td class="product__order__item">{{$item->lastname}}</td>
                                <td class="product__order__item">{{$item->firstname}}</td>
                                <td class="product__order__item">{{$item->email}}</td>
                                <td class="product__order__item">{{ $item->phone_number }}</td>
                                <td class="product__order__item">{{ $item->district }}</td>
                                <td class="product__order__item">{{ $item->khoroo }}</td>
                                <td class="product__order__item">{{ $item->address }}</td>
                                <td class="product__order__item">{{ $item->payment_method }}</td>
                                <td class="product__order__item">{{ $item->created_at }}</td>
                            </tr>
                        @endforeach
                        @else
                        <h1>There is no orders</h1>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
