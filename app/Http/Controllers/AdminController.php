<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use App\Campus;
use App\Member;
use App\Tempass;
use App\LoanTransaction;
use App\ContributionTransaction;
use Auth;
use Hash;
use DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class AdminController extends Controller
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
//       $activecampus=array();
//       if(isset($_GET['campus_id']))
//       {
//         $activecampus=Campus::select('*')
//         ->where('id','=',$_GET['campus_id'])
//         ->first();
//       }


//       $campusmembers=array();
//       if(getUserdetails()->role=="SUPER_ADMIN")
//       {
//         $campuses=Campus::all();
//         $campusmembers=DB::table('member')
//         ->select('campus.name',DB::raw('COUNT(*) as count'))
//         ->leftjoin('campus','member.campus_id','campus.id')
//         ->groupBy('campus_id')
//         ->get();            
//       }
//       else
//       {
//        $campuses=Campus::select('*')
//        ->where('cluster_id','=',getUserdetails()->cluster_id)
//        ->get(); 
//      }


    //  $contributions=ContributionTransaction::selectRaw('contribution_transaction.account_id, contribution_account.name, SUM(amount) as amount')
    //  ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
    //  ->groupBy('contribution_transaction.account_id')
    //  ->get();

// //members
//      if(getUserdetails()->role=="SUPER_ADMIN")
//      {
//       if(isset($_GET['campus_id']))
//       {
//         $members=Member::where('campus_id',$_GET['campus_id'])->get();
//         $memberscount=count($members);
//       }
//       else
//       {
//        $memberscount=count(Member::all());
//      }
//    }
//    else
//    {
//     if(isset($_GET['campus_id']))
//     {
//       $members=Member::where('campus_id',$_GET['campus_id'])->get();
//       $memberscount=count($members);
//     }
//     else
//     {
//      $members=Member::where('campus_id',$campuses[0]->id)->get();
//      $memberscount=count($members);
//    }
//  }

// //loans
//  if(getUserdetails()->role=="SUPER_ADMIN")
//  {

//    if(isset($_GET['campus_id']))
//    {
//     $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
//     ->leftjoin('member','loan.member_id','member.id')
//     ->where('member.campus_id',$_GET['campus_id'])
//     ->sum('amount');
//   }
//   else
//   {
//     $totalloansgranted=LoanTransaction::sum('amount');
//   }
// }
// else
// {
//   if(isset($_GET['campus_id']))
//   {
//     $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
//     ->leftjoin('member','loan.member_id','member.id')
//     ->where('member.campus_id',$_GET['campus_id'])
//     ->sum('amount');
//   }
//   else
//   {
//     $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
//     ->leftjoin('member','loan.member_id','member.id')
//     ->where('member.campus_id',$campuses[0]->id)
//     ->sum('amount');
//   }
// }

// //contributions
// if(getUserdetails()->role=="SUPER_ADMIN")
// {

//  if(isset($_GET['campus_id']))
//  {
//   $contributions=ContributionTransaction::selectRaw('contribution_transaction.account_id, contribution_account.name, SUM(amount) as amount')
//   ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
//   ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
//   ->leftjoin('member','contribution.member_id','member.id')
//   ->where('member.campus_id',$_GET['campus_id'])
//   ->groupBy('contribution_transaction.account_id')
//   ->get();
// }
// else
// {
//  $contributions=ContributionTransaction::selectRaw('contribution_transaction.account_id, contribution_account.name, SUM(amount) as amount')
//  ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
//  ->groupBy('contribution_transaction.account_id')
//  ->get();
// }
// }
// else
// {
//   if(isset($_GET['campus_id']))
//   {
//    $contributions=ContributionTransaction::selectRaw('contribution_transaction.account_id, contribution_account.name, SUM(amount) as amount')
//    ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
//    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
//    ->leftjoin('member','contribution.member_id','member.id')
//    ->where('member.campus_id',$_GET['campus_id'])
//    ->groupBy('contribution_transaction.account_id')
//    ->get();
//  }
//  else
//  {
//    $contributions=ContributionTransaction::selectRaw('contribution_transaction.account_id, contribution_account.name, SUM(amount) as amount')
//    ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
//    ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
//    ->leftjoin('member','contribution.member_id','member.id')
//    ->where('member.campus_id',$campuses[0]->id)
//    ->groupBy('contribution_transaction.account_id')
//    ->get();
//  }
// }


// $totalequity=0;
// foreach ($contributions as $contri) {
//  $totalequity += $contri->amount;
// }
// // dd($totalequity);

 
$campusmembers=array();
$campusmembers=DB::table('member')
        ->select('campus.name',DB::raw('COUNT(*) as count'))
        ->join('campus','member.campus_id','campus.id')
        ->groupBy('campus_id')
        ->orderBy(\DB::raw('count(campus.id)'), 'DESC')
        ->get();
$campuses=Campus::all();

$data = array(
  'campusmembers' => $campusmembers,
  'campuses' => $campuses
);

  // return view('admin.dashboard')->with('campusmembers', $campusmembers)->with('campuses', $campuses);
  return view('admin.dashboard')->with($data);
}

//Eto na yung bago
public function getTotal()
{
    $upcontri=DB::table('contribution_transaction')->select('amount')
    ->where('account_id', '1') 
    ->sum('amount');

    $membercontri=DB::table('contribution_transaction')->select('amount')
    ->where('account_id', '2')
    ->sum('amount');

    $earningsUP=DB::table('contribution_transaction')->select('amount')
    ->where('account_id', '3')
    ->sum('amount');

    $earningsMember=DB::table('contribution_transaction')->select('amount')
    ->where('account_id', '4')
    ->sum('amount');

    $memberscount=count(Member::all());
    
    
    $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
        ->leftjoin('member','loan.member_id','member.id')
        ->sum('amount');


    $data = array(
      'total' => number_format($upcontri,2),
      'membercontri' => number_format($membercontri,2),
      'earningsUP' => number_format($earningsUP,2),
      'earningsMember' => number_format($earningsMember,2),
      'totalMember' => number_format($memberscount),
      'totalloansgranted' => number_format($totalloansgranted),
    );

  echo json_encode($data);
}

public function getTotal_campuses()
{
    
    // $upcontri=DB::table('contribution_transaction')
    // ->where('account_id', '1') 
    // ->sum('amount');
    DB::enableQueryLog();
    
    if(isset($_GET['campuses_id']) && $_GET['campuses_id'] != "")
  {
    $upcontri=DB::table('contribution_transaction')->select('amount')
    ->join('contribution','contribution_transaction.contribution_id','contribution.id')
    ->join('member','contribution.member_id','member.id')
    ->where('member.campus_id',$_GET['campuses_id'])
    ->where('contribution_transaction.account_id', '1')
    ->groupBy('member.campus_id')
    ->groupBy('contribution_transaction.account_id')
    ->sum('contribution_transaction.amount');
 }else
 {
  $upcontri=DB::table('contribution_transaction')
    ->where('account_id', '1') 
    ->sum('amount');
 }
    // $membercontri=DB::table('contribution_transaction')
    // ->where('account_id', '2')
    // ->sum('amount');
    if(isset($_GET['campuses_id']) && $_GET['campuses_id'] != "")
    {
    $membercontri=DB::table('contribution_transaction')->select('amount')
    ->join('contribution','contribution_transaction.contribution_id','contribution.id')
    ->join('member','contribution.member_id','member.id')
    ->where('member.campus_id',$_GET['campuses_id'])
    ->where('contribution_transaction.account_id', '2')
    ->groupBy('member.campus_id')
    ->groupBy('contribution_transaction.account_id')
    ->sum('contribution_transaction.amount');
    }
    else
    {
    $membercontri=DB::table('contribution_transaction')
    ->where('account_id', '2')
    ->sum('amount');
    }
    // $earningsUP=DB::table('contribution_transaction')
    // ->where('account_id', '3')
    // ->sum('amount');
    if(isset($_GET['campuses_id']) && $_GET['campuses_id'] != "")
    {
    $earningsUP=DB::table('contribution_transaction')->select('amount')
    ->join('contribution','contribution_transaction.contribution_id','contribution.id')
    ->join('member','contribution.member_id','member.id')
    ->where('member.campus_id',$_GET['campuses_id'])
    ->where('contribution_transaction.account_id', '3')
    ->groupBy('member.campus_id')
    ->groupBy('contribution_transaction.account_id')
    ->sum('contribution_transaction.amount');
    }
    else
    {
    $earningsUP=DB::table('contribution_transaction')
    ->where('account_id', '3')
    ->sum('amount');
    }
    // $earningsMember=DB::table('contribution_transaction')
    // ->where('account_id', '4')
    // ->sum('amount');
    if(isset($_GET['campuses_id']) && $_GET['campuses_id'] != "")
    {
    $earningsMember=DB::table('contribution_transaction')->select('amount')
    ->join('contribution','contribution_transaction.contribution_id','contribution.id')
    ->join('member','contribution.member_id','member.id')
    ->where('member.campus_id',$_GET['campuses_id'])
    ->where('contribution_transaction.account_id', '4')
    ->groupBy('member.campus_id')
    ->groupBy('contribution_transaction.account_id')
    ->sum('contribution_transaction.amount');
    }
    else
    {
    $earningsMember=DB::table('contribution_transaction')
    ->where('account_id', '4')
    ->sum('amount');
    }
    if(isset($_GET['campuses_id']) && $_GET['campuses_id'] != "")
    {
  $memberscount=DB::table('member')
  ->where('member.campus_id',$_GET['campuses_id'])
  ->count();
    }
    else{
      $memberscount=DB::table('member')
      ->count();
    }

  // $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
  //     ->leftjoin('member','loan.member_id','member.id')
  //     ->sum('amount');
  if(isset($_GET['campuses_id']) && $_GET['campuses_id'] != "")
    {
   $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
      ->leftjoin('member','loan.member_id','member.id')
      ->where('member.campus_id',$_GET['campuses_id'])
      ->groupBy('member.campus_id')
      ->sum('amount');
      
    }
    else
    {
       $totalloansgranted=LoanTransaction::leftjoin('loan','loan_transaction.loan_id','loan.id')
      ->leftjoin('member','loan.member_id','member.id')
      ->sum('amount');
    }
    $query = DB::getQueryLog();
    $data = array(
      'total' => number_format($upcontri,2),
      'membercontri' => number_format($membercontri,2),
      'earningsUP' => number_format($earningsUP,2),
      'earningsMember' => number_format($earningsMember,2),
      'totalMember' => number_format($memberscount),
      'dd' => $_GET['campuses_id'],
      'totalloansgranted' => number_format($totalloansgranted),
    );

  echo json_encode($data);
}

public function tempass()
{
 if(getUserdetails()->role=="SUPER_ADMIN")
 {
  $tempass = Tempass::leftjoin('cluster','tempass.cluster','cluster.id')->get();
}
else
{
  $tempass = Tempass::leftjoin('cluster','tempass.cluster','cluster.id')->where('tempass.cluster','=',getUserdetails()->cluster_id)->get();
}

return view('admin.tempass',array('tempass'=>$tempass));
}

public function onboarding()
{
 return view('admin.onboarding');
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
    return redirect('/admin/dashboard');

  }
  else
  {
   return redirect('/admin/onboarding')
   ->with('error', 'Passwords do not match!');
 }
}


public function members()
{
 if(getUserdetails()->role=="SUPER_ADMIN")
 {

  if(isset($_GET['q']))
  {
   $members=Member::select('users.*', 'member.member_no as member_no','campus.name as campus', 'department.name as department', 'member.membership_date as memdate')
   ->leftjoin('users','member.user_id','users.id')
   ->leftjoin('campus','member.campus_id','campus.id')
   ->leftjoin('department','member.department_id','department.id')
   ->where('member_no','like','%'.$_GET['q'].'%')
   ->orWhere( DB::raw('CONCAT(users.first_name," ",users.last_name)'),'like','%'.$_GET['q'].'%')
   ->orWhere('users.first_name','like','%'.$_GET['q'].'%')
   ->orWhere('users.last_name','like','%'.$_GET['q'].'%')
   ->paginate(10); 
 }
 else
 {
   $members=Member::select('users.*', DB::raw('CONCAT(users.first_name," ",users.last_name) AS full_name'), 'member.member_no as member_no','campus.name as campus', 'department.name as department', 'member.membership_date as memdate')
   ->leftjoin('users','member.user_id','users.id')
   ->leftjoin('campus','member.campus_id','campus.id')
   ->leftjoin('department','member.department_id','department.id')
   ->paginate(10); 
 }

 

 
 
 
}
else
{
  if(isset($_GET['q']))
  {
    $members=Member::select('users.*', 'member.member_no as member_no','campus.name as campus', 'department.name as department', 'member.membership_date as memdate')
    ->leftjoin('users','member.user_id','users.id')
    ->leftjoin('campus','member.campus_id','campus.id')
    ->leftjoin('department','member.department_id','department.id')
    ->where('campus.cluster_id','=',getUserdetails()->cluster_id)
    ->where('member_no','like','%'.$_GET['q'].'%')
    ->orWhere( DB::raw('CONCAT(users.first_name," ",users.last_name)'),'like','%'.$_GET['q'].'%')
    ->orWhere('users.first_name','like','%'.$_GET['q'].'%')
    ->orWhere('users.last_name','like','%'.$_GET['q'].'%')
    ->paginate(10);
  }
  else{
   $members=Member::select('users.*', 'member.member_no as member_no','campus.name as campus', 'department.name as department', 'member.membership_date as memdate')
   ->leftjoin('users','member.user_id','users.id')
   ->leftjoin('campus','member.campus_id','campus.id')
   ->leftjoin('department','member.department_id','department.id')
   ->where('campus.cluster_id','=',getUserdetails()->cluster_id)
   ->paginate(10);
 } 
}

return view('admin.members',array('members'=>$members));
}

public function member_soa($id)
{
 $member= User::where('users.id',$id)
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
return view('admin.member_soa',array('member'=>$member, 'recentcontributions'=>$recentcontributions,'recentloans'=>$recentloans,'contributions'=>$contributions,'totalcontributions'=> $totalcontributions, 'outstandingloans'=>$outstandingloans,'totalloanbalance'=>$totalloanbalance));
return view('admin.members',array('members'=>$members));
}

public function loansmasterlist()
{
  $loans=LoanTransaction::select('loan.id as id', 'loan_type.name as type', 'member.member_no as memberNo', 'users.first_name as firstname', 'users.middle_name as middlename', 'users.last_name as lastname',DB::raw('MAX(date) as lastTransactionDate'),DB::raw('SUM(amount) AS balance'),DB::raw('MAX(start_amort_date) AS startAmortDate'),DB::raw('MAX(end_amort_date) AS endAmortDate'))
  ->leftjoin('loan','loan_transaction.loan_id','=','loan.id')
  ->leftjoin('loan_type','loan.type_id','=','loan_type.id')
  ->leftjoin('member','loan.member_id','=','member.id')
  ->leftjoin('users','member.user_id','=','users.id')
  ->groupBy('loan.id',
    'loan_type.name',
    'member.member_no',
    'users.first_name',
    'users.middle_name',
    'users.last_name')
  ->orderBy('lastTransactionDate','desc')

  ->paginate(10); 

  
  return view('admin.loans_masterlist', array('loans'=>$loans));
}

public function loandetails($id)
{


 $loans=LoanTransaction::select('loan_transaction.id as id', 'member.*','reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount','loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date and lt.id <= loan_transaction.id order by date desc, loan_transaction.id desc) as balance'))
 ->leftjoin('loan','loan_transaction.loan_id','loan.id')
 ->leftjoin('member','loan.member_id','member.id')
 ->leftjoin('loan_type','loan.type_id','loan_type.id')
 ->where('loan.id','=',$id)
 ->Where('loan_transaction.amount','<>',0.00)
 ->orderBy('loan.type_id', 'ASC')
 ->orderBy('date','desc')
 ->orderBy('loan_transaction.id','desc')
 ->paginate(10); 



 $member= User::where('users.id',$loans[0]->user_id)
 ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
 ->leftjoin('member','users.id','=','member.user_id')
 ->leftjoin('campus','member.campus_id','=','campus.id')
 ->first();


 
 
 return view('admin.loan_details', array('loans'=>$loans,'member'=>$member));
}


public function generatesoa($id)
{
  $member= User::where('users.id',$id)
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

public function generateequity($id)
{
  $member= User::where('users.id',$id)
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

public function generateloans($id)
{
 $member= User::where('users.id',$id)
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

public function generateloanspertype($id)
{


 $loans=LoanTransaction::select('loan_transaction.id as id', 'member.*', 'reference_no', 'date', 'loan_id', 'amortization', 'interest', 'amount','loan_type.name', DB::raw('(select SUM(amount) from loan_transaction as lt where lt.loan_id = loan.id and lt.date<=loan_transaction.date and lt.id <= loan_transaction.id order by date desc, loan_transaction.id desc) as balance'))
 ->leftjoin('loan','loan_transaction.loan_id','loan.id')
 ->leftjoin('member','loan.member_id','member.id')
 ->leftjoin('loan_type','loan.type_id','loan_type.id')
 ->where('loan.id','=',$id)
 ->Where('loan_transaction.amount','<>',0.00)
 ->orderBy('loan.type_id', 'ASC')
 ->orderBy('date','desc')
 ->orderBy('loan_transaction.id','desc')
 ->get(); 

 $member= User::where('users.id',$loans[0]->user_id)
 ->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name')
 ->leftjoin('member','users.id','=','member.user_id')
 ->leftjoin('campus','member.campus_id','=','campus.id')
 ->first();

 $data['loans']=$loans;
 $data['member']=$member;



 $pdf = PDF::loadView('pdf.loans', $data);
 return $pdf->setPaper('a4', 'landscape')->stream('loan.pdf');

}

public function equity($id)
{
  $member= User::where('users.id',$id)
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
  ->paginate(10);
  // $equity=ContributionTransaction::select('contribution_transaction.id as id', 'date', 'account_id', 'contribution_id', 'reference_no', 'amount','contribution_account.name', DB::raw('(select SUM(amount) from contribution_join as c where c.member_id=contribution.member_id and c.date<=contribution.date) as balance'))
  // ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
  // // ->leftjoin('member','contribution.member_id','member.id')
  // ->leftjoin('contribution_account','contribution_transaction.account_id','contribution_account.id')
  // ->where('contribution.member_id','=',$member->member_id)
  // ->where('contribution_transaction.amount','<>',0.00)
  // ->orderBy('date','desc')
  // ->paginate(10);
        // dd($equity);
  return view('admin.member_equity',array('equity'=>$equity, 'member'=>$member));

}

public function loans($id)
{
  $member= User::where('users.id',$id)
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
  return view('admin.member_loan',array('loans'=>$loans, 'member'=>$member));

}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatepw()
    {
     $member= User::where('users.id',Auth::user()->id)
     ->select('*')->first();

     return view('admin.updatepassword');
   }

   public function savepw(Request $request)
   {
     $member= User::where('users.id',Auth::user()->id)
     ->select('*')->first();


     $newpass=$request->password;

     $confirm=Hash::check($request->currentPassword, $member->password);
     if($confirm)
     {
      $user = User::find(Auth::user()->id);
      $user->update([
        'password' => Hash::make($newpass)
      ]);
      return redirect('/admin/update-password')
      ->with('success', 'Password successfully updated.');
    }
    else
    {
      return redirect('/admin/update-password')
      ->with('error', 'The current password you entered is incorrect.');
    }

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
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function manageadmin()
    {

      if(isset($_GET['q']))
      {

        $admin=Admin::select('*')
        ->leftjoin('users','admin.user_id','users.id')
        ->leftjoin('cluster','admin.cluster_id','cluster.id')
        ->where( DB::raw('CONCAT(users.first_name," ",users.last_name)'),'like','%'.$_GET['q'].'%')
        ->orWhere('users.first_name','like','%'.$_GET['q'].'%')
        ->orWhere('users.last_name','like','%'.$_GET['q'].'%')
        ->paginate(10); 
      }
      else
      {
       $admin=Admin::select('*')
       ->leftjoin('users','admin.user_id','users.id')
       ->leftjoin('cluster','admin.cluster_id','cluster.id')
       ->paginate(10);
     }
 // dd($admin);
     return view('admin.admin',array('admins'=>$admin));
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function adminadd()
    {

      $clusters=DB::table('cluster')
      ->get();

      return view('admin.addadmin',array('clusters'=>$clusters));
    }

    public function adminsave(Request $request)
    {
      $checkemail=DB::table('users')->where('email','=',$request->email)->first();
      if(count($checkemail)>0)
      {
       return redirect('/admin/add')
       ->with('error', 'Email is already used');
     }

     $tempass_length=10;
     $tempass=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$tempass_length);

$emailadd=$request->email;
     $id = DB::table('users')->insertGetId(
      ['first_name' => $request->firstName, 'last_name' => $request->lastName, 'email'=>$request->email, 'password'=>Hash::make($tempass), 'archived'=>0, 'password_set'=>0 ]
    );
     if($request->role=='SUPER_ADMIN')
     {
      DB::table('admin')->insertGetId(
        ['user_id' => $id, 'role' => $request->role, 'cluster_id'=>1]
      );
    }
    else
    {
     DB::table('admin')->insertGetId(
      ['user_id' => $id, 'role' => $request->role, 'cluster_id'=>$request->cluster]
    );
   }

   Mail::send('emailTemplates.adminAccount', ['firstName' => $request->firstName, 'email' => $request->email, 'password' => $tempass], function ($message)use ($emailadd)
   {
     $message->subject('Admin Account');

     $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

     $message->to($emailadd);

   });

   $clusters=DB::table('cluster')
   ->get();

   return redirect('/admin/add')
   ->with('success', 'Admin created successfully.');
 }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }

     public function resetpass($id)
    {
           $tempass_length=10;
         $tempass=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$tempass_length);
         $hashedpass = Hash::make($tempass);
        
         DB::table('users')
            ->where('id', $id)
            ->update(['password' => $hashedpass, 'password_set' => 0]);

             $member=Member::select('*')
     ->leftjoin('users','member.user_id','users.id')
     ->leftjoin('campus','member.campus_id','campus.id')
     ->where('users.id','=',$id)
     ->first();

     // dd($member);

     return view('admin.member_reset_pass',array('newpass'=>$tempass, 'member'=>$member));


    }
  }
