@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Orders</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
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
                                <a href="{{action('Front\Driver\OrderController@getShowOrder',$order->id)}}">Show</a>
                                <a href="{{action('Front\Driver\OrderController@getEditOrder',$order->id)}}">Edit</a>
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