<?php

namespace App\Http\Controllers\Auth;

use App\Events\Activation;
use App\Http\Controllers\Controller;
use App\Models\Idcode;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Ghasedak\GhasedakApi;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/check/mobile-user';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
//        dd($data);
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required','digits:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
//            'recaptchaFieldName()' => 'recaptchaRuleName()',
//            'arcaptcha-token' => 'arcaptcha',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $email = $data['email'];
        $subste = explode("@", $email);
        $item = $subste[0];
        $username = $item.rand(100 , 2000);
        $code = '#IRCH'.rand(1000,90000);
        $random = rand(1000 , 2000);
        $idcodesget = Idcode::where('idcode',$data['idcodes'])->pluck('numbercoin','id')->first();

        $createTime= Carbon::parse(now()->addMinutes(120));
        return User::create([
            'username' => $username,
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $email,
            'mobile' =>$data['mobile'],
//            'jobs' => $data['jobs'],
            'password' => Hash::make($data['password']),
            'code'=> $code,
            'status'=> 1,
//            'checkid' => $random,
            'rate' => 10,
            'idcodes' => $data['idcodes'],
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        event(new Activation($user));

        $this->guard()->login($user);



        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());
    }

    public function showRegistrationForm()
    {
        return view('front.auth.register');
    }
}
