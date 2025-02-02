<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};
use App\Models\Customer;
use PDF;

class DashboardController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
    
    public function detail($customer, $id) {
        
        $customer = base64_decode($customer);
        $x = explode("||||", $customer);
          $components = DB::table('hardware')
        ->join('components', 'components.hardware_id', 'hardware.hardware_id')
        ->join('devices', 'devices.device_id', 'components.device_id')
        ->selectRaw('hardware.icon, hardware.denomination, components.trademark, components.features, components.original, components.acquired, components.date_of_expiry, components.amount, IF(components.low = 1, components.discharge_date, "") low')
        ->where('devices.customer_id', $x[0])
        ->where('components.device_id', $id)
         ->get();
        return json_encode($components);

    }

    public function dashboard($id) {

        $customers = DB::table('customers')
        ->select(DB::raw("CONCAT(customers.customer_id, '||||PC-ASSI.2023#||||', customers.business_name) as customer_x, customers.business_name"))
        ->where('customers.user_id', Auth::user()->user_id)
        ->where('customers.enabled', 1)
        ->orderBy('business_name')
        ->get();

        $resume = array();
        $devices = array();
        $counts = array();

        $i = base64_decode($id);
        $x = explode("||||",$i);
        $i = $x[0];

        $verification_id = Customer::find($i);
        if(($verification_id->user_id == Auth::user()->user_id) || Auth::user()->is_admin)
            {
        $resume = DB::table('hardware')
        ->leftJoin(DB::RAW("(SELECT component_id, amount, hardware_id FROM  components C INNER JOIN devices D ON D.device_id = C.device_id WHERE D.customer_id = ".$i." and low = 0) c"), 'hardware.hardware_id', 'c.hardware_id')
        ->select('hardware.hardware_id', 'hardware.denomination', DB::raw("COUNT(component_id) as q, SUM(amount) as w"))
        ->groupBy('hardware.hardware_id', 'hardware.denomination')
        ->orderBy('hardware.denomination')
        ->get();

        $devices = DB::table('devices')
        ->leftJoin(DB::Raw('(SELECT * FROM components WHERE low = 0) components'), 'components.device_id', 'devices.device_id')
        ->select('devices.device_id','devices.customer_id', 'devices.description', DB::raw('COUNT(components.component_id) as q_components'), DB::raw('SUM(components.amount) as s_components'), 'devices.created_at', 'devices.enabled')
        ->where('devices.customer_id', $i)
        ->groupBy('devices.device_id', 'devices.description', 'devices.created_at', 'devices.enabled')
        ->get();

        $counts = DB::table('devices')
        ->leftJoin(DB::Raw('(SELECT * FROM components WHERE low = 0) components'), 'components.device_id', 'devices.device_id')
        ->select(DB::raw('COUNT(DISTINCT devices.device_id) as q_devices'), DB::raw('COUNT(components.component_id) as q_components'), DB::raw('SUM(components.amount) as s_components'))
        ->where('devices.customer_id', $i)
        ->get();

        }

       return view('devices.dashboard', ['data' => $resume, 'customer' => $x[2], '_id' => $id, 'customers' => $customers, 'devices' => $devices, 'counts' => $counts]);

    }

    public function pdfu($id)
    {
        $i = base64_decode($id);
        $x = explode("||||",$i);
        $i = $x[0];
        $customer = Customer::find($i);
        $dt = DB::table('devices')->where('devices.customer_id', $i)->count();
        $devices = DB::table('devices')
        ->leftJoin(DB::Raw('(SELECT * FROM components WHERE low = 0) components'), 'components.device_id', 'devices.device_id')
        ->select('devices.device_id', 'devices.description', 'devices.serie', 'devices.location', DB::raw('COUNT(components.component_id) as q_components'), DB::raw('SUM(components.amount) as s_components'), 'devices.created_at', 'devices.enabled')
        ->addSelect(DB::raw('ROW_NUMBER() OVER (order by device_id) AS num'))
        ->where('devices.customer_id', $i)
        ->where('devices.description', 'LIKE', (isset($request->string_find) ? '%'.$request->string_find.'%' : '%%'))
        ->groupBy('devices.device_id', 'devices.description', 'devices.created_at', 'devices.enabled')
        ->get();

///////////////////////

        $components = DB::table('components')
        ->leftJoin('devices', 'components.device_id','devices.device_id')
        ->select('components.component_id','components.device_id','components.trademark','components.features','components.amount')
        ->where('customer_id', '=', $i)
        ->where('low','=', 0)
        ->get();
        //return view('devices.pdf', ['devices' => $devices, 'business_name' => $customer->business_name, 'comp' => $components,'total'=>$dt]);
        $pdf = PDF::loadView('devices.pdf', ['devices' => $devices, 'business_name' => $customer->business_name, 'comp' => $components,'total'=>$dt]);
        return $pdf->setPaper('a4')->download($customer->business_name.'.pdf');

    }
    public function qr($id)
    {
        $i = base64_decode($id);
        $device = DB::table('devices')
        ->select('description','location','serie','obs','customers.user_id','customers.business_name','users.username')
        ->join('customers', 'devices.customer_id','customers.customer_id')
        ->join('users','customers.user_id','users.user_id')
        ->where('devices.device_id', '=', $i)
        ->first();
        $components = DB::table('components')
        ->leftJoin('hardware', 'components.hardware_id','hardware.hardware_id')
        ->selectRaw('hardware.icon, hardware.denomination, components.trademark, components.features, components.original, components.acquired, components.date_of_expiry, components.amount, IF(components.low = 1, components.discharge_date, "") low')
        ->where('components.device_id', '=', $i)
        ->where('low','=', 0)
        ->get();
        if ((Auth::user()->user_id == $device->user_id)||(Auth::user()->user_id == 1))
            {
                return view('devices.qr', ['equipo' => $device, 'components' => $components]);
            }
        else
        {
            echo "
            <html>
<head>
<style>
.center {
  text-align: center;
  color: red;
}
</style>
</head>
<body>

<h1 class='center'>Error de sesión</h1>
<p class='center'>El equipo al que quiere acceder pertenece a otro usuario.</p> 

</body>
</html>
            ";
        }

    }
}
