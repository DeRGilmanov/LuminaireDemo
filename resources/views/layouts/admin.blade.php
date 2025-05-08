<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Luminare') }}</title>


    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />

    <link rel="stylesheet" type="text/css" href ="{{ asset ('css/animate.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/animation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset ('font/fonts.css')}}">
    <link rel="stylesheet" href="{{ asset ('icon/style.css')}}">
    <link rel="shortcut icon" href="images/logo2.ico">
    <link rel="apple-touch-icon-precomposed" href="{{ asset ('images/logo2.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/sweetalert.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/custom.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @stack("styles")
</head>
<body class="body">
<div id="wrapper">
    <div id="page" class="">
        <div class="layout-wrap">

            <!-- <div id="preload" class="preload-container">
<div class="preloading">
    <span></span>
</div>
</div> -->

            <div class="section-menu-left">
                <div class="box-logo">
                    <a href="index.html" id="site-logo-inner">
                        <img class="" id="logo_header_1" alt="" src="{{asset ('images/logo/logo.png')}}"
                             data-light="{{asset ('images/logo/logo.png')}}" data-dark="{{asset ('images/logo/logo.png')}}">
                    </a>
                    <div class="button-show-hide">
                        <i class="icon-menu-left"></i>
                    </div>
                </div>
                <div class="center">
                    <div class="center-item">
                        <div class="center-heading">Главная</div>
                        <ul class="menu-list">
                            <li class="menu-item">
                                <a href="{{route('admin.index')}}" class="">
                                    <div class="icon"><i class="icon-grid"></i></div>
                                    <div class="text">Панель Администратора</div>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="center-item">
                        <ul class="menu-list">
                            <li class="menu-item has-children">
                                <a href="javascript:void(0);" class="menu-item-button">
                                    <div class="icon"><i class="icon-shopping-cart"></i></div>
                                    <div class="text">Товары</div>
                                </a>
                                <ul class="sub-menu">
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.product.add')}}" class="">
                                            <div class="text">Добавить товар</div>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.products')}}" class="">
                                            <div class="text">Товары</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item has-children">
                                <a href="javascript:void(0);" class="menu-item-button">
                                    <div class="icon"><i class="icon-layers"></i></div>
                                    <div class="text">Бренд</div>
                                </a>
                                <ul class="sub-menu">
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.brand.add')}}" class="">
                                            <div class="text">New Бренд</div>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.brands')}}" class="">
                                            <div class="text">Бренды</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item has-children">
                                <a href="javascript:void(0);" class="menu-item-button">
                                    <div class="icon"><i class="icon-layers"></i></div>
                                    <div class="text">Категории</div>
                                </a>
                                <ul class="sub-menu">
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.category.add')}}" class="">
                                            <div class="text">New Категории</div>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.categories')}}" class="">
                                            <div class="text">Категории</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-item has-children">
                                <a href="javascript:void(0);" class="menu-item-button">
                                    <div class="icon"><i class="icon-file-plus"></i></div>
                                    <div class="text">Заказ</div>
                                </a>
                                <ul class="sub-menu">
                                    <li class="sub-menu-item">
                                        <a href="{{route('admin.orders')}}" class="">
                                            <div class="text">Заказы</div>
                                        </a>
                                    </li>
                                    <li class="sub-menu-item">
                                        <a href="order-tracking.html" class="">
                                            <div class="text">Отслеживание заказа</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.slides')}}" class="">
                                    <div class="icon"><i class="icon-image"></i></div>
                                    <div class="text">Текстовые слайды</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.coupons')}}" class="">
                                    <div class="icon"><i class="icon-grid"></i></div>
                                    <div class="text">Промокоды</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a href="{{route('admin.contacts')}}" class="">
                                    <div class="icon"><i class="icon-mail"></i></div>
                                    <div class="text">Сообщения</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="users.html" class="">
                                    <div class="icon"><i class="icon-user"></i></div>
                                    <div class="text">Пользователь</div>
                                </a>
                            </li>

                            <li class="menu-item">
                                <a href="settings.html" class="">
                                    <div class="icon"><i class="icon-settings"></i></div>
                                    <div class="text">Настройки</div>
                                </a>
                            </li>
                            <li class="menu-item">
                                <form method="POST" action = "{{route ('logout')}}" id="logout-form">
                                    @csrf
                                <a href="{{route ('logout')}}" class="" onclick = "event.preventDefault();document.getElementById('logout-form').submit();" >
                                    <div class="icon"><i class="icon-settings"></i></div>
                                    <div class="text">Выход</div>
                                </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section-content-right">

                <div class="header-dashboard">
                    <div class="wrap">
                        <div class="header-left">
                            <a href="index-2.html">
                                <img class="" id="logo_header_mobile" alt="" src="images/logo/logo.png"
                                     data-light="images/logo/logo.png" data-dark="images/logo/logo.png"
                                     data-width="154px" data-height="52px" data-retina="images/logo/logo.png">
                            </a>
                            <div class="button-show-hide">
                                <i class="icon-menu-left"></i>
                            </div>


                            <form class="form-search flex-grow">
                                <fieldset class="name">
                                    <input type="text" placeholder="Поиск..." class="show-search" name="name"  id = "search-input" tabindex="2" value="" aria-required="true" required="">
                                </fieldset>
                                <div class="button-submit">
                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                </div>
                                <div class="box-content-search">
                                    <ul id="box-content-search">

                                    </ul>

                                </div>
                            </form>

                        </div>
                        <div class="header-grid">

                            <div class="popup-wrap message type-header">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-item">
                                                <span class="text-tiny">1</span>
                                                <i class="icon-bell"></i>
                                            </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end has-content"
                                        aria-labelledby="dropdownMenuButton2">
                                        <li>
                                            <h6>Notifications</h6>
                                        </li>
                                        <li>
                                            <div class="message-item item-1">
                                                <div class="image">
                                                    <i class="icon-noti-1"></i>
                                                </div>
                                                <div>
                                                    <div class="body-title-2">Discount available</div>
                                                    <div class="text-tiny">Morbi sapien massa, ultricies at rhoncus
                                                        at, ullamcorper nec diam</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message-item item-2">
                                                <div class="image">
                                                    <i class="icon-noti-2"></i>
                                                </div>
                                                <div>
                                                    <div class="body-title-2">Account has been verified</div>
                                                    <div class="text-tiny">Mauris libero ex, iaculis vitae rhoncus
                                                        et</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message-item item-3">
                                                <div class="image">
                                                    <i class="icon-noti-3"></i>
                                                </div>
                                                <div>
                                                    <div class="body-title-2">Order shipped successfully</div>
                                                    <div class="text-tiny">Integer aliquam eros nec sollicitudin
                                                        sollicitudin</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="message-item item-4">
                                                <div class="image">
                                                    <i class="icon-noti-4"></i>
                                                </div>
                                                <div>
                                                    <div class="body-title-2">Order pending: <span>ID 305830</span>
                                                    </div>
                                                    <div class="text-tiny">Ultricies at rhoncus at ullamcorper</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li><a href="#" class="tf-button w-full">View all</a></li>
                                    </ul>
                                </div>
                            </div>




                            <div class="popup-wrap user type-header">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <span class="image">
                                                    <img src="images/avatar/user-2.jpg" alt="">
                                                </span>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">Гильманов Денис</span>
                                                    <span class="text-tiny">Admin</span>
                                                </span>
                                            </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end has-content"
                                        aria-labelledby="dropdownMenuButton3">
                                        <li>
                                            <a href="#" class="user-item">
                                                <div class="icon">
                                                    <i class="icon-user"></i>
                                                </div>
                                                <div class="body-title-2">Аккаунт</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="user-item">
                                                <div class="icon">
                                                    <i class="icon-mail"></i>
                                                </div>
                                                <div class="body-title-2">Входящие</div>
                                                <div class="number">27</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="user-item">
                                                <div class="icon">
                                                    <i class="icon-file-text"></i>
                                                </div>
                                                <div class="body-title-2">Панель задач</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="user-item">
                                                <div class="icon">
                                                    <i class="icon-headphones"></i>
                                                </div>
                                                <div class="body-title-2">Поддержка</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="login.html" class="user-item">
                                                <div class="icon">
                                                    <i class="icon-log-out"></i>
                                                </div>
                                                <div class="body-title-2">Выход</div>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="main-content">
                   @yield('content')
                   <a href="{{ route('products.export.xml') }}" class="btn btn-primary">
                    📥 Выгрузить каталог в XML
                </a>
                <a href="{{ route('orders.export.xml') }}" class="btn btn-secondary">
                    📦 Выгрузить заказы (XML)
                </a>

                    <div class="bottom-page">
                        <div class="body-text">Гильманов Д.Р. © 2025 КФУ</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset ('js/jquery.min.js')}}"></script>
<script src="{{ asset ('js/bootstrap.min.js')}}"></script>
<script src="{{ asset ('js/bootstrap-select.min.js')}}"></script>
<script src="{{ asset ('js/sweetalert.min.js')}}"></script>
<script src="{{ asset ('js/apexcharts/apexcharts.js')}}"></script>
<script src="{{ asset ('js/main.js')}}"></script>
<script>
    $(function () {
        $('#search-input').on('keyup', function () {
            var searchQuery = $(this).val();

            if (searchQuery.length > 2) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('admin.search') }}",
                    data: { query: searchQuery },
                    dataType: "json",
                    success: function (data) {
                        $('#box-content-search').html('');

                        $.each(data, function (index, item) {
                            var url = "{{ route('admin.product.edit', ['id' => 'product_id']) }}";
                            var link = url.replace('product_id', item.id);

                            $('#box-content-search').append(`
                                <li class="products__item">
                                    <div class="image">
                                        <img src="{{ asset('uploads/products/thumbnails') }}/${item.image}" alt="${item.name}" style="max-width: 100px;">
                                    </div>
                                    <div class="flex items-center justify-between gap-20 flex-grow">
                                        <div class="name">
                                            <a href="${link}" class="body-text">${item.name}</a>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-10">
                                    <div class="divider"></div>
                                </li>
                            `);
                        });
                    }
                });
            }
        });
    });
</script>

@stack("scripts")
</body>

</html>
