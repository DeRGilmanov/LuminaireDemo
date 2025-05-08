@extends('layouts.app')
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Мой аккаунт</h2>
            <div class="row">
                <div class="col-lg-3">
                @include('user.account-nav')
                </div>
                <div class="col-lg-9">
                    <div class="page-content my-account__dashboard">
                        <p>Привет <strong>Пользователь</strong></p>
                        <p>На панели управления вашей учетной записью вы можете просматривать свои <a class="unerline-link" href="account_orders.html">последние
                                заказы</a>, управлять адресами <a class="unerline-link" href="account_edit_address.html">доставки
                                </a>, а <a class="unerline-link" href="account_edit.html">также редактировать свой пароль и данные учетной записи
                                .</a></p>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
