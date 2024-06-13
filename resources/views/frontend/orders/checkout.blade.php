@extends('layouts.frontend')

@section('title', 'Checkout Page')

@section('content')
<!-- header end -->
<div class="breadcrumb-area pt-205 breadcrumb-padding pb-210" style="background-image: url({{ asset('frontend/assets/img/logo/home-bg2.png') }})">
    <div class="container">
        <div class="breadcrumb-content text-center">
            <h2>Checkout Page</h2>
            <ul>
                <li><a href="{{ url('/') }}">home</a></li>
                <li> Checkout Page</li>
            </ul>
        </div>
    </div>
</div>
<!-- checkout-area start -->
<div class="checkout-area ptb-100">
    <div class="container">
        <form action="{{ route('checkout') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="checkbox-form">
                        <h3>Billing Details</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Username <span class="required">*</span></label>
                                    <input type="text" name="username" value="{{ auth()->user()->username }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>WhatsApp<span class="required">*</span></label>
                                    <input type="text" name="phone" value="{{ auth()->user()->phone }}">
                                </div>
                            </div>
                            <div class="order-notes">
                                <div class="checkout-form-list mrg-nn">
                                    <label for="note">Order Notes</label>
                                    <textarea name="note" id="note" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="your-order">
                        <h3>Your order</h3>
                        <div class="your-order-table table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="product-name">Product</th>
                                        <th class="product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                    @php
                                    $product = $item->associatedModel;
                                    $image = !empty($product->firstMedia) ? asset('storage/images/products/'. $product->firstMedia->file_name) : asset('frontend/assets/img/cart/3.jpg');
                                    @endphp
                                    <tr class="cart_item">
                                        <td class="product-name">
                                            {{ $item->name }} <strong class="product-quantity"> × {{ $item->quantity }}</strong>
                                        </td>
                                        <td class="product-total">
                                            <span class="amount">{{ number_format(\Cart::get($item->id)->getPriceSum()) }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2">The cart is empty!</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr class="order-total">
                                        <th>Order Total</th>
                                        <td><strong><span class="total-amount">{{ number_format(\Cart::getTotal()) }}</span></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="payment-accordion">
                                <h3>Payment</h3>
                                <div class="ship-different-title">
                                    <h4>
                                        <input id="cash" type="checkbox" name="cash" />
                                        <label for="cash">Cash</label>
                                    </h4>
                                    <h4>
                                        <input id="cashless" type="checkbox" name="cashless" />
                                        <label for="cashless">Cashless</label>
                                    </h4>
                                </div>
                            </div>
                            <div class="order-button-payment">
                                <input type="submit" value="Pay Now" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- checkout-area end -->

<script>
    function toggleResellerFields() {
        var resellerCheckbox = document.getElementById('reseller');
        var resellerFields = document.getElementById('reseller-fields');

        if (resellerCheckbox.checked) {
            resellerFields.style.display = 'block';
            document.getElementById('reseller_name').setAttribute('required', 'required');
            document.getElementById('reseller_phone').setAttribute('required', 'required');
        } else {
            resellerFields.style.display = 'none';
            document.getElementById('reseller_name').removeAttribute('required');
            document.getElementById('reseller_phone').removeAttribute('required');
        }
    }
</script>
@endsection
