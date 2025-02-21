<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Component, Customer, Device, Hardware};
use Illuminate\Support\Facades\{Auth, DB};
use Exception; 
use PDF;

class DeviceController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('check.role');
    }

    public function index(Request $request)
    {
        $dt = DB::table('devices')->where('devices.customer_id', $request->id)->count();
        $devices = DB::table('devices')
        ->leftJoin(DB::Raw('(SELECT * FROM components WHERE low = 0) components'), 'components.device_id', 'devices.device_id')
        ->select('devices.device_id','devices.obs', 'devices.description', 'devices.serie','devices.usuario', 'devices.location', DB::raw('COUNT(components.component_id) as q_components'), DB::raw('SUM(components.amount) as s_components'), 'devices.created_at', 'devices.enabled')
        ->addSelect(DB::raw('ROW_NUMBER() OVER (order by device_id) AS num'))
        ->where('devices.customer_id', $request->id)
        ->where('devices.description', 'LIKE', (isset($request->string_find) ? '%'.$request->string_find.'%' : '%%'))
        ->groupBy('devices.device_id', 'devices.description', 'devices.created_at', 'devices.enabled')
        ->paginate(10);
        $customer = Customer::find($request->id);
        $hardware = Hardware::all()->sortBy('denomination');
        return view('devices.list', ['devices' => $devices, 'hardware'=> $hardware, 'business_name' => $customer->business_name, 'customer_id' => $customer->customer_id, 'string_find' => $request->string_find, 'total' => $dt]);
    }

    public function pdf(Request $request)
    {
        $customer = Customer::find($request->id);
        $dt = DB::table('devices')->where('devices.customer_id', $request->id)->count();
        $devices = DB::table('devices')
        ->leftJoin(DB::Raw('(SELECT * FROM components WHERE low = 0) components'), 'components.device_id', 'devices.device_id')
        ->select('devices.device_id', 'devices.description','devices.serie', 'devices.location', DB::raw('COUNT(components.component_id) as q_components'), DB::raw('SUM(components.amount) as s_components'), 'devices.created_at', 'devices.enabled')
        ->addSelect(DB::raw('ROW_NUMBER() OVER (order by device_id) AS num'))
        ->where('devices.customer_id', $request->id)
        ->where('devices.description', 'LIKE', (isset($request->string_find) ? '%'.$request->string_find.'%' : '%%'))
        ->groupBy('devices.device_id', 'devices.description', 'devices.created_at', 'devices.enabled')
        ->get();

///////////////////////

        $components = DB::table('components')
        ->leftJoin('devices', 'components.device_id','devices.device_id')
        ->select('components.component_id','components.device_id','components.trademark','components.features','components.amount')
        ->where('customer_id', '=', $request->id)
        ->where('low','=', 0)
        ->get();
        //return view('devices.pdf', ['devices' => $devices, 'business_name' => $customer->business_name, 'comp' => $components,'total'=>$dt]);
        $pdf = PDF::loadView('devices.pdf', ['devices' => $devices, 'business_name' => $customer->business_name, 'comp' => $components,'total'=>$dt]);
        return $pdf->setPaper('A4', 'portrait')->download($customer->business_name.'.pdf');
    }

    public function pdfqrls(Request $request)
    {
        $customer = Customer::find($request->id);
        $dt = DB::table('devices')->where('devices.customer_id', $request->id)->count();
        $devices = DB::table('devices')
        ->select('devices.device_id', 'devices.description','devices.serie', 'devices.location','devices.created_at')
        ->where('devices.customer_id', $request->id)
        ->get();
        $pdf = PDF::loadView('devices.pdf-qrls', ['devices' => $devices, 'business_name' => $customer->business_name, 'total'=>$dt]);
        return $pdf->setPaper('A4', 'portrait')->download($customer->business_name.'.pdf');
    }

    public function store(Request $request)
    {
         try {
                $hardware = new Device();
                $hardware->customer_id = $request->customer_id;
                $hardware->description = $request->description;
                $hardware->serie = $request->serie;
                $hardware->usuario = $request->usuario;
                $hardware->location = $request->location;
                $hardware->obs = $request->obs;
                $hardware->save();
                $result = "success";
                $message = "Se registró correctamente la licencia bajo el ID {$hardware->device_id}";
               } 
               catch(Exception $e)
               {
                $result = "error";
                $message = "Surgió un error, verique los datos!";
               }
      return redirect()->route('devices.index', $request->customer_id)->with($result, $message);
    }

    public function destroy($id)
    {
        $device = Device::find($id);
      try
        {
        $device->delete();
        $result = 'success';
        $message = "Se eliminó correctamente el registro {$id}!";
        }
        catch(Exception $e){
            $result = 'error';
            $message = "Sucedió un error!";  
        }
       return redirect()->route('devices.index', $device->customer_id)->with($result, $message);
    }
    public function obs(Request $request)
    {
        $upd = Device::find($request->device_id);
        $upd->obs = $request->obs;
        $upd->serie = $request->ser;
        $upd->description = $request->desc;
        $upd->location = $request->loc;
        $upd->usuario = $request->usuario;
        $upd->save();
        $param = $request->customer_id."?page=".$request->pg;
        return redirect()->route('devices.index', $param);
    }
}
