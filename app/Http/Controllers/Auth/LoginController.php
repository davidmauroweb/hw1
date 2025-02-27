<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Customer;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
    
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
           $request->session()->regenerate();

            if(!Auth::user()->is_admin) {
                if(!Auth::user()->dash){
                    $dash = Auth::user()->user_id;
                } else {
                    $dash = Auth::user()->dash;
                }
            $customer = DB::table('customers')
           ->select(DB::raw("CONCAT(customers.customer_id, '||||PC-ASSI.2023#||||', customers.business_name) as customer_x, customers.business_name"))
           ->where('customers.user_id', $dash)
           ->where('customers.enabled', 1)
           ->orderBy('business_name')
           ->take(1)
           ->get();
           return redirect()->intended('dashboard/'.base64_encode($customer[0]->customer_x));
            }
            
            if(Auth::user()->is_admin) {
                return redirect()->intended('customers');
            }
          
        }
            return back()->withErrors([
            'email' => '¡El correo electrónico o la contraseña son incorrectos!',
        ]); 
    }
}
