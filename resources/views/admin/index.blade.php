@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">

        <div class="main-content-wrap">
            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">
                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Общее количество заказов</div>
                                        <h4>{{$dashboardDatas[0]->Total}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="fas fa-ruble-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Общая сумма</div>
                                        <h4>{{$dashboardDatas[0]->TotalAmount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Отложенные заказы</div>
                                        <h4>{{$dashboardDatas[0]->TotalOrdered}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="fas fa-ruble-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Количество отложенных заказов</div>
                                        <h4>{{$dashboardDatas[0]->TotalOrderedAmount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Доставленные заказы</div>
                                        <h4>{{$dashboardDatas[0]->TotalDelivered}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="fas fa-ruble-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Количество доставленных заказов</div>
                                        <h4>{{$dashboardDatas[0]->TotalDeliveredAmount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Отмененые заказы</div>
                                        <h4>{{$dashboardDatas[0]->TotalCanceled}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="fas fa-ruble-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Сумма отмененных заказов</div>
                                        <h4>{{$dashboardDatas[0]->TotalCanceledAmount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Итоги</h5>

                    </div>
                    <div class="flex flex-wrap gap40">
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t1"></div>
                                    <div class="text-tiny">Всего</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₽{{$TotalAmount}}</h4>

                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">В ожидании</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₽{{$TotalOrderedAmount}}</h4>

                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Доставленные</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₽{{$TotalDeliveredAmount}}</h4>

                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Отмененые</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>₽{{$TotalCanceledAmount}}</h4>

                            </div>
                        </div>
                    </div>
                    <div id="line-chart-8"></div>
                </div>

            </div>
            <div class="tf-section mb-30">

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Recent orders</h5>
                        <div class="dropdown default">
                            <a class="btn btn-secondary dropdown-toggle" href="{{route('admin.orders')}}" role="button">
                                <span class="view-all">Посмотреть все</span>
                            </a>
                        </div>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width:70px">Номер заказа</th>
                                        <th class="text-center">Имя</th>
                                        <th class="text-center">Телефон</th>
                                        <th class="text-center">Сумма</th>
                                        <th class="text-center">Налог</th>
                                        <th class="text-center">Итого</th>
                                        <th class="text-center">Статус</th>
                                        <th class="text-center">Дата заказа</th>
                                        <th class="text-center">Всего товаров</th>
                                        <th class="text-center">Дата доставки</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                    <tr>
                                        <td class="text-center">{{$order->id}}</td>
                                        <td class="text-center">{{$order->name}}</td>
                                        <td class="text-center">{{$order->phone}}</td>
                                        <td class="text-center">₽{{$order->subtotal}}</td>
                                        <td class="text-center">₽{{$order->tax}}</td>
                                        <td class="text-center">₽{{$order->total}}</td>
                                        <td class="text-center">
                                            @if($order->status == 'delivered')
                                                <span class="badge bg-success">Доставлен</span>
                                             @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Отменен</span>
                                            @else
                                                <span class="badge bg-warning">В ожидании</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{$order->created_at}}</td>
                                        <td class="text-center">{{$order->orderItems->count()}}</td>
                                        <td class="text-center">{{$order->delivered_date}}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.order.details', ['order_id' => $order->id]) }}">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye">
                                                        <i class="icon-eye"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@push('scripts')
<script>
    (function ($) {

        var tfLineChart = (function () {

            var chartBar = function () {

                var options = {
                    series: [{
                        name: 'Всего',
                        data: [{{$AmountM}}]
                    }, {
                        name: 'В ожидании',
                        data: [{{$OrderedAmountM}}]
                    },
                        {
                            name: 'Доставленые',
                            data: [{{$DeliveredAmountM}}]
                        }, {
                            name: 'Отмененые',
                            data: [{{$CanceledAmountM}}]
                        }],
                    chart: {
                        type: 'bar',
                        height: 325,
                        toolbar: {
                            show: false,
                        },
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '10px',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false,
                    },
                    colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                    stroke: {
                        show: false,
                    },
                    xaxis: {
                        labels: {
                            style: {
                                colors: '#212529',
                            },
                        },
                        categories: ['Янв', 'Фев', 'Maр', 'Aпр', 'Maй', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                    },
                    yaxis: {
                        show: false,
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return "₽ " + val + ""
                            }
                        }
                    }
                };

                chart = new ApexCharts(
                    document.querySelector("#line-chart-8"),
                    options
                );
                if ($("#line-chart-8").length > 0) {
                    chart.render();
                }
            };

            /* Function ============ */
            return {
                init: function () { },

                load: function () {
                    chartBar();
                },
                resize: function () { },
            };
        })();

        jQuery(document).ready(function () { });

        jQuery(window).on("load", function () {
            tfLineChart.load();
        });

        jQuery(window).on("resize", function () { });
    })(jQuery);
</script>

@endpush
