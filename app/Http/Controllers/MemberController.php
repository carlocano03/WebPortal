<?php

namespace App\Http\Controllers;

use App\Member;
use App\User;
use App\ContributionTransaction;
use App\LoanTransaction;
use Auth;
use DB;
use PDF;
use Hash;
use Illuminate\Http\Request;

class MemberController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member= User::where('users.id',Auth::user()->id)
        ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
        ->leftjoin('member','users.id','=','member.user_id')
        ->leftjoin('campus','member.campus_id','=','campus.id')
        ->first();


        $recentcontributions=ContributionTransaction::select('*')   
        ->leftjoin('contribution','contribution_transaction.contribution_id', 'contribution.id')
        ->leftjoin('contribution_account','contribution_transaction.account_id', 'contribution_account.id')
        ->where('contribution.member_id','=',$member->member_id)
        ->Where('contribution_transaction.amount','<>',0.00)
        ->orderBy('contribution.date','desc')
        ->limit(3)
        ->get();

        $contributions=array();

        $membercontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
        ->where('contribution_transaction.account_id','=',2)
        ->where('contribution.member_id','=',$member->member_id)
        ->first();
        $contributions['membercontribution']=$membercontribution->total;


        $upcontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
        ->where('contribution_transaction.account_id','=',1)
        ->where('contribution.member_id','=',$member->member_id)
        ->first();
        $contributions['upcontribution']=$upcontribution->total;


        $eupcontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
        ->where('contribution_transaction.account_id','=',3)
        ->where('contribution.member_id','=',$member->member_id)
        ->first();
        $contributions['eupcontribution']=$eupcontribution->total;
        

        $emcontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
        ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
        ->where('contribution_transaction.account_id','=',4)
        ->where('contribution.member_id','=',$member->member_id)
        ->first();
        $contributions['emcontribution']=$emcontribution->total;


        $totalcontributions = array_sum($contributions);



        $recentloans=LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount','loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date and lt.id <= loan_transaction.id order by date desc, loan_transaction.id desc) as balance'))
        ->leftjoin('loan','loan_transaction.loan_id','loan.id')
        ->leftjoin('member','loan.member_id','member.id')
        ->leftjoin('loan_type','loan.type_id','loan_type.id')
        ->where('loan.member_id','=',$member->member_id)
        ->Where('loan_transaction.amount','<>',0.00)
        ->orderBy('date','desc')
        ->orderBy('loan_transaction.id','desc')
        ->limit(3)
        ->get();


        $outstandingloans=LoanTransaction::select('loan_type.name as type',DB::raw('SUM(amount) as balance'))
        ->leftjoin('loan','loan_transaction.loan_id','loan.id')
        ->leftjoin('loan_type','loan.type_id','loan_type.id')
        ->where('loan.member_id','=',$member->member_id)
        ->groupBy('loan_type.name')
        ->get();

        $totalloanbalance =0 ;
        foreach ($outstandingloans as $loan) {
          $totalloanbalance += $loan->balance;
      }




      // dd($recentloans);
      return view('member.dashboard',array('member'=>$member, 'recentcontributions'=>$recentcontributions,'recentloans'=>$recentloans,'contributions'=>$contributions,'totalcontributions'=> $totalcontributions, 'outstandingloans'=>$outstandingloans,'totalloanbalance'=>$totalloanbalance));
  }

  public function equity()
  {
    $member= User::where('users.id',Auth::user()->id)
    ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
    ->leftjoin('member','users.id','=','member.user_id')
    ->leftjoin('campus','member.campus_id','=','campus.id')
    ->first();

    $equity=ContributionTransaction::select('contribution_transaction.id as id', 'date', 'account_id', 'contribution_id', 'reference_no', 'amount','contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date  and ct.id <= contribution_transaction.id order by date desc, contribution_transaction.id desc) as balance'))
    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    ->leftjoin('member','contribution.member_id','member.id')
    ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
    ->where('contribution.member_id','=',$member->member_id)
    ->Where('contribution_transaction.amount','<>',0.00)
    ->orderBy('date','desc')
    ->orderBy('contribution_transaction.id','desc')
    ->paginate(10); 

        // dd($equity);
    return view('member.equity',array('equity'=>$equity));

}

public function loans()
{
    $member= User::where('users.id',Auth::user()->id)
    ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
    ->leftjoin('member','users.id','=','member.user_id')
    ->leftjoin('campus','member.campus_id','=','campus.id')
    ->first();

    $loans=LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount','loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date and lt.id <= loan_transaction.id order by date desc, loan_transaction.id desc) as balance'))
    ->leftjoin('loan','loan_transaction.loan_id','loan.id')
    ->leftjoin('member','loan.member_id','member.id')
    ->leftjoin('loan_type','loan.type_id','loan_type.id')
    ->where('loan.member_id','=',$member->member_id)
    ->Where('loan_transaction.amount','<>',0.00)
    ->orderBy('loan.type_id', 'ASC')
    ->orderBy('date','desc')
    ->orderBy('loan_transaction.id','desc')
    ->paginate(10); 

        // dd($loans);
    return view('member.loans',array('loans'=>$loans));

}

public function generatesoa()
{
    $member= User::where('users.id',Auth::user()->id)
    ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
    ->leftjoin('member','users.id','=','member.user_id')
    ->leftjoin('campus','member.campus_id','=','campus.id')
    ->first();

    $contributions=array();

    $membercontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    ->where('contribution_transaction.account_id','=',2)
    ->where('contribution.member_id','=',$member->member_id)
    ->first();
    $contributions['membercontribution']=$membercontribution->total;


    $upcontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    ->where('contribution_transaction.account_id','=',1)
    ->where('contribution.member_id','=',$member->member_id)
    ->first();
    $contributions['upcontribution']=$upcontribution->total;


    $eupcontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    ->where('contribution_transaction.account_id','=',3)
    ->where('contribution.member_id','=',$member->member_id)
    ->first();
    $contributions['eupcontribution']=$eupcontribution->total;


    $emcontribution=ContributionTransaction::select(DB::raw('SUM(contribution_transaction.amount) as total'))
    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    ->where('contribution_transaction.account_id','=',4)
    ->where('contribution.member_id','=',$member->member_id)
    ->first();
    $contributions['emcontribution']=$emcontribution->total;


    $totalcontributions = array_sum($contributions);



    $outstandingloans=LoanTransaction::select('loan_type.name as type',DB::raw('SUM(amount) as balance'))
    ->leftjoin('loan','loan_transaction.loan_id','loan.id')
    ->leftjoin('loan_type','loan.type_id','loan_type.id')
    ->where('loan.member_id','=',$member->member_id)
    ->groupBy('loan_type.name')
    ->get();

    $totalloanbalance =0 ;
    foreach ($outstandingloans as $loan) {
      $totalloanbalance += $loan->balance;
  }

  $data['totalloanbalance']=$totalloanbalance;
  $data['outstandingloans']=$outstandingloans;
  $data['totalcontributions']=$totalcontributions;
  $data['emcontribution']=$emcontribution->total;
  $data['eupcontribution']=$eupcontribution->total;
  $data['upcontribution']=$upcontribution->total;
  $data['membercontribution']=$membercontribution->total;
  $data['member']=$member;



  $pdf = PDF::loadView('pdf.soa', $data);
  return $pdf->stream('soa.pdf');

}

public function generateequity()
{
    $member= User::where('users.id',Auth::user()->id)
    ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
    ->leftjoin('member','users.id','=','member.user_id')
    ->leftjoin('campus','member.campus_id','=','campus.id')
    ->first();

    $equity=ContributionTransaction::select('contribution_transaction.id as id', 'date', 'account_id', 'contribution_id', 'reference_no', 'amount','contribution_account.name', DB::raw('(select SUM(amount) from contribution_transaction as ct left join contribution as c on ct.contribution_id = c.id where c.member_id=contribution.member_id and c.date<=contribution.date and ct.id <= contribution_transaction.id order by date desc, contribution_transaction.id desc) as balance'))
    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
    ->leftjoin('member','contribution.member_id','member.id')
    ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
    ->where('contribution.member_id','=',$member->member_id)
    ->Where('contribution_transaction.amount','<>',0.00)
    ->orderBy('date','desc')
    ->orderBy('contribution_transaction.id','desc')
    ->get();


    $data['equity']=$equity;
    $data['member']=$member;



    $pdf = PDF::loadView('pdf.equity', $data);
    return $pdf->setPaper('a4', 'landscape')->stream('eqity.pdf');

}

public function generateloans()
{
 $member= User::where('users.id',Auth::user()->id)
 ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
 ->leftjoin('member','users.id','=','member.user_id')
 ->leftjoin('campus','member.campus_id','=','campus.id')
 ->first();

 $loans=LoanTransaction::select('loan_transaction.id as id', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount','loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date and lt.id <= loan_transaction.id order by date desc, loan_transaction.id desc) as balance'))
 ->leftjoin('loan','loan_transaction.loan_id','loan.id')
 ->leftjoin('member','loan.member_id','member.id')
 ->leftjoin('loan_type','loan.type_id','loan_type.id')
 ->where('loan.member_id','=',$member->member_id)
 ->Where('loan_transaction.amount','<>',0.00)
 ->orderBy('loan.type_id', 'ASC')
 ->orderBy('date','desc')
 ->orderBy('loan_transaction.id','desc')
 ->get(); 


 $data['loans']=$loans;
 $data['member']=$member;



 $pdf = PDF::loadView('pdf.loans', $data);
 return $pdf->setPaper('a4', 'landscape')->stream('loan.pdf');

}

public function updatepw()
{
 $member= User::where('users.id',Auth::user()->id)
 ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
 ->leftjoin('member','users.id','=','member.user_id')
 ->leftjoin('campus','member.campus_id','=','campus.id')
 ->first();



 return view('member.updatepassword');
}

public function savepw(Request $request)
{
 $member= User::where('users.id',Auth::user()->id)
 ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
 ->leftjoin('member','users.id','=','member.user_id')
 ->leftjoin('campus','member.campus_id','=','campus.id')
 ->first();


$newpass=$request->password;
 $confirm=Hash::check($request->currentPassword, $member->password);
 if($confirm)
 {
    $user = User::find(Auth::user()->id);
    $user->update([
        'password' => Hash::make($newpass)
    ]);
    return redirect('/member/update-password')
    ->with('success', 'Password successfully updated.');
}
else
{
  return redirect('/member/update-password')
  ->with('error', 'The current password you entered is incorrect.');
}

}

public function onboarding()
{
   $member= User::where('users.id',Auth::user()->id)
   ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
   ->leftjoin('member','users.id','=','member.user_id')
   ->leftjoin('campus','member.campus_id','=','campus.id')
   ->first();

   

   return view('member.onboarding');
}

public function saveonboarding(Request $request)
{
 
 if($request->password==$request->confirmPassword)
 {
    $user = User::find(Auth::user()->id);
    $user->update([
        'password' => Hash::make($request->password),
        'password_set' => 1
    ]);
    return redirect('/member/dashboard');
    
 }
 else
 {
   return redirect('/member/onboarding')
  ->with('error', 'Passwords do not match!');
 }


}




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Member $member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        //
    }
}
