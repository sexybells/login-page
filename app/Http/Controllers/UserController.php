<?php


namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile()
    {
        if (Auth::user()) {
            return response()->json(['user' => Auth::user()], 200);
        } else {
            return response()->json(['msg' => "information incorrect"], 200);
        }

    }
    public function allUsers()
    {
        return response()->json(['users' =>  User::all()], 200);
    }

    public function singleUser($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }

    }
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
//        dd($request->token);
    }
}
