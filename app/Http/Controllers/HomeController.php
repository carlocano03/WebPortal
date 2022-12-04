<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(getUserdetails()->usertype == 'member')
        {
            return redirect('/member/dashboard');
        }
        else
        {
            return redirect('/admin/dashboard');
        }
        // return view('home');
    }
     public function fetchposition()
    {

       $members=DB::table('member')->get();

       foreach ($members as $value) {
           // dd($value->position_id);
           $id=$value->id;
           $position=DB::table('position')->where('id','=',$value->position_id)->first();
           DB::table('member')
            ->where('id', $id)
            ->update(['position_id' => $position->name]);

       }

       echo "update done";
    }
}
