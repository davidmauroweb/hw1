<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\{Auth, DB};

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->is_admin == 1 ) {
            return $next($request);
        }
        $customer = DB::table('customers')
           ->select(DB::raw("CONCAT(customers.customer_id, '||||PC-ASSI.2023#||||', customers.business_name) as customer_x, customers.business_name"))
           ->where('customers.user_id', Auth::user()->user_id)
           ->orderBy('business_name')
           ->where('customers.enabled', 1)
           ->take(1)
           ->get();
           return redirect()->intended('dashboard/'.base64_encode($customer[0]->customer_x));
    }
}
