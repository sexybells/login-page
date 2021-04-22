<?php

namespace App\Http\Controllers;

use App\Models\Register;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function index() {
        $res = Register::all();
        dd($res);
    }
    public function login(Request $request) {
        if ($request->check == 'email') {
            $res = Register::where('email' ,'=', $request->email)->where('password','=', $request->password);
            if ($res === true){
                return response()->json(['msg'=>'Đăng nhập thành công'],200);
            } else {
                return response()->json(['msg' => 'Đăng nhập thất bại'],500);
            }
        } else if ($request->check == 'phone') {
            $res = Register::where('phone_number' ,'=', $request->phone_number)->where('password','=', $request->password);
            if ($res === true){
                return response()->json(['msg'=>'Đăng nhập thành công'],200);
            } else {
                return response()->json(['msg' => 'Đăng nhập thất bại'],500);
            }
        } else {
            return response()->json(['msg' => 'Đăng nhập thất bại'],500);
        }

    }
    public function register(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email'=> 'required|email|unique:email',
            'phone_number' => 'required|numeric|unique:phone_number',
            'password' => 'required'
        ],
        [
            'name.required' => 'Tên không được bỏ trống',
            'email.required' => 'Email không được bỏ trống',
            'email.email' => 'Email chưa đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'phone_number.required' => 'Số điện thoại không được bỏ trống',
            'phone_number.numeric' => 'Đây phải là số',
            'phone_number.unique' => 'Số này đã tồn tại',
            'password.required' => 'Mật khẩu không được bỏ trống'
        ]);
//        $confirm = $this->confirm($request->email);
//        if ($confirm == TRUE) {
            $res = new Register();
            $res->name = $request->name;
            $res->phone_number = $request->phone_number;
            $res->email = $request->email;
            $res->password = $request->password;
            $res->save();
            $res = Register::all();
            return response()->json(['data'=>$res,'mgs'=>'Đăng ký thành công'],'200');
//        } else {
//            return response()->json(['mgs'=>'Đăng ký thành công'],'200');
//        }
    }
    public function forgetPassword(Request $request) {
        $res = Register::where('email','=',$request->email);
        if ($res === true) {

        }
    }
}
