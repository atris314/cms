<?php

namespace App\Http\Controllers\Auth;

use App\Events\Activation;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Ghasedak\GhasedakApi;
use Grpc\CallCredentials;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

//    public function login(Request $request)
//    {
//        $this->validate($request, [
////            'mobile' => 'required|regex:/[0-9]{11}/|digits:11',
////            recaptchaFieldName() => recaptchaRuleName(),
////            'arcaptcha-token' => 'arcaptcha',
//        ]);
//
//
////        $user = User::where('mobile', $request->mobile)->first();
////        // Check Condition Mobile No. Found or Not
////
////        if(empty($user->mobile)) {
////            $msg='دقت کنید! شماره موبایل وارد شده، در سیستم ذخیره نشده است!';
////            return redirect()->back()->with('danger',$msg);
////        }
////
////            try{
////                $random = rand(1000 , 2000);
////                $user->checkid = $random;
////                $user->save();
////                $receptor = $request->mobile;
////                $type = 1;
////                $template = "activeCode";
//////                $param1 = $user->name;
////                $param1 = $user->checkid;
////                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
////                $api->Verify($receptor, $type, $template, $param1);
////            }
////            catch(\Ghasedak\Exceptions\ApiException $e){
////                echo $e->errorMessage();
////            }
////            catch(\Ghasedak\Exceptions\HttpException $e){
////                echo $e->errorMessage();
////            }
////        \Auth::login($user);
//        return redirect()->route('home');
//
//    }

    public function attemptLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember?true:false)) {
//        if (Auth::attempt(['mobile' => $request->mobile,'password' => null,'email'=>null], $request->remember?true:false)) {
            // if successful, then redirect to their intended location
//            event(new Registered($user = $this->create($request->all())));
//            event(new Activation($user));
//            return redirect()->intended(route('checkMobileUser'));
            return redirect()->intended(route('home'));
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

//    public function loginPhone()
//    {
//        return view('front.auth.login');
//    }
//
//    public function doLoginPhone(Request $request)
//    {
//
//        $this->validate($request, [
//            'mobile' => 'digits:11',
//            recaptchaFieldName() => recaptchaRuleName(),
//        ]);
//        $user = User::where('mobile', $request->input('mobile'))->first();
////        dd($user->mobile);
////        $rememberMe = (!empty($request->remember_me)) ? TRUE : FALSE;
//        if ($user->mobile){
//            try{
//                $receptor = $user->mobile;
//                $type = 1;
//                $template = "activeCode";
////                $param1 = $user->name;
//                $param1 = $user->checkid;
//                $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                $api->Verify($receptor, $type, $template, $param1);
//            }
//            catch(\Ghasedak\Exceptions\ApiException $e){
//                echo $e->errorMessage();
//            }
//            catch(\Ghasedak\Exceptions\HttpException $e){
//                echo $e->errorMessage();
//            }
//        }
//        return redirect()->route('LogincheckMobileUser');
//    }

}
