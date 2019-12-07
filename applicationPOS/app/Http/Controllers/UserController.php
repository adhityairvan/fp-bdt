<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Middleware\OwnerOnly;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(OwnerOnly::class);
    }

    public function index(){
        $users = User::withCount('inChargeOf')->get();
        return view('userIndex')->with('users', $users);
    }

    public function delete(Request $request){
        $user = User::find($request['user_id']);
        $user->delete();
        return redirect('/user');
    }

    public function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|',
            'email' => 'required|string|unique:users|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        return redirect('/user');
    }
}
