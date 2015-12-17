@extends('layout')
@section('content')
    <div class="jumbotron">
        <h1>Order #{{$order->id}}</h1>
        <div>
            Take from: <b>{{$order->take_from}}</b>
        </div>
        <div>
            Transport to: <b>{{$order->transport_to}}</b>
        </div>
        <div>
            Client: <b>{{$order->client}}</b>
        </div>
        <div>
            Added at: <b>{{$order->created_at}} ({{$order->date_diff}})</b>
        </div>
        <div>
            Current status: <b>{{$order->status}}</b>
        </div>
        <div>Status history:
            <ul>
                @foreach($order->status_history as $status)
                    <li>{{$status->status}} {{$status->created_at}} ({{$status->date_diff}})</li>

                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('js')
@endsection