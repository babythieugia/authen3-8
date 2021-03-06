<?php

namespace App\Http\Controllers\Auth\Shipper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest:shipper')->except('logout');

    }
    /*
     * Phương thức này để trả về view dùng để đăng nhập cho phấn shipper
     * */
    public function login(){
        return view('shipper.auth.login');
    }
    /*
     * Phương thức này dùng để đăng nhập cho shipper
     * lấy thông tin từ form có METHOD là POST
     * */
    public function loginShipper(Request $requets){
        //validate dữ liệu đăng nhập
        $this->validate($requets, array(
            'email'=>'required|email',
            'password'=>'required|min:6',
            //Đăng nhập
        ));
        if(Auth::guard('shipper')->attempt(
            ['email'=> $requets->email,'password'=>$requets->password],$requets->remember
        )){
            //nếu đăng nhập thành công thì sẽ chuyển hướng về view dashboard của admin
            return redirect()->intended(route('shipper.dashboard'));
        }
        //nếu đăng nhập thất bại thì quay trở về form đăng nhập
        //với 2 gía trị của ô input cũ là email và remmember
        return redirect()->back()->withInput($requets->only('email', 'remember'));
    }
    /*
    * Phương thức này dùng để đăng xuất
    * */
    public function logout(){
        Auth::guard('shipper')->logout();

        //chuyển hướng về trang login
        return redirect()->route('shipper.auth.login');
    }
}
