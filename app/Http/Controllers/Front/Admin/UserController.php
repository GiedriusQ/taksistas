<?php

namespace App\Http\Controllers\Front\Admin;

use App\GK\Utilities\API;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * @var API
     */
    private $API;

    /**
     * UserController constructor.
     * @param API $API
     */
    public function __construct(API $API)
    {
        $this->API = $API;
    }

    public function getAdmins()
    {
        $admins = $this->API->call(API::admin_admins);

        return view('admin.admins.index', compact('admins'));
    }

    public function getDispatchers()
    {
        $dispatchers = $this->API->call(API::admin_dispatchers);

        return view('admin.dispatchers.index', compact('dispatchers'));
    }

    public function getDispatcherDrivers($id)
    {
        $dispatcher = $this->API->call(API::admin_users . "/{$id}")->data;
        $info       = $dispatcher->name;
        $drivers    = $this->API->call(API::admin_dispatchers_drivers . "/{$id}/drivers");

        return view('admin.drivers.index', compact('drivers', 'info'));
    }

    public function getDrivers()
    {
        $drivers = $this->API->call(API::admin_drivers);

        return view('admin.drivers.index', compact('drivers'));
    }

    public function getCreateAdmin()
    {
        return view('admin.admins.create');
    }

    public function getCreateDriver()
    {
        $dispatchers_list = $this->API->call(API::admin_dispatchers_list)->data;

        //@todo refactor me
        $out = [];
        foreach ($dispatchers_list as $dispatcher) {
            $out[$dispatcher->id] = $dispatcher->name;
        }
        $dispatchers_list = $out;

        return view('admin.drivers.create', compact('dispatchers_list'));
    }

    public function getCreateDispatcher()
    {
        return view('admin.dispatchers.create');
    }

    public function getEditAdmin($id)
    {
        $admin = $this->API->call(API::admin_users . "/{$id}");

        return view('admin.admins.edit', compact('admin'));
    }

    public function getEditDriver($id)
    {
        $driver = $this->API->call(API::admin_users . "/{$id}");

        return view('admin.drivers.edit', compact('driver'));
    }

    public function getEditDispatcher($id)
    {
        $dispatcher = $this->API->call(API::admin_users . "/{$id}");

        return view('admin.dispatchers.edit', compact('dispatcher'));
    }

    public function getDeleteAdmin($id)
    {
        $admin = $this->API->call(API::admin_users . "/{$id}", 'DELETE');
        if ($admin->status_code != 200) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getAdmins')->withSuccess('Admin deleted successfully');
    }

    public function getDeleteDispatcher($id)
    {
        $dispatcher = $this->API->call(API::admin_users . "/{$id}", 'DELETE');
        if ($dispatcher->status_code != 200) {
            return redirect()->back()->withErrors($dispatcher->error);
        }

        return redirect()->action('Front\Admin\UserController@getDispatchers')->withSuccess('Dispatcher deleted successfully');
    }

    public function getDeleteDriver($id)
    {
        $driver = $this->API->call(API::admin_users . "/{$id}", 'DELETE');
        if ($driver->status_code != 200) {
            return redirect()->back()->withErrors($driver->error);
        }

        return redirect()->action('Front\Admin\UserController@getDrivers')->withSuccess('Driver deleted successfully');
    }

    public function postEditAdmin(Request $request, $id)
    {
        $admin = $this->API->call(API::admin_users . "/{$id}", 'PUT', $request->all());
        if ($admin->status_code != 200) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getAdmins')->withSuccess('Admin updated successfully');
    }

    public function postEditDriver(Request $request, $id)
    {
        $admin = $this->API->call(API::admin_users . "/{$id}", 'PUT', $request->all());
        if ($admin->status_code != 200) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getDrivers')->withSuccess('Driver updated successfully');
    }

    public function postEditDispatcher(Request $request, $id)
    {
        $admin = $this->API->call(API::admin_users . "/{$id}", 'PUT', $request->all());
        if ($admin->status_code != 200) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getDispatchers')->withSuccess('Dispatcher updated successfully');
    }

    public function postCreateAdmin(Request $request)
    {
        $admin = $this->API->call(API::admin_admins_list, 'POST', $request->all());

        if ($admin->status_code != 201) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getAdmins')->withSuccess('Admin created successfully');
    }

    public function postCreateDispatcher(Request $request)
    {
        $admin = $this->API->call(API::admin_dispatchers_list, 'POST', $request->all());

        if ($admin->status_code != 201) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getDispatchers')->withSuccess('Dispatcher created successfully');
    }

    public function postCreateDriver(Request $request)
    {
        $admin = $this->API->call(API::admin_dispatchers_drivers . '/' . $request->get('dispatcher_id') . '/drivers',
            'POST',
            $request->all());
        if ($admin->status_code != 201) {
            return redirect()->back()->withErrors($admin->error);
        }

        return redirect()->action('Front\Admin\UserController@getDrivers')->withSuccess('Driver created successfully');
    }

}
