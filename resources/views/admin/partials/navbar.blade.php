<ul class="nav navbar-nav">
    <li><a href="{{action('Front\Admin\UserController@getAdmins')}}">Administrators</a></li>
    <li><a href="{{action('Front\Admin\UserController@getDispatchers')}}">Dispatchers</a></li>
    <li><a href="{{action('Front\Admin\UserController@getDrivers')}}">Drivers</a></li>
    <li><a href="{{action('Front\Admin\OrderController@getOrders')}}">Orders</a></li>
</ul>