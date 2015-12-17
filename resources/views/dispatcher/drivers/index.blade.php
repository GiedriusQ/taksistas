@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Drivers</h1>
        <a href="{{action('Front\Dispatcher\DriverController@getCreateDriver')}}">Create new</a>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($drivers->data as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->role}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->city}}</td>
                            <td>
                                <a href="{{action('Front\Dispatcher\DriverController@getEditDriver',$item->id)}}">Edit</a>
                                <a href="{{action('Front\Dispatcher\DriverController@getShowDriver',$item->id)}}">Show</a>
                                <a href="{{action('Front\Dispatcher\DriverController@getDeleteDriver',$item->id)}}">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No drivers found!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @include('partials.pagination',['paginator'=>$drivers])
    </div>
@endsection

@section('js')
@endsection