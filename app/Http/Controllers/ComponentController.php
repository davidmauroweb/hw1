<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Component, Hardware};
use Illuminate\Support\Facades\{Auth, DB};
use Exception;

class ComponentController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('check.role');
    }

    public function index($id, $type)
    {
       $components = DB::table('components')
        ->join('hardware', 'hardware.hardware_id', 'components.hardware_id')
        ->select('components.component_id', 'components.device_id', 'hardware.denomination', 'hardware.icon', 'components.trademark', 'components.features', 'components.original', 'components.acquired', 'components.date_of_expiry', 'components.amount', 'components.discharge_date', DB::raw("CONCAT(ROUND(DATEDIFF(CURDATE(), components.acquired) / 365), ' AÑOS')  as time"))
        ->where('components.device_id', $id)
        ->where('components.low', '=', $type)
        ->get();
        return response()->json($components);
    }

    public function show($id)
    {
       $components = DB::table('components')
        ->join('hardware', 'hardware.hardware_id', 'components.hardware_id')
        ->join('devices','devices.device_id','components.device_id')
        ->select('devices.customer_id', 'hardware.denomination', 'components.component_id', 'components.device_id', 'components.hardware_id', 'components.trademark', 'components.features', 'components.original', 'components.acquired', 'components.date_of_expiry', 'components.amount', 'components.discharge_date', DB::raw("CONCAT(ROUND(DATEDIFF(CURDATE(), components.acquired) / 365), ' AÑOS')  as time"))
        ->where('components.component_id', $id)
        ->get();
        return response()->json($components);
    }

   public function store(Request $request)
    {


      try {
            $component = new Component();
            $component->device_id = $request->device_id;
            $component->hardware_id = $request->hardware_id;
            $component->user_id =  Auth::user()->user_id;
            $component->trademark = $request->trademark; 
            $component->features = $request->features; 
            $component->original = ($request->original == 'on' ? 1 : 0); 
            $component->acquired = $request->acquired; 
            $component->date_of_expiry = $request->date_of_expiry; 
            $component->amount = $request->amount; 
            $component->save();
            return response()->noContent(201);
           } 
           catch(Exception $e)
           {
            return response()->noContent(500);
           }   
    }

    public function update(Request $request)
    {
        $component = Component::find($request->component_id);
        $component->device_id = $request->device_id;
        $component->hardware_id = $request->hardware_id;
        $component->user_id =  Auth::user()->user_id;
        $component->trademark = $request->trademark; 
        $component->features = $request->features; 
        $component->original = ($request->original == 'on' ? 1 : 0); 
        $component->acquired = $request->acquired; 
        $component->date_of_expiry = $request->date_of_expiry; 
        $component->amount = $request->amount; 
        $component->save();
            return redirect()->route('devices.index', [$request->customer_id]);
    }

    public function hw()
    {
        $hw = DB::table('hardware')
            ->select('hardware_id','denomination')
            ->get();
            return response()->json($hw);
    }

 public function low($id)
    {
        $component = Component::find($id);
        $component->low = 1;
        $component->discharge_date = now();
        $component->save();
    }

    public function destroy($id)
    {
        $component = Component::find($id);
        $component->delete();
    }
}
