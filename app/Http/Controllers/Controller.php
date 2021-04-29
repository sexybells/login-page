<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index() {
        $res = Register::all();
        dd($res);
    }
    public function user($id) {
        $res = Register::find($id);
        return response()->json(['data'=>$res],200);
    }
//    public function login(Request $request) {
//        if ($request->check = 'email') {
//            $res = Register::where('email', $request->username)->where('password', $request->password);
//            if ($res->exists() == true){
//                $res = Register::where('email',$request->username)->get();
//                return response()->json(['data'=>$res,'msg'=>'Đăng nhập thành công'],200);
//            } else {
//                return response()->json(['msg' => 'Đăng nhập thất bại'],200);
//            }
//        }
//        if ($request->check = 'phone') {
//            $res = Register::where('phone_number' ,'=', $request->username)->where('password','=', $request->password);
//            if ($res->exists() == true){
//                return response()->json(['msg'=>'Đăng nhập thành công'],200);
//            } else {
//                return response()->json(['msg' => 'Đăng nhập thất bại'],200);
//            }
//        } else {
//            return response()->json(['msg' => 'Đăng nhập thất bại'],200);
//        }
//    }
//    public function register(Request $request) {
//        $this->validate($request, [
//            'name' => 'required',
//            'email'=> 'required|email|unique:email',
//            'phone_number' => 'required|numeric|unique:phone_number',
//            'password' => 'required'
//        ],
//        [
//            'name.required' => 'Tên không được bỏ trống',
//            'email.required' => 'Email không được bỏ trống',
//            'email.email' => 'Email chưa đúng định dạng',
//            'email.unique' => 'Email đã tồn tại',
//            'phone_number.required' => 'Số điện thoại không được bỏ trống',
//            'phone_number.numeric' => 'Đây phải là số',
//            'phone_number.unique' => 'Số này đã tồn tại',
//            'password.required' => 'Mật khẩu không được bỏ trống'
//        ]);
////        $confirm = $this->confirm($request->email);
////        if ($confirm == TRUE) {
//            $res = new Register();
//            $res->name = $request->name;
//            $res->phone_number = $request->phone_number;
//            $res->email = $request->email;
//            $res->password = $request->password;
//            $res->save();
//            $res = Register::all();
//            return response()->json(['data'=>$res,'msg'=>'Đăng ký thành công'],'200');
////        } else {
////            return response()->json(['mgs'=>'Đăng ký thành công'],'200');
////        }
//    }
    public function forgetPassword(Request $request) {
        $res = User::where('email','=',$request->email);
        if ($res == true) {
            $res = Register::where('email',$request->email)->first();
            $url = 'http://localhost:3000/recovery/';
            $data = array('email'=> $request->email,'url'=>$url);
            Mail::send('email',$data, function($message) use ($data){
                $message->to($data['email'],'Duong')->subject('Wl');
            });
            return response()->json(['data'=>$res,'msg'=>'Da gui thanh cong'],200);
        } else {
            return response()->json(['msg'=>'Email khong ton tai'],200);
        }
    }
    public function recovery(Request $request){
        $res = User::find($request->id);
        $res->password = $request->password;
        $res->save();
        $res = Register::all();
        return response(['data'=>$res,'msg'=>'Thay doi mat khau thanh cong'],200);
    }
//    public function login() {
//
//    }
    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
    public function delete($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['msg' => 'Deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }
}
