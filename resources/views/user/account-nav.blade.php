<ul class="account-nav">
    <li><a href="{{route('user.index')}}" class="menu-link menu-link_us-s">Панель управления</a></li>
    <li><a href="{{route('user.orders')}}" class="menu-link menu-link_us-s">Заказы </a></li>
    <li><a href="{{route('cart.checkout')}}" class="menu-link menu-link_us-s">Адрес</a></li>
    <li><a href="{{route('wishlist.index')}}" class="menu-link menu-link_us-s">Понравилось</a></li>

    <li>
        <form method ="POST" action = "{{route('logout')}}" id = "logout-form">
            @csrf
            <a href="{{route('logout')}}" class="menu-link menu-link_us-s" onclick = "event.preventDefault();document.getElementById('logout-form').submit();">Выход</a>
        </form>
    </li>

</ul>
