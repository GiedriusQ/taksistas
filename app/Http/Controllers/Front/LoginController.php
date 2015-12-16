<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\GK\Utilities\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @var API
     */
    private $API;

    /**
     * LoginController constructor.
     * @param API $API
     */
    public function __construct(API $API)
    {
        $this->API = $API;
        $this->middleware('frontend.guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $loginRequest)
    {
        $response = $this->API->call(API::login_url, 'post', [
            'email'    => $loginRequest->get('email'),
            'password' => $loginRequest->get('password')
        ]);
        if ($response->status_code == '200') {
            session([
                'email'    => $loginRequest->get('email'),
                'password' => $loginRequest->get('password'),
                'user'     => $response->data
            ]);

            return redirect()->to('/frontend')->withSuccess('Logged in successfully');
        }

        return redirect()->back()->withErrors([$response->error->message]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('email');
        $request->session()->forget('password');

        return redirect()->to('frontend');
    }

}
