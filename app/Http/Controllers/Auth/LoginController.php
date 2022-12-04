<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;


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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        // dd($request->all());
        $credentials = $this->credentials($request);
        if($request->usertype == 'member')
        {
            $member = \App\Member::where('member_No', $request->memberNo)
            ->leftJoin('users', 'member.user_id', '=', 'users.id')
            ->first();
           if(count($member)>=1)
           {
            $credentials[$this->username()]=$member->email;
           }
           else
           {
            return redirect('login')->with([ 'error' => 'The member ID is incorrect.', 'user' => $request->memberNo]);
           }

        }
        
        // dd(Hash::check('password', '$2y$10$VwPM1QkbBZdilwHXS5md/OOvvVxa89UHmQZPFaJWvqmw3TfvqC15C'));
        if(Auth::attempt($credentials)) {
            

              if($request->usertype == 'admin')
            {
                $user=\App\User::find(Auth::user()->id);
              if($user->password_set==0)
              {
                 return redirect('/admin/onboarding');
              }
              else
              {
               return redirect('/admin/dashboard');
              }

            }
            else
            {
              $user=\App\User::find(Auth::user()->id);
              if($user->password_set==0)
              {
                 return redirect('/member/onboarding');
              }
              else
              {
               return redirect('/member/dashboard');
              }
            }
       
         
        }
        else{
            $url='';
            $error='';
            if($request->usertype == 'admin')
            {
                $url='admin';
                $error='The email or password you entered is incorrect.';
                $user= $request->email;

            }
            else
            {
                $url='login';
                $error='The member ID or password you entered is incorrect.';
                $user=$request->memberNo;
            }

             return redirect($url)->with([ 'error' => $error, 'user' => $user]);

         

        }
    }
}
