@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
      <h2 class="page-title">Доставка и оформление заказа</h2>
      <div class="checkout-steps">
        <a href="{{route('cart.index')}}" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">01</span>
          <span class="checkout-steps__item-title">
            <span>Корзина</span>
            <em>Управляйте списком товаров</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item active">
          <span class="checkout-steps__item-number">02</span>
          <span class="checkout-steps__item-title">
            <span>Доставка и оформление</span>
            <em>Оформите ваш заказ</em>
          </span>
        </a>
        <a href="javascript:void(0)" class="checkout-steps__item">
          <span class="checkout-steps__item-number">03</span>
          <span class="checkout-steps__item-title">
            <span>Подтверждение</span>
            <em>Проверьте и отправьте заказ</em>
          </span>
        </a>
      </div>
      <form name="checkout-form" action="{{route('cart.place.an.order')}}" method="POST">
        @csrf
        <div class="checkout-form">
          <div class="billing-info__wrapper  ">
            <div class="row ">
              <div class="col-6">
                <h3>ДЕТАЛИ ДОСТАВКИ</h3>
              </div>
              <div class="col-6">
              </div>
            </div>
            @if($address)
            <div class="row">
              <div class="col-md-12">
                <div class="my-account__address-list ">
                    <div class="my-account__address-list-item ">
                      <div class="my-account__address-item_detail ">
                        <p>ФИО - {{$address->name}}</p>
                       <p>Почтовый индекс:{{$address->zip}}</p>
                       <p>Страна, город:{{$address->country}},{{$address->city}} </p>
                       <p>Улица:{{$address->locality}} д.{{$address->address}}</p>
                       <p>Ориентир:{{$address->landmark}}</p>
                       <br>
                       <p>Номер телефона : {{$address->phone}}</p>
                      </div>
                    </div>
                </div>
              </div>
             </div>




            @else
            <div class="row mt-5">
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="name" required="" value="{{ old('name') }}">
                  <label for="name">Полное имя *</label>
                  @error('name') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="phone" required="" value="{{ old('phone') }}">
                  <label for="phone">Номер телефона *</label>
                  @error('phone') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="zip" required="" value="{{ old('zip') }}">
                  <label for="zip">Почтовый индекс *</label>
                  @error('zip') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating mt-3 mb-3">
                  <input type="text" class="form-control" name="state" required="" value="{{ old('state') }}">
                  <label for="state">Область / Регион *</label>
                  @error('state') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="city" required="" value="{{ old('city') }}">
                  <label for="city">Город *</label>
                  @error('city') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="address" required=""   value="{{ old('address') }}">
                  <label for="address">Дом, название здания *</label>
                  @error('address') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="locality" required="" value="{{ old('locality') }}">
                  <label for="locality">Улица, район, колония *</label>
                  @error('locality') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-floating my-3">
                  <input type="text" class="form-control" name="landmark" required="" value="{{ old('landmark') }}">
                  <label for="landmark">Ориентир *</label>
                  @error('landmark') <span class="text-danger">{{$message}}</span>@enderror
                </div>
              </div>
            </div>
            @endif
          </div>
          <div class="checkout__totals-wrapper">
            <div class="sticky-content">
              <div class="checkout__totals">
                <h3>Ваш заказ</h3>
                <table class="checkout-cart-items">
                  <thead>
                    <tr>
                      <th>ТОВАР</th>
                      <th align="right">ИТОГ</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach (Cart::instance('cart')->content() as $item)
                    <tr>
                      <td>
                        {{$item->name}} x {{$item->qty}}
                      </td>
                      <td align="right">
                        {{$item->subtotal}}
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @if(Session::has('discounts'))
                <table class="checkout-totals">
                    <tbody>
                        <tr>
                            <th>Стоимость товаров</th>
                            <td class="text-right">₽{{Cart::instance('cart')->subtotal()}}</td>
                        </tr>
                        <tr>
                            <th>Скидка по промокоду {{Session::get('coupon')['code']}}</th>
                            <td class="text-right">₽{{Session::get('discounts')['discount']}}</td>
                        </tr>
                        <tr>
                            <th>Стоимость после скидки</th>
                            <td class="text-right">₽{{Session::get('discounts')['subtotal']}}</td>
                        </tr>
                        <tr>
                            <th>Доставка</th>
                            <td class="text-right">Бесплатная доставка </td>
                        </tr>
                        <tr>
                            <th>Страховка товара</th>
                            <td class="text-right">₽{{Session::get('discounts')['tax']}}</td>
                        </tr>
                        <tr>
                            <th>Итого</th>
                            <td class="text-right">₽{{Session::get('discounts')['total']}}</td>
                        </tr>
                    </tbody>
                </table>
                @else
                <table class="checkout-totals">
                  <tbody>
                    <tr>
                      <th>ИТОГ</th>
                      <td class="text-right">₽{{Cart::instance('cart')->subtotal()}}</td>
                    </tr>
                    <tr>
                      <th>ДОСТАВКА</th>
                      <td class="text-right">Бесплатная доставка</td>
                    </tr>
                    <tr>
                      <th>Стоимость страховки</th>
                      <td class="text-right">₽{{Cart::instance('cart')->tax()}}</td>
                    </tr>
                    <tr>
                      <th>ИТОГО</th>
                      <td class="text-right">₽{{Cart::instance('cart')->total()}}</td>
                    </tr>
                  </tbody>
                </table>
                @endif
              </div>
              <div class="checkout__payment-methods">
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="card">
                  <label class="form-check-label" for="mode1">
                    Оплата картой
                  </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="paypal">
                    <label class="form-check-label" for="mode2">
                      Оплата СБП
                    </label>
                  </div>
                <div class="form-check">
                  <input class="form-check-input form-check-input_fill" type="radio" name="mode"id="mode3" value="cod">
                  <label class="form-check-label" for="mode3">
                    Оплата наличными после получения
                  </label>
                </div>

                <div class="policy-text">
                  Ваши персональные данные будут использованы для обработки вашего заказа, поддержки вашего опыта на этом сайте и для других целей, описанных в нашей <a href="terms.html" target="_blank">политике конфиденциальности</a>.
                </div>
              </div>
              <button class="btn btn-primary btn-checkout">ОФОРМИТЬ ЗАКАЗ</button>
            </div>
          </div>
        </div>
      </form>
    </section>
  </main>

@endsection
