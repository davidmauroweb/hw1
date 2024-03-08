<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receiver;

class VisitController extends Controller
{
    public function visit($token, $t) {
        if(csrf_token() == $token)
        {
        $receiver = Receiver::where('token', '=', $t)->firstOrFail();
        $receiver->checked = 1;
        $receiver->save();   
        return view('mailing.destination', ['name' => $receiver->name, 'email' => $receiver->email]);
        }
       
    }
}
