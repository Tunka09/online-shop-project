@extends('layouts.app')

@section('content')

<style>
.dropdown {
    position: relative;
    display: inline-block;
    width: 100%;
}

.dropdown-input {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 100%;
    z-index: 1;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown-input:focus + .dropdown-content,
.dropdown-content:hover {
    display: block;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const dropdownInput = document.querySelector('.dropdown-input');
    const dropdownContent = document.querySelector('.dropdown-content');
    const dropdownLinks = document.querySelectorAll('.dropdown-content a');

    dropdownLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const value = event.target.getAttribute('data-value');
            dropdownInput.value = value;
            dropdownContent.style.display = 'none';
        });
    });

    dropdownInput.addEventListener('click', () => {
        dropdownContent.style.display = 'block';
    });

    window.addEventListener('click', (event) => {
        if (!event.target.matches('.dropdown-input') && !event.target.closest('.dropdown-content')) {
            dropdownContent.style.display = 'none';
        }
    });
});


</script>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="{{route('index')}}">Home</a>
                            <a href="{{route('frontend.products')}}">Shop</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">

                @if($errors->any())
                    <div class="alert alert-warning">
                        @foreach ($errors->all() as $error)
                            <div> {{$error}} </div>
                        @endforeach
                    </div>
                @endif

                <form action="{{route('checkout-store')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Захиалагчийн мэдээлэл</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Овог<span>*</span></p>
                                        <input type="text" name="lastname" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Нэр<span>*</span></p>
                                        <input type="text" name="firstname" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Утасны дугаар<span>*</span></p>
                                        <input type="number" name="phone_number" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Дүүрэг<span>*</span></p>
                                        <div class="dropdown">
                                        <input type="text" name="district" required class="dropdown-input" placeholder="Дүүрэг сонгоно уу.">
                                        <div class="dropdown-content">
                                            <a href="#" data-value="Чингэлтэй">Чингэлтэй</a>
                                            <a href="#" data-value="Баянгол">Баянгол</a>
                                            <a href="#" data-value="Сүхбаатар">Сүхбаатар</a>
                                            <a href="#" data-value="Баянзүрх">Баянзүрх</a>
                                            <a href="#" data-value="Хан-Уул">Хан-Уул</a>
                                            <a href="#" data-value="Налайх">Налайх</a>
                                            <a href="#" data-value="Багануур">Багануур</a>
                                            <a href="#" data-value="Багахангай">Багахангай</a>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Хороо<span>*</span></p>
                                        <input type="number" max="100", min="1" name="khoroo" required>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Хаяг<span>*</span></p>
                                <input type="text" placeholder="Дэлгэрэнгүй хаяг бичнэ үү." name="address" required>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                                    @foreach($cart_data as $item)
                                    <li>{{$item->product->name}}<span>{{ $item->quantity * $item->product->price * (1 - $item->product->sale_percent / 100) }}₮</span></li>
                                    @endforeach
                                </ul>
                                <ul class="checkout__total__all">
                                    <li>Total <span>{{ $total_price }}₮</span></li>
                                </ul>
                                <p>Та худалдан авалтаа дахин хянаарай. Барааг худалдан
                                    авсны дараа буцаах боломжгүйг анхаарна уу.</p>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

@endsection
