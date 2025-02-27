<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\{FromView,ShouldAutoSize};
//use Maatwebsite\Excel\Concerns\FromCollection;

class xlsu implements FromView,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $i;
    function __construct($i) {
        $this->i = $i;
    }
    public function view():View
    {
        $i = $this->i;
        $customer = Customer::find($i);
        $dt = DB::table('devices')->where('devices.customer_id', $i)->count();
        $devices = DB::table('devices')
        ->leftJoin(DB::Raw('(SELECT * FROM components WHERE low = 0) components'), 'components.device_id', 'devices.device_id')
        ->select('devices.device_id', 'devices.description','devices.usuario', 'devices.serie', 'devices.location', DB::raw('COUNT(components.component_id) as q_components'), DB::raw('SUM(components.amount) as s_components'), 'devices.created_at', 'devices.enabled')
        ->addSelect(DB::raw('ROW_NUMBER() OVER (order by device_id) AS num'))
        ->where('devices.customer_id', $i)
        ->where('devices.description', 'LIKE', (isset($request->string_find) ? '%'.$request->string_find.'%' : '%%'))
        ->groupBy('devices.device_id', 'devices.description', 'devices.created_at', 'devices.enabled')
        ->get();
        
        $components = DB::table('components')
        ->leftJoin('devices', 'components.device_id','devices.device_id')
        ->select('components.component_id','components.device_id','components.trademark','components.features','components.amount')
        ->where('customer_id', '=', $i)
        ->where('low','=', 0)
        ->get();
        return view('devices.xlsu',['devices' => $devices, 'business_name' => $customer->business_name, 'comp' => $components,'total'=>$dt]);
    }
}
