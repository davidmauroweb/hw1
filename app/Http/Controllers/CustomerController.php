<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Customer, User};
use Illuminate\Support\Facades\DB; 
use Exception;

class CustomerController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('check.role');
    }
    
    public function index(Request $request)
    {
        $customers = DB::table('customers')
        ->join('users', 'users.user_id', 'customers.user_id')
        ->leftJoin('devices', 'devices.customer_id' , 'customers.customer_id')
        ->select('customers.customer_id', 'customers.user_id', 'customers.business_name', 'users.username', DB::raw("COUNT(devices.device_id) as q_devices"), DB::raw("CONCAT(customers.customer_id, '||||PC-ASSI.2023#||||', customers.business_name) as customer_x"), 'customers.enabled')
        ->where('customers.business_name', 'LIKE', '%'.$request->string.'%')
        ->groupBy('customers.customer_id', 'customers.user_id', 'customers.business_name', 'users.username', 'customer_x', 'customers.enabled')
        ->paginate(10);
        $users = User::all()->sortBy('business_name');
        return view('customers.list', ['customers' => $customers, 'users' => $users, 'string' => $request->string]);
    }

    public function store(Request $request)
    {
        try {
            if($request->customer_id == 0) {
                $customer = new Customer();
                $message = "¡Se registró el cliente {$request->business_name} de forma correcta!";
            }
                else {
                $customer = Customer::find($request->customer_id);
                $message =  "¡Se actualizó el cliente {$request->business_name} de forma correcta!";
             }
                $customer->business_name = $request->business_name;
                $customer->user_id = $request->user_id;
                $customer->save();
                $result = "success";
            }
            catch (Exception $e) {
                $result = "error";
                $message = "¡Surgió un error, verifique que los datos sean correctos!";
    
            }
                return redirect()->route('customers.index')->with($result, $message);
        }
        
    public function update($id)
    {
       try {
        $customer = Customer::find($id);
        $x =  $customer->enabled;
        $customer->enabled = !$customer->enabled;
        $customer->save();
        $result = "success";
        $message = "¡El cliente se ".($x == 1 ? "deshabilitó" : "habilitó")." correctamente!";
        }
        catch (Exception $e) {
            $result = "error";
            $message = "¡Surgió un error!";

        }
            return redirect()->route('customers.index')->with($result, $message);
    }

}
