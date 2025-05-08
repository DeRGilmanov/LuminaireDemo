@extends('layouts.app')
@section('content')
<style>
    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .625rem !important;
      background-color: #6a6e51 !important;
    }

    .table>tr>td {
      padding: 0.625rem 1.5rem .625rem !important;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #6a6e51;
    }

    .table> :not(caption)>tr>td {
      padding: .8rem 1rem !important;
    }
    .bg-success {
      background-color: #40c710 !important;
    }

    .bg-danger {
      background-color: #f44032 !important;
    }

    .bg-warning {
      background-color: #f5d700 !important;
      color: #000;
    }
    .pt-90 {
      padding-top: 90px !important;
    }

    .pr-6px {
      padding-right: 6px;
      text-transform: uppercase;
    }

    .my-account .page-title {
      font-size: 1.5rem;
      font-weight: 700;
      text-transform: uppercase;
      margin-bottom: 40px;
      border-bottom: 1px solid;
      padding-bottom: 13px;
    }

    .my-account .wg-box {
      display: -webkit-box;
      display: -moz-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      padding: 24px;
      flex-direction: column;
      gap: 24px;
      border-radius: 12px;
      background: var(--White);
      box-shadow: 0px 4px 24px 2px rgba(20, 25, 38, 0.05);
    }

    .bg-success {
      background-color: #40c710 !important;
    }

    .bg-danger {
      background-color: #f44032 !important;
    }

    .bg-warning {
      background-color: #f5d700 !important;
      color: #000;
    }

    .table-transaction>tbody>tr:nth-of-type(odd) {
      --bs-table-accent-bg: #fff !important;

    }

    .table-transaction th,
    .table-transaction td {
      padding: 0.625rem 1.5rem .25rem !important;
      color: #000 !important;
    }

    .table> :not(caption)>tr>th {
      padding: 0.625rem 1.5rem .25rem !important;
      background-color: #6a6e51 !important;
    }

    .table-bordered>:not(caption)>*>* {
      border-width: inherit;
      line-height: 32px;
      font-size: 14px;
      border: 1px solid #e1e1e1;
      vertical-align: middle;
    }

    .table-striped .image {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 50px;
      height: 50px;
      flex-shrink: 0;
      border-radius: 10px;
      overflow: hidden;
    }

    .table-striped td:nth-child(1) {
      min-width: 250px;
      padding-bottom: 7px;
    }

    .pname {
      display: flex;
      gap: 13px;
    }

    .table-bordered> :not(caption)>tr>th,
    .table-bordered> :not(caption)>tr>td {
      border-width: 1px 1px;
      border-color: #6a6e51;
    }
  </style>
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Детали заказа</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="row">
                            <div class="col-6">
                                <h5>Детали заказа</h5>
                            </div>
                            <div class="col-6 text-right">
                                <a class="btn btn-sm btn-danger" href="{{route('user.orders')}}">Назад</a>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-transaction">
                                <tr>
                                    <th>Номер заказа</th>
                                    <td>{{$order->id}}</td>
                                    <th>Номер телефона</th>
                                    <td>{{$order->phone}}</td>
                                    <th>Почтовый индекс</th>
                                    <td>{{$order->zip}}</td>
                                </tr>
                                <tr>
                                    <th>Дата заказа</th>
                                    <td>{{$order->created_at}}</td>
                                    <th>Дата доставки</th>
                                    <td>{{$order->delivered_date}}</td>
                                    <th>Отменить заказ</th>
                                    <td>{{$order->canceled_date}}</td>
                                </tr>
                                <tr>
                                    <th>Статус заказа</th>
                                    <td colspan="5">
                                         @if($order->status == 'delivered')
                                            <span class="badge bg-success">Доставлен</span>
                                         @elseif($order->status == 'canceled')
                                            <span class="badge bg-danger">Отменен</span>
                                        @else
                                            <span class="badge bg-warning">В ожидании</span>
                                        @endif
                                    </td>

                                </tr>


                        </table>
                    </div>
               </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between gap10 flex-wrap">
                        <div class="wg-filter flex-grow">
                            <h5>Детали заказа</h5>
                        </div>
                    </div>
                    <div class="table-responsive">
                        @if(Session::has ('status'))
                    <p class="alert alert-success">
                        {{Session::get('status')}}
                    </p>
                 @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th class="text-center">Цена</th>
                                    <th class="text-center">Количество</th>
                                    <th class="text-center">Артикул</th>
                                    <th class="text-center">Категория</th>
                                    <th class="text-center">Бренд</th>
                                    <th class="text-center">Опции</th>
                                    <th class="text-center">Статус возврата</th>
                                    <th class="text-center">Действие</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{asset('uploads/products/thumbnails')}}/{{$item->product->image}}" alt="{{$item->product->name}}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{route('shop.product.details', ['product_slug'=>$item->product->slug])}}" target="_blank"
                                                class="body-title-2">{{$item->product->name}}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">₽{{$item->price}}</td>
                                    <td class="text-center">{{$item->quantity}}</td>
                                    <td class="text-center">{{$item->product->SKU}}</td>
                                    <td class="text-center">{{$item->product->category->name}}</td>
                                    <td class="text-center">{{$item->product->brand->name}}</td>
                                    <td class="text-center">{{$item->options}}</td>
                                    <td class="text-center">{{$item->rstatus == 0 ? "Нет" : "Да"}}</td>
                                    <td class="text-center">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
                                                <i class="icon-eye"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                       {{$orderItems->links('pagination::bootstrap-5')}}
                    </div>
                </div>
                <div class="wg-box mt-5">
                    <h5>Детали доставки</h5>
                    <div class="my-account__address-item col-md-6">
                        <div class="my-account__address-item__detail">
                            <p>ФИО - {{$order->name}}</p>
                            <p>Почтовый индекс:{{$order->zip}}</p>
                            <p>Страна, город:{{$order->country}},{{$order->city}} </p>
                            <p>Улица:{{$order->locality}} д.{{$order->address}}</p>
                            <p>Ориентир:{{$order->landmark}}</p>
                            <br>
                            <p>Номер телефона : {{$order->phone}}</p>
                        </div>
                    </div>
                </div>

                <div class="wg-box mt-5">
                    <h5>Оплата</h5>
                    <table class="table table-striped table-bordered table-transaction">
                        <tbody>
                            <tr>
                                <th>Промежуточный итог</th>
                                <td>₽{{$order->subtotal}}</td>
                                <th>Страховка товара</th>
                                <td>₽{{$order->tax}}</td>
                                <th>Скидка</th>
                                <td>₽{{$order->discount}}</td>
                            </tr>
                            <tr>
                                <th>Итого</th>
                                <td>₽{{$order->total}}</td>
                                <th>Способ оплаты</th>
                                <td class="text-center">
                                    @switch($transaction->mode)
                                        @case('cod')
                                            Оплата при получении
                                            @break
                                        @case('card')
                                            Оплата картой
                                            @break
                                        @case('paypal')
                                            СБП
                                            @break
                                        @default
                                            Неизвестно
                                    @endswitch
                                </td>

                                <th>Статус</th>
                                <td>
                                    @if($transaction->status == 'approved')
                                        <span class="badge bg-success">Одобрено</span>
                                    @elseif($transaction->status == 'declined')
                                        <span class="badge bg-danger">Отклонено</span>
                                    @elseif($transaction->status == 'reversed')
                                        <span class="badge bg-secondary">Возвращено</span>
                                    @else
                                        <span class="badge bg-warning">В ожидании</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if($order->status == 'ordered')
                <div class="wg-box mt-5 text-right">
                          <form action="{{route('user.order.cancel')}}" method="POST">
                    @csrf
                    @method('PUT')
                  <input type="hidden" name="order_id" value="{{$order->id}}">
                  <button type="button" class="btn btn-sm btn-danger cancel-order">Отменить заказ</button>
                          </form>
                </div>
                @endif
            </div>

        </div>
    </section>
</main>
@endsection
@push('scripts')
    <script>
        $(function() {
            $('.cancel-order').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');

                swal({
                    title: "Вы уверены?",
                    text: "Это действие невозможно отменить!",
                    icon: "warning",
                    buttons: {
                        cancel: {
                            text: "Отменить заказ",
                            value: null,
                            visible: true
                        },
                        confirm: {
                            text: "Да, отменить!",
                            value: true,
                            className: "bg-danger"
                        }
                    },
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        }
                    });
            });
        });
    </script>
@endpush
