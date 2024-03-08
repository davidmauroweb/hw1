<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Receiver;
use App\Mail\Mailing;
use App\Models\Message;
use Illuminate\Support\Facades\{DB, Mail};
use Exception;
use Dirape\Token\Token;

class ReceiverController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('check.role');
    }

    public function state($id)
    {
        $states = Receiver::select('email', 'name', DB::RAW("DATE_FORMAT(created_at, '%Y-%m-%d') created"), 'checked', 'message_id')->where('message_id', $id)->get();
        return response()->json($states);
    }

    
    public function store(Request $request)
    {
    try {
        $message = Message::select('messages.*, templates.filename')->join('templates', 'templates.template_id', '=', 'messages.template_id');
        $message = DB::table('templates')
        ->join('messages', 'messages.template_id', 'templates.template_id')
        ->select('templates.filename', 'messages.subject', 'messages.title', 'messages.header', 'messages.body', 'messages.footer', 'messages.button', 'messages.sender')
        ->where('messages.message_id', '=', $request->message_id)
        ->first();
        
        $email = new \stdClass();
        $email->template = $message->filename;
        $email->subject = $message->subject;
        $email->title = $message->title;
        $email->header = $message->header;
        $email->body = $message->body;
        $email->footer = $message->footer;
        $email->button = $message->button;
        $email->sender = $message->sender;
        $email->email = $request->email;
        $email->name = $request->name;

        $token = new Token;
        $receiver = new Receiver();
        $receiver->message_id = $request->message_id;
        $receiver->email = $request->email;
        $receiver->name = $request->name;
        $receiver->token = $token->RandomString(100);    
        $receiver->save();

        $email->token = $receiver->token;
 
        Mail::to($request->email)->send(new Mailing($email));
        return response()->noContent(201);
        } 
    catch(Exception $e)
        {
        return response()->noContent(500);
        }   
    }
}
