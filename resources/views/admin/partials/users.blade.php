<h1>{{isset($info)?$info." ":""}}{{$resource_name}}</h1>
<a href="{{action('Front\Admin\UserController@getCreate'.$name)}}">Create new</a>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Id</th>
                <th>Email</th>
                <th>Role</th>
                <th>Name</th>
                <th>City</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items->data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->role}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->city}}</td>
                    <td>
                        <a href="{{action('Front\Admin\UserController@getEdit'.$name,$item->id)}}">Edit</a>
                        <a href="{{action('Front\Admin\UserController@getDelete'.$name,$item->id)}}">Delete</a>
                        @if($name == 'Dispatcher')
                            <a href="{{action('Front\Admin\UserController@getDispatcherDrivers',$item->id)}}">Show
                                drivers</a>

                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No {{$resource_name}} found!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@include('partials.pagination',['paginator'=>$items])