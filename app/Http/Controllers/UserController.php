<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function __construct()  //bagi page tak error, bila masuk, kene login dulu
    {
        $this->middleware('auth');
    }
    
    public function index()
    { $users = User::all();
    return view('users.index', compact('users'));}
    //

    public function create()
    { 
    return view('users.create');}

    public function store(Request $request)
    { 
        //POPO - Plain Old PHP
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
       
        
        $user->save();

    return redirect()->route('users.index');
    }

    public function show(User $user)
    { 
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    { 
        return view('users.edit', compact('user'));
    }


        public function update(Request $request, User $user)
    { 
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        
        $user->save();

    return redirect()->route('users.index');
   } 

   public function delete(User $user)
    { 
        
        $user->delete();

    return redirect()->route('users.index');
   }

}
