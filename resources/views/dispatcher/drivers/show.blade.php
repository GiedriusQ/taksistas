@extends('layout')
@section('content')
    <div class="jumbotron">
        <h2>Driver - {{$driver->name}}</h2>
        <div>
            Email: <b>{{$driver->email}}</b>
        </div>
        <div>
            City: <b>{{$driver->city}}</b>
        </div>
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th colspan="4">Orders</th>
                    </tr>
                    <tr>
                        <th>Id</th>
                        <th>Status</th>
                        <th>Client</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders->data as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->status}}</td>
                            <td>{{$order->client}}</td>
                            <td>
                                <a href="{{action('Front\Dispatcher\OrderController@getShowOrder',$order->id)}}">Show</a>
                                <a href="{{action('Front\Dispatcher\OrderController@getEditOrder',$order->id)}}">Edit</a>
                                <a href="{{action('Front\Dispatcher\OrderController@getDeleteOrder',$order->id)}}">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No orders found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('partials.pagination',['paginator'=>$orders])
    </div>
@endsection

@section('js')
@endsection