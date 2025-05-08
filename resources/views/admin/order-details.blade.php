@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Детали заказа</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="route('admin.index')">
                        <div class="text-tiny">Панель управления</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Детали заказа</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <h5>Детали заказа</h5>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.orders')}}">Назад</a>
            </div>
            <div class="table-responsive">
                @if(Session::has ('status'))
                    <p class="alert alert-success">
                        {{Session::get('status')}}
                    </p>
                 @endif
                <table class="table table-striped table-bordered">
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

        <div class="wg-box mt-5">
            <h5>Обновление статуса заказа</h5>
            <form action="{{route('admin.order.status.update')}}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="order_id" value="{{$order->id}}"/>
                <div class="row">
                    <div class="col-md-3">
                      <div class="select">
                        <select id="order_status" name="order_status">
                            <option value="">Выберите статус</option>
                            <option value="ordered" {{$order->status == 'ordered' ? 'selected' : ''}}>Заказан</option>
                            <option value="delivered" {{$order->status == 'delivered' ? 'selected' : ''}}>Доставлен</option>
                            <option value="canceled" {{$order->status == 'canceled' ? 'selected' : ''}}>Отменён</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary tf-button w208">Обновить статус</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
