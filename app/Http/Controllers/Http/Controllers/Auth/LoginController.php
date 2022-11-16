<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated()
    {
        if ( Auth::user()->hak_akses == 'User' ) {
            return redirect(route('user.index'));
        }
        else if ( Auth::user()->hak_akses == 'Infra' ) {
            return redirect(route('infra.index'));
        }
        else if ( Auth::user()->hak_akses == 'Finance' ) {
            return redirect(route('finance.index'));
        }
        else if ( Auth::user()->hak_akses == 'Kasir' ) {
            return redirect(route('tampilkasir'));
        }
        else if ( Auth::user()->hak_akses == 'Supplychain' ) {
            return redirect(route('supplychain.index'));
        }
        else if ( Auth::user()->hak_akses == 'Admin Bigwarehouse' ) {
            return redirect(route('master'));
        }
        else if ( Auth::user()->hak_akses == 'Admin Eggwarehouse' ) {
            return redirect(route('master'));
        }
        else if ( Auth::user()->hak_akses == 'Admin Premixwarehouse' ) {
            return redirect(route('master'));
        }
        else if ( Auth::user()->hak_akses == 'Admin Gudangcabang' ) {
            return redirect(route('master'));
        }
        else if ( Auth::user()->hak_akses == 'Admin Financewarehouse' ) {
            return redirect(route('laporan'));
        }
        else if ( Auth::user()->hak_akses == 'RnD' ) {
            return redirect(route('rnd.index'));
        }
        return redirect('/');
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['userstatus'] = 'aktif';

        return $credentials;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
