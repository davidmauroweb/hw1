<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User, Customer};
use Illuminate\Support\Facades\{DB, Auth, Hash};

class UserController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
       $this->middleware('check.role');
    }

    public function index()
    {

        $users = DB::table('users')
                        ->paginate(5);
        return view('auth.list', ['users' => $users]);
    }

    public function store(Request $request)
    {
       $request->validate([
             'username' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
             'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
       $user = new User(); 
        $user->username = $request->username; 
        $user->email = $request->email;
        $user->is_admin = $request->is_admin;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario creado satisfactoriamente');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado del sistema');
    }

    public function password(Request $request)
    {/*
        if($request->password==$request->repeat_password){
          $user = User::find($request->user_password);
          $user->password = Hash::make($request->password);
          $user->save();
          $msj_type="success";
          $txt="¡Se estableció la contraseña para el usuario!";
        }else{
            $msj_type="error";
            $txt="No coinciden las claves";
        }
          return redirect()->route('users.index')->with($msj_type, $txt);
    */
    echo $request->password;
    echo "<br>";
    echo Hash::make($request->password);
    echo "<br>";
    echo $request->user_password;
          
    }
}
