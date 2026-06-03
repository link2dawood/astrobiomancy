@php $L = app()->getLocale(); @endphp
<div class="col-lg-4 col-xl-3 mb-5">
<div class="card">
    <div class="list-group list-group-flush small">
        <a class="list-group-item list-group-item-action p-3" href="{{ url($L . '/users/account') }}">
            <i class="fas fa-user fa-fw me-2 text-gray-400"></i>
            {{ __('site.nav_profile') }}
        </a>
        <a class="list-group-item list-group-item-action p-3" href="{{ url($L . '/users/address') }}">
            <i class="fas fa-map-marker-alt fa-fw me-2 text-gray-400"></i>
            {{ __('site.nav_address') }}
        </a>
        <a class="list-group-item list-group-item-action p-3" href="{{ url($L . '/users/orders') }}">
            <i class="fas fa-shopping-cart fa-fw me-2 text-gray-400"></i>
            {{ __('site.nav_orders') }}
        </a>
        <a class="list-group-item list-group-item-action p-3" href="{{ url($L . '/users/logout') }}">
            <i class="fas fa-sign-out fa-fw me-2 text-gray-400"></i>
            {{ __('site.nav_logout') }}
        </a>
    </div>
</div>
</div>
