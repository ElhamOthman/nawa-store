<x-shop-layout title="Checkout">
    <!--====== Checkout Form Steps Part Start ======-->

    <section class="checkout-wrapper section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if (session()->has('error'))
                    <div class="alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }} </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="checkout-steps-form-style-1">
                        <form action="{{ route('checkout') }}" method="POST">
                            @csrf
                            <ul id="accordionExample">
                                <li>
                                    <h6 class="title" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="true" aria-controls="collapseThree">Your Personal Details </h6>
                                    <section class="checkout-steps-form-content collapse show" id="collapseThree"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>User Name</label>
                                                    <div class="row">
                                                        <div class="col-md-6 form-input form">
                                                            <input type="text" name="customer_first_name"
                                                                value="{{ old('customer_first_name') }}"
                                                                placeholder="First Name">
                                                        </div>
                                                        <div class="col-md-6 form-input form">
                                                            <input type="text" name="customer_last_name"
                                                                value="{{ old('customer_last_name') }}"
                                                                placeholder="Last Name">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Email Address</label>
                                                    <div class="form-input form">
                                                        <input type="email" name="customer_email"
                                                            value="{{ old('customer_email') }}"
                                                            placeholder="Email Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Phone Number</label>
                                                    <div class="form-input form">
                                                        <input type="text" name="customer_phone"
                                                            value="{{ old('customer_phone') }}"
                                                            placeholder="Phone Number">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form form-default">
                                                    <label>Mailing Address</label>
                                                    <div class="form-input form">
                                                        <input type="text" name="customer_address"
                                                            value="{{ old('customer_address') }}"
                                                            placeholder="Mailing Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>City</label>
                                                    <div class="form-input form">
                                                        <input type="text" name="customer_city"
                                                            value="{{ old('customer_city') }}" placeholder="City">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Post Code</label>
                                                    <div class="form-input form">
                                                        <input type="text" name="customer_postal_code"
                                                            value="{{ old('customer_postal_code') }}"
                                                            placeholder="Post Code">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Province</label>
                                                    <div class="form-input form">
                                                        <input type="text" name="customer_province"
                                                            value="{{ old('customer_province') }}"
                                                            placeholder="Province">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="single-form form-default">
                                                    <label>Country</label>
                                                    <div class="select-items">
                                                        <select name="customer_country_code" class="form-control">
                                                            <option value="0">select</option>
                                                            @foreach ($countries as $code => $name)
                                                                <option @selected($code == old('customer_country_code'))
                                                                    value="{{ $code }}">{{ $name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-checkbox checkbox-style-3">
                                                    <input type="checkbox" id="checkbox-3">
                                                    <label for="checkbox-3"><span></span></label>
                                                    <p>My delivery and mailing addresses are the same.</p>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="single-form button">
                                                    <button class="btn" data-bs-toggle="collapse"
                                                        data-bs-target="#collapseFour" type="submit"
                                                        aria-expanded="false" aria-controls="collapseFour">next
                                                        step</button>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </li>
                        </form>
                        <li>
                            <h6 class="title collapsed" data-bs-toggle="collapse" data-bs-target="#collapsefive"
                                aria-expanded="false" aria-controls="collapsefive">Payment Info</h6>
                            <section class="checkout-steps-form-content collapse" id="collapsefive"
                                aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="checkout-payment-form">
                                            <div class="single-form form-default">
                                                <label>Cardholder Name</label>
                                                <div class="form-input form">
                                                    <input type="text" placeholder="Cardholder Name">
                                                </div>
                                            </div>
                                            <div class="single-form form-default">
                                                <label>Card Number</label>
                                                <div class="form-input form">
                                                    <input id="credit-input" type="text"
                                                        placeholder="0000 0000 0000 0000">
                                                    <img src="assets/images/payment/card.png" alt="card">
                                                </div>
                                            </div>
                                            <div class="payment-card-info">
                                                <div class="single-form form-default mm-yy">
                                                    <label>Expiration</label>
                                                    <div class="expiration d-flex">
                                                        <div class="form-input form">
                                                            <input type="text" placeholder="MM">
                                                        </div>
                                                        <div class="form-input form">
                                                            <input type="text" placeholder="YYYY">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="single-form form-default">
                                                    <label>CVC/CVV <span><i
                                                                class="mdi mdi-alert-circle"></i></span></label>
                                                    <div class="form-input form">
                                                        <input type="text" placeholder="***">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="single-form form-default button">
                                                <button class="btn">pay now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="checkout-sidebar">
                        <div class="checkout-sidebar-coupon">
                            <p>Appy Coupon to get discount!</p>
                            <form action="#">
                                <div class="single-form form-default">
                                    <div class="form-input form">
                                        <input type="text" placeholder="Coupon Code">
                                    </div>
                                    <div class="button">
                                        <button class="btn">apply</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="checkout-sidebar-price-table mt-30">
                            <h5 class="title">Pricing Table</h5>

                            <div class="sub-total-price">
                                <div class="total-price">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$144.00</p>
                                </div>
                                <div class="total-price shipping">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$10.50</p>
                                </div>
                                <div class="total-price discount">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$10.00</p>
                                </div>
                            </div>

                            <div class="total-payable">
                                <div class="payable-price">
                                    <p class="value">Subotal Price:</p>
                                    <p class="price">$164.50</p>
                                </div>
                            </div>
                            <div class="price-table-btn button">
                                <a href="javascript:void(0)" class="btn btn-alt">Checkout</a>
                            </div>
                        </div>
                        <div class="checkout-sidebar-banner mt-30">
                            <a href="product-grids.html">
                                <img src="https://via.placeholder.com/400x330" alt="#">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--====== Checkout Form Steps Part Ends ======-->
</x-shop-layout>