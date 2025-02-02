<?php

namespace App\Http\Controllers;

use App\Models\{Message, Template};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};
use Exception;

class MessageController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('check.role');
    }

    public function index()
    {
        $messages = DB::table('users')
        ->join('messages', 'messages.user_id', 'users.user_id')
        ->select('messages.message_id', 'users.username', 'messages.subject', 'messages.title', 'messages.sender')
        ->paginate(10);
        return view('mailing.list', ['messages' => $messages]);
    }

    
    public function create($id = 0)
    {
    $message='';
    $templates = Template::all('template_id', 'name')->sortBy('name');
    
    if($id > 0) {
        $message = Message::find($id);
    }
        return view('mailing.message', ['message' => $message, 'templates' => $templates]);
    }


    public function image($filename)
    {
      $path = storage_path("app/files/{$filename}");
      return response()->file($path);
    }
    
    public function store(Request $request)
    {
        try {

            if($request->message_id == 0) {
                $message = new Message();
                $legend = "¡Se registró el mensaje de forma correcta!";
            }
                else {
                $message = Message::find($request->message_id);
                $legend =  "¡Se actualizó el mensaje de forma correcta!";
             }
             
             $message->user_id = Auth::user()->user_id;
             $message->template_id = $request->template;
             $message->subject = $request->subject;
             $message->title = $request->title;
             $message->header = $request->header;
             $message->body = $request->body;
             $message->footer = $request->footer;
             
             if(isset($request->logo)) {
                $path = $request->file('logo')->store('');
                $message->logo = $path;
            }
             $message->button = $request->button;
             $message->sender = $request->sender;
             $message->save();
             $result = "success";
            }
            catch (Exception $e) {
                $result = "error";
                $legend = "¡Surgió un error, verifique que los datos sean correctos!";
            }
            return redirect()->route('messages.index')->with($result, $legend);
    }    
}
