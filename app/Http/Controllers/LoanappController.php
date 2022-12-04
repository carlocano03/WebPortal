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
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoanappController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function add_log($loan_app_id, $control_number, $action, $message, $attachment, $message_flag, $admin, $added_by)
    {
     $logs=DB::table('loan_applications_logs')->insert(
      ['loan_app_id' => $loan_app_id, 'control_number'=>$control_number, 'action' => $action, 'message' => $message, 'attachment'=>$attachment, 'message_flag'=>$message_flag, 'admin'=> $admin,'added_by'=>$added_by]);


   }


   public function index()
   {
        //return view('admin.dashboard',array('campuses'=>$campuses,'totalmembers'=>$memberscount,'totalloansgranted'=>$totalloansgranted,'campusmembers'=>$campusmembers,'contributions'=>$contributions,'totalequity'=>$totalequity,'activecampus'=>$activecampus));

    // dd(getUserdetails());

    $loans=DB::table('loan_applications')
    ->select('loan_applications.*', 'loan_type.name', 'loan_type.description')
    ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
    ->where('loan_applications.member_no',getUserdetails()->member_no)
    ->orderByRaw("field(loan_applications.status,'PROCESSING','DONE','CONFIRMED','CANCELLED')")
    ->orderBy('loan_applications.loan_type','asc')
    ->orderBy('loan_applications.date_created','desc')

    ->paginate(10); 

    return view('member.loan_application.index',array('loans'=>$loans));
  }

  public function index_coborrower()
  {
    return view('member.loan_application.index_coborrower');
  }

  public function admin_index()
  {
   if(getUserdetails()->role=="SUPER_ADMIN")
   {
     if(isset($_GET['q']))
     {
      $loans=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name, ", ", users.first_name," ", users.middle_name) AS full_name'), 'loan_applications_peb.type as application_type', 'campus.name as campus')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('loan_applications_peb','loan_applications.id','loan_applications_peb.loan_app_id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('campus','member.campus_id','campus.id')
      ->leftjoin('users','member.user_id','users.id')
      ->orderByRaw("field(loan_applications.status,'PROCESSING','DONE','CONFIRMED','CANCELLED')")
      ->orderBy('loan_applications.loan_type','asc')
      ->orderBy('loan_applications.date_created','desc')
         ->where('loan_applications.not_archived',1)
      ->where('member.member_no','like','%'.$_GET['q'].'%')
      ->orWhere( DB::raw('CONCAT(users.first_name," ",users.last_name)'),'like','%'.$_GET['q'].'%')
      ->orWhere('users.first_name','like','%'.$_GET['q'].'%')
      ->orWhere('users.last_name','like','%'.$_GET['q'].'%')
      ->orWhere('loan_applications.control_number','like','%'.$_GET['q'].'%')
      ->paginate(10); 
    }
    else
    {
      $loans=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name, ", ", users.first_name," ", users.middle_name) AS full_name'), 'loan_applications_peb.type as application_type', 'campus.name as campus')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('loan_applications_peb','loan_applications.id','loan_applications_peb.loan_app_id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('campus','member.campus_id','campus.id')
      ->leftjoin('users','member.user_id','users.id')
      ->orderByRaw("field(loan_applications.status,'PROCESSING','DONE','CONFIRMED','CANCELLED')")
      ->orderBy('loan_applications.loan_type','asc')
      ->orderBy('loan_applications.date_created','desc')
         ->where('loan_applications.not_archived',1)
      ->paginate(10); 
    }
  }
  else

  {
    if(isset($_GET['q']))
    {
     $loans=DB::table('loan_applications')
     ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name, ", ", users.first_name," ", users.middle_name) AS full_name'), 'loan_applications_peb.type as application_type', 'campus.name as campus')
     ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
     ->leftjoin('loan_applications_peb','loan_applications.id','loan_applications_peb.loan_app_id')
     ->leftjoin('member','loan_applications.member_no','member.member_no')
     ->leftjoin('campus','member.campus_id','campus.id')
     ->leftjoin('users','member.user_id','users.id')
     ->orderByRaw("field(loan_applications.status,'PROCESSING','DONE','CONFIRMED','CANCELLED')")
     ->orderBy('loan_applications.loan_type','asc')
     ->orderBy('loan_applications.date_created','desc')
        ->where('loan_applications.not_archived',1)
     ->where('campus.cluster_id','=',getUserdetails()->cluster_id)
     ->where(function($query) {
      $query  ->where('member.member_no','like','%'.$_GET['q'].'%')
      ->orWhere( DB::raw('CONCAT(users.first_name," ",users.last_name)'),'like','%'.$_GET['q'].'%')
      ->orWhere('users.first_name','like','%'.$_GET['q'].'%')
      ->orWhere('users.last_name','like','%'.$_GET['q'].'%')
      ->orWhere('loan_applications.control_number','like','%'.$_GET['q'].'%');
    })
     ->paginate(10); 
   }
   else
   {
    $loans=DB::table('loan_applications')
    ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name, ", ", users.first_name," ", users.middle_name) AS full_name'), 'loan_applications_peb.type as application_type', 'campus.name as campus')
    ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
    ->leftjoin('loan_applications_peb','loan_applications.id','loan_applications_peb.loan_app_id')
    ->leftjoin('member','loan_applications.member_no','member.member_no')
    ->leftjoin('campus','member.campus_id','campus.id')
    ->leftjoin('users','member.user_id','users.id')
    ->orderByRaw("field(loan_applications.status,'PROCESSING','DONE','CONFIRMED','CANCELLED')")
    ->orderBy('loan_applications.loan_type','asc')
    ->orderBy('loan_applications.date_created','desc')
       ->where('loan_applications.not_archived',1)
    ->where('campus.cluster_id','=',getUserdetails()->cluster_id)
    ->paginate(10); 
  }
}



return view('admin.loan_application.index',array('loans'=>$loans));
}

public function new_loan()
{

        //return view('admin.dashboard',array('campuses'=>$campuses,'totalmembers'=>$memberscount,'totalloansgranted'=>$totalloansgranted,'campusmembers'=>$campusmembers,'contributions'=>$contributions,'totalequity'=>$totalequity,'activecampus'=>$activecampus));
  $member=DB::table('contribution_transaction')->select(DB::raw('SUM(contribution_transaction.amount) as total'))
  ->leftjoin('contribution','contribution_transaction.contribution_id','contribution.id')
  ->where('contribution.member_id','=',getUserdetails()->member_id)
  ->first();

  $appointment_date=DB::table('member')->select('original_appointment_date')
  ->where('member.id','=',getUserdetails()->member_id)
  ->first();
  $ap=strtotime($appointment_date->original_appointment_date);
  $ad=date('Y-m-d G:i:s',$ap);
  $date = new \DateTime($ad);
  $now = new \DateTime();
  $year=$date->diff($now)->format("%y");

  $pel_count=DB::table('loan_applications')
  ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
  ->where('loan_applications.member_no',getUserdetails()->member_no)
  ->where('loan_type.id',1)
  ->where('loan_applications.status','PROCESSING')
  ->count();

  $bl_count=DB::table('loan_applications')
  ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
  ->where('loan_applications.member_no',getUserdetails()->member_no)
  ->where('loan_type.id',2)
  ->where('loan_applications.status','PROCESSING')
  ->count();

  $eml_count=DB::table('loan_applications')
  ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
  ->where('loan_applications.member_no',getUserdetails()->member_no)
  ->where('loan_type.id',3)
  ->where('loan_applications.status','PROCESSING')
  ->count();

  $cbl_count=DB::table('loan_applications')
  ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
  ->where('loan_applications.member_no',getUserdetails()->member_no)
  ->where('loan_type.id',4)
  ->where('loan_applications.status','PROCESSING')
  ->count();

  $btl_count=DB::table('loan_applications')
  ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
  ->where('loan_applications.member_no',getUserdetails()->member_no)
  ->where('loan_type.id',5)
  ->where('loan_applications.status','PROCESSING')
  ->count();



  return view('member.loan_application.new_loan',array('equity'=>$member, 'years'=>$year, 'pel_count'=>$pel_count, 'bl_count'=>$bl_count, 'eml_count'=>$eml_count, 'cbl_count'=>$cbl_count, 'btl_count'=>$btl_count));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function view_loan($id)
    {
        // return abort(404);

      $loan=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->where('loan_applications.member_no',getUserdetails()->member_no)
      ->where('loan_applications.id',$id)
      ->first();       

      if($loan)
      {
        if($loan->name=='PEL'||$loan->name=='EML'||$loan->name=='BL')
        {
         $loan_details=DB::table('loan_applications_peb')
         ->where('loan_app_id',$loan->id)
         ->first();

         $loan_ded=DB::table('loan_applications_deductions')
         ->where('loan_app_id',$loan->id)
         ->get(); 

       }
       elseif ($loan->name=='CBL') 
       {
              # code...
       }
       elseif ($loan->name=='BL') 
       {
              # code...
       }

     }
     else
     {
       return abort(404); 
     }



     return view('member.loan_application.loan_details',array('loan'=>$loan,'loan_details'=>$loan_details, 'loan_ded'=>$loan_ded));
   }


   public function confirm_agree($id)
   {
     DB::table('loan_applications')
     ->where('id', $id)
     ->update(
      ['status' => 'CONFIRMED', 'date_closed'=>date('Y-m-d H:i:s')]);

     $loan=DB::table('loan_applications')
     ->select('loan_applications.*', 'loan_type.name', 'loan_type.description')
     ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
     ->where('loan_applications.id',$id)
     ->first();    

     $cluster=DB::table('cluster_email')
     ->where('cluster_id', getUserdetails()->cluster_id)
     ->first();  
     $cluster_email=$cluster->email;

     $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

     Mail::send('emailTemplates.loanConfirmed', ['member'=>$name, 'member_no'=>getUserdetails()->member_no,'loan_type'=>$loan->description,'control_number'=>$loan->control_number], function ($message)use ($cluster_email)
     {
       $message->subject('Member Confirmed Loan Application');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($cluster_email);

     });  

     return redirect('member/loan-app')
     ->with('success', 'Loan Application Successfully Confirmed');
   }

   public function app_cancel($id)
   {
     DB::table('loan_applications')
     ->where('id', $id)
     ->update(
      ['status' => 'CANCELLED', 'cancellation_reason'=>'Member Cancellation', 'date_closed'=>date('Y-m-d H:i:s')]);

     $loan=DB::table('loan_applications')
     ->select('loan_applications.*', 'loan_type.name', 'loan_type.description')
     ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
     ->where('loan_applications.id',$id)
     ->first();    

     $cluster=DB::table('cluster_email')
     ->where('cluster_id', getUserdetails()->cluster_id)
     ->first();  
     $cluster_email=$cluster->email;

     $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

     Mail::send('emailTemplates.loanMembercancel', ['member'=>$name, 'member_no'=>getUserdetails()->member_no,'loan_type'=>$loan->description,'control_number'=>$loan->control_number], function ($message)use ($cluster_email)
     {
       $message->subject('Member Cancel Loan Application');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($cluster_email);

     });  

     return redirect('member/loan-app')
     ->with('success', 'Loan Application Successfully Cancelled');
   }



   public function edit_loan_form($id)
   {

    if(getUserdetails()->role=="SUPER_ADMIN")
    {
      $loan=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name,", ",users.first_name) AS full_name'))
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$id)
      ->first();
    }
    else
    {
      $loan=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name,", ",users.first_name) AS full_name'))
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->leftjoin('campus','member.campus_id','campus.id')
      ->where('campus.cluster_id','=',getUserdetails()->cluster_id)
      ->where('loan_applications.id',$id)
      ->first();
    }



    if($loan)
    {

     $loan_details=DB::table('loan_applications_peb')
     ->where('loan_app_id',$loan->id)
     ->first(); 

     $loan_ded=DB::table('loan_applications_deductions')
     ->where('loan_app_id',$loan->id)
     ->get();      

   }
   else
   {
     return abort(404); 
   }

$deduction=array();
foreach($loan_ded as $ded)
{
  $deduction[$ded->description]=$ded->amount;
}

$fix_deductions=array("Service Fee", "Outstanding Loan - Principal(PEL)", "Outstanding Loan - Principal(BL)", "Outstanding Loan - Principal(EML)","Outstanding Loan - Principal(CBL)","Interest - PEL","Interest - BL", "Interest - EML", "Interest - CBL", "Surcharge");

$i=1;
$other=array();
foreach($loan_ded as $ded)
{
  if (!in_array($ded->description, $fix_deductions)) {
    $other['other'.$i]=['description'=>$ded->description, 'amount'=>$ded->amount];
    $i++;
}
}

$loan_type=DB::table('loan_type')->get();



   return view('admin.loan_application.edit_loan_details',array('loan'=>$loan,'loan_details'=>$loan_details,'loan_ded'=>$deduction, 'other'=>$other, 'loan_type'=>$loan_type));
 }

 public function admin_peb_details($id)
   {

    if(getUserdetails()->role=="SUPER_ADMIN")
    {
      $loan=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name,", ",users.first_name) AS full_name'))
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$id)
      ->first();
    }
    else
    {
      $loan=DB::table('loan_applications')
      ->select('loan_applications.*', 'loan_type.name', 'loan_type.description',DB::raw('CONCAT(users.last_name,", ",users.first_name) AS full_name'))
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->leftjoin('campus','member.campus_id','campus.id')
      ->where('campus.cluster_id','=',getUserdetails()->cluster_id)
      ->where('loan_applications.id',$id)
      ->first();
    }



    if($loan)
    {

     $loan_details=DB::table('loan_applications_peb')
     ->where('loan_app_id',$loan->id)
     ->first(); 

     $loan_ded=DB::table('loan_applications_deductions')
     ->where('loan_app_id',$loan->id)
     ->get();      

   }
   else
   {
     return abort(404); 
   }

$loan_type=DB::table('loan_type')->get();


   return view('admin.loan_application.loan_details',array('loan'=>$loan,'loan_details'=>$loan_details,'loan_ded'=>$loan_ded, 'loan_type'=>$loan_type));
 }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pel_loan_new(Request $request)
    {
// dd(getUserdetails());
//       dd($request->all());
      $current_year=date('Y');
      $control=DB::table('loan_app_series')->where('loan_type',1)->first();
      if($control->year==$current_year)
      {
        $current_counter=$control->current_counter+1;
        $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
        $control_number=$control->loan_type_code.'-'.$control->year.'-'.date('m').'-'.$counter_digits;
        DB::table('loan_app_series')
        ->where('loan_type', 1)
        ->update(['current_last' => $control_number,'current_counter' => $current_counter]);


      }
      else
      {
        $year=$current_year;
        $current_counter=0+1;
        $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
        $control_number=$control->loan_type_code.'-'.$year.'-'.date('m').'-'.$counter_digits;
        DB::table('loan_app_series')
        ->where('loan_type', 1)
        ->update(['year'=>$year,'current_last' => $control_number,'current_counter' => $current_counter]);


      }

      if($request->update_profile)
      {
        DB::table('users')
        ->where('id', getUserdetails()->user_id)
        ->update(['email'=>$request->email,'contact_no' => $request->c_number]);
      }

      $loanapp_id=DB::table('loan_applications')->insertGetId(
        ['member_no' => getUserdetails()->member_no, 'loan_type' => 1,'control_number'=>$control_number, 'active_email'=>$request->email, 'active_number'=>$request->c_number, 'status' => 'PROCESSING']);

      $loandet_id=DB::table('loan_applications_peb')->insertGetId(
        ['bank' => $request->bank, 'loan_app_id' => $loanapp_id, 'account_number' => $request->acc_num, 'account_name' => $request->acc_name, 'type' => 'NEW', 'amount' => $request->amount]);


      $target_dir = public_path()."/storage/app/loan_application/";
      $target_file = $target_dir . basename($_FILES["identification"]["name"]);
      $temp = $_FILES["identification"]["name"];
      $file_ext = substr($temp, strripos($temp, '.'));
      $uploadOk = 1;


      $newfilename = 'id-'.$loanapp_id.$file_ext;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      move_uploaded_file($_FILES["identification"]["tmp_name"], $target_dir.$newfilename);


      $identification=$newfilename;

      DB::table('loan_applications_peb')
      ->where('id', $loandet_id)
      ->update(
        ['p_id' => $identification]);

      $temp = $_FILES["payslip1"]["name"];
      $file_ext = substr($temp, strripos($temp, '.'));
      $newfilename = 'payslip1-'.$loanapp_id.$file_ext;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      move_uploaded_file($_FILES["payslip1"]["tmp_name"], $target_dir.$newfilename);


      $payslip1=$newfilename;

      DB::table('loan_applications_peb')
      ->where('id', $loandet_id)
      ->update(
        ['payslip_1' => $payslip1]);


      $temp = $_FILES["payslip2"]["name"];
      $file_ext = substr($temp, strripos($temp, '.'));
      $newfilename = 'payslip2-'.$loanapp_id.$file_ext;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      move_uploaded_file($_FILES["payslip2"]["tmp_name"], $target_dir.$newfilename);



      $payslip2=$newfilename;

      DB::table('loan_applications_peb')
      ->where('id', $loandet_id)
      ->update(
        ['payslip_2' => $payslip2]);

      $temp = $_FILES["passbook"]["name"];
      $file_ext = substr($temp, strripos($temp, '.'));
      $newfilename = 'passbook-'.$loanapp_id.$file_ext;
      $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      move_uploaded_file($_FILES["passbook"]["tmp_name"], $target_dir.$newfilename);



      $passbook=$newfilename;

      DB::table('loan_applications_peb')
      ->where('id', $loandet_id)
      ->update(
        ['atm_passbook' => $passbook]);

      $this->add_log($loanapp_id, $control_number, 'PEL APPLICATION SUBMITTED', NULL, NUll, 1, 0, getUserdetails()->user_id);

      $data['loan_type']='Personal Equity Loan';
      $data['control_number']=$control_number;

      $emailadd=getUserdetails()->email;

      $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

      Mail::send('emailTemplates.loanSuccess', ['firstName' => $name,'loan_type'=>'Personal Equity Loan','control_number'=>$control_number], function ($message)use ($emailadd)
      {
       $message->subject('Loan Application Processing ');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($emailadd);

     });

      $cluster=DB::table('cluster_email')
      ->where('cluster_id', getUserdetails()->cluster_id)
      ->first();  
      $cluster_email=$cluster->email;

      $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

      Mail::send('emailTemplates.loanAdminnotif', ['member'=>$name, 'member_no'=>getUserdetails()->member_no,'loan_type'=>'Personal Equity Loan','control_number'=>$control_number], function ($message)use ($cluster_email)
      {
       $message->subject('New Loan Application');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($cluster_email);

     });  

      return view('member.loan_application.loan_success',array('loan_type'=>'Personal Equity Loan','control_number'=>$control_number));




    }

    public function pel_loan_renew(Request $request)
    {

     $current_year=date('Y');
     $control=DB::table('loan_app_series')->where('loan_type',1)->first();
     if($control->year==$current_year)
     {
      $current_counter=$control->current_counter+1;
      $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
      $control_number=$control->loan_type_code.'-'.$control->year.'-'.date('m').'-'.$counter_digits;
      DB::table('loan_app_series')
      ->where('loan_type', 1)
      ->update(['current_last' => $control_number,'current_counter' => $current_counter]);


    }
    else
    {
      $year=$current_year;
      $current_counter=0+1;
      $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
      $control_number=$control->loan_type_code.'-'.$year.'-'.date('m').'-'.$counter_digits;
      DB::table('loan_app_series')
      ->where('loan_type', 1)
      ->update(['year'=>$year,'current_last' => $control_number,'current_counter' => $current_counter]);


    }
    if($request->update_profile)
    {
      DB::table('users')
      ->where('id', getUserdetails()->user_id)
      ->update(['email'=>$request->email,'contact_no' => $request->c_number]);
    }

        // dd($request->all());
    $loanapp_id=DB::table('loan_applications')->insertGetId(
      ['member_no' => getUserdetails()->member_no, 'loan_type' => 1,'control_number'=>$control_number, 'active_email'=>$request->email, 'active_number'=>$request->c_number, 'status' => 'PROCESSING']);

    $loandet_id=DB::table('loan_applications_peb')->insertGetId(
      ['bank' => $request->bank, 'loan_app_id' => $loanapp_id, 'account_number' => $request->acc_num, 'account_name' => $request->acc_name, 'type' => 'RENEW', 'renewal_type'=>$request->renewal_option]);

    $target_dir = public_path()."/storage/app/loan_application/";
    $target_file = $target_dir . basename($_FILES["identification"]["name"]);
    $temp = $_FILES["identification"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $uploadOk = 1;


    $newfilename = 'id-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["identification"]["tmp_name"], $target_dir.$newfilename);


    $identification=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['p_id' => $identification]);


    $temp = $_FILES["payslip1"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $newfilename = 'payslip1-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["payslip1"]["tmp_name"], $target_dir.$newfilename);


    $payslip1=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['payslip_1' => $payslip1]);


    $temp = $_FILES["payslip2"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $newfilename = 'payslip2-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["payslip2"]["tmp_name"], $target_dir.$newfilename);



    $payslip2=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['payslip_2' => $payslip2]);

    $temp = $_FILES["passbook"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $newfilename = 'passbook-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["passbook"]["tmp_name"], $target_dir.$newfilename);

    $passbook=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['atm_passbook' => $passbook]);

    $this->add_log($loanapp_id, $control_number, 'PEL APPLICATION SUBMITTED', NULL, NUll, 1, 0, getUserdetails()->user_id);

    $data['loan_type']='Personal Equity Loan';
    $data['control_number']=$control_number;

    $emailadd=getUserdetails()->email;

    $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

    Mail::send('emailTemplates.loanSuccess', ['firstName' => $name,'loan_type'=>'Personal Equity Loan','control_number'=>$control_number], function ($message)use ($emailadd)
    {
     $message->subject('Loan Application Received');

     $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

     $message->to($emailadd);

   });

    $cluster=DB::table('cluster_email')
    ->where('cluster_id', getUserdetails()->cluster_id)
    ->first();  
    $cluster_email=$cluster->email;

    $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

    Mail::send('emailTemplates.loanAdminnotif', ['member'=>$name, 'member_no'=>getUserdetails()->member_no,'loan_type'=>'Personal Equity Loan','control_number'=>$control_number], function ($message)use ($cluster_email)
    {
     $message->subject('New Loan Application');

     $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

     $message->to($cluster_email);

   });  

    return view('member.loan_application.loan_success',array('loan_type'=>'Personal Equity Loan','control_number'=>$control_number));
  }

  public function eml_loan_new(Request $request)
  {
    $current_year=date('Y');
    $control=DB::table('loan_app_series')->where('loan_type',3)->first();
    if($control->year==$current_year)
    {
      $current_counter=$control->current_counter+1;
      $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
      $control_number=$control->loan_type_code.'-'.$control->year.'-'.date('m').'-'.$counter_digits;
      DB::table('loan_app_series')
      ->where('loan_type', 3)
      ->update(['current_last' => $control_number,'current_counter' => $current_counter]);


    }
    else
    {
      $year=$current_year;
      $current_counter=0+1;
      $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
      $control_number=$control->loan_type_code.'-'.$year.'-'.date('m').'-'.$counter_digits;
      DB::table('loan_app_series')
      ->where('loan_type', 3)
      ->update(['year'=>$year,'current_last' => $control_number,'current_counter' => $current_counter]);


    }
    if($request->update_profile)
    {
      DB::table('users')
      ->where('id', getUserdetails()->user_id)
      ->update(['email'=>$request->email,'contact_no' => $request->c_number]);
    }

    $loanapp_id=DB::table('loan_applications')->insertGetId(
      ['member_no' => getUserdetails()->member_no, 'loan_type' => 3,'control_number'=>$control_number, 'active_email'=>$request->email, 'active_number'=>$request->c_number, 'status' => 'PROCESSING']);

    $loandet_id=DB::table('loan_applications_peb')->insertGetId(
      ['bank' => $request->bank, 'loan_app_id' => $loanapp_id, 'account_number' => $request->acc_num, 'account_name' => $request->acc_name, 'type' => 'NEW', 'amount' => $request->amount]);


    $target_dir = public_path()."/storage/app/loan_application/";
    $target_file = $target_dir . basename($_FILES["identification"]["name"]);
    $temp = $_FILES["identification"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $uploadOk = 1;


    $newfilename = 'id-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["identification"]["tmp_name"], $target_dir.$newfilename);


    $identification=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['p_id' => $identification]);


    $temp = $_FILES["payslip1"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $newfilename = 'payslip1-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["payslip1"]["tmp_name"], $target_dir.$newfilename);


    $payslip1=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['payslip_1' => $payslip1]);


    $temp = $_FILES["payslip2"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $newfilename = 'payslip2-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["payslip2"]["tmp_name"], $target_dir.$newfilename);



    $payslip2=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['payslip_2' => $payslip2]);

    $temp = $_FILES["passbook"]["name"];
    $file_ext = substr($temp, strripos($temp, '.'));
    $newfilename = 'passbook-'.$loanapp_id.$file_ext;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["passbook"]["tmp_name"], $target_dir.$newfilename);

    $passbook=$newfilename;

    DB::table('loan_applications_peb')
    ->where('id', $loandet_id)
    ->update(
      ['atm_passbook' => $passbook]);

    $this->add_log($loanapp_id, $control_number, 'EML APPLICATION SUBMITTED', NULL, NUll, 1, 0, getUserdetails()->user_id);


    $data['loan_type']='Emergency Loan';
    $data['control_number']=$control_number;

    $emailadd=getUserdetails()->email;

    $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

    Mail::send('emailTemplates.loanSuccess', ['firstName' => $name,'loan_type'=>'Emergency Loan','control_number'=>$control_number], function ($message)use ($emailadd)
    {
     $message->subject('Loan Application Received');

     $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

     $message->to($emailadd);

   });

    $cluster=DB::table('cluster_email')
    ->where('cluster_id', getUserdetails()->cluster_id)
    ->first();  
    $cluster_email=$cluster->email;

    $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

    Mail::send('emailTemplates.loanAdminnotif', ['member'=>$name, 'member_no'=>getUserdetails()->member_no,'loan_type'=>'Emergency Loan','control_number'=>$control_number], function ($message)use ($cluster_email)
    {
     $message->subject('New Loan Application');

     $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

     $message->to($cluster_email);

   });  

    return view('member.loan_application.loan_success',array('loan_type'=>'Emergency Loan','control_number'=>$control_number));


  }

  // public function eml_loan_renew(Request $request)
  // {
  //   $loanapp_id=DB::table('loan_applications')->insertGetId(
  //     ['member_no' => getUserdetails()->member_no, 'loan_type' => 3, 'status' => 'PROCESSING']);

  //   $loandet_id=DB::table('loan_applications_peb')->insertGetId(
  //     ['bank' => $request->bank, 'loan_app_id' => $loanapp_id, 'account_number' => $request->acc_num, 'account_name' => $request->acc_name, 'type' => 'RENEW', 'renewal_type'=>$request->renewal_option]);

  //   $target_dir = public_path()."/storage/app/loan_application/";
  //   $target_file = $target_dir . basename($_FILES["identification"]["name"]);
  //   $temp = $_FILES["identification"]["name"];
  //   $file_ext = substr($temp, strripos($temp, '.'));
  //   $uploadOk = 1;


  //   $newfilename = 'id-'.$loanapp_id.$file_ext;
  //   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  //   move_uploaded_file($_FILES["identification"]["tmp_name"], $target_dir.$newfilename);


  //   $identification=$newfilename;

  //   DB::table('loan_applications_peb')
  //   ->where('id', $loandet_id)
  //   ->update(
  //     ['p_id' => $identification]);

  //   $newfilename = 'payslip1-'.$loanapp_id.$file_ext;
  //   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  //   move_uploaded_file($_FILES["payslip1"]["tmp_name"], $target_dir.$newfilename);


  //   $payslip1=$newfilename;

  //   DB::table('loan_applications_peb')
  //   ->where('id', $loandet_id)
  //   ->update(
  //     ['payslip_1' => $payslip1]);

  //   $newfilename = 'payslip2-'.$loanapp_id.$file_ext;
  //   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  //   move_uploaded_file($_FILES["payslip2"]["tmp_name"], $target_dir.$newfilename);



  //   $payslip2=$newfilename;

  //   DB::table('loan_applications_peb')
  //   ->where('id', $loandet_id)
  //   ->update(
  //     ['payslip_2' => $payslip2]);

  //   $newfilename = 'passbook-'.$loanapp_id.$file_ext;
  //   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  //   move_uploaded_file($_FILES["passbook"]["tmp_name"], $target_dir.$newfilename);



  //   $passbook=$newfilename;

  //   DB::table('loan_applications_peb')
  //   ->where('id', $loandet_id)
  //   ->update(
  //     ['atm_passbook' => $passbook]);

  //   $this->add_log($loanapp_id, $control_number, 'EML APPLICATION SUBMITTED', NULL, NUll, 1, 0, getUserdetails()->user_id);

  //   $data['loan_type']='Emergency Loan';
  //   $data['control_number']=$control_number;

  //   $emailadd=$loan->email;

  //   $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

  //   Mail::send('emailTemplates.loanSuccess', ['firstName' => $name,'loan_type'=>'Emergency Loan','control_number'=>$control_number], function ($message)use ($emailadd)
  //   {
  //    $message->subject('Loan Application Processing ');

  //    $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

  //    $message->to($emailadd);

  //  });

  //   return view('member.loan_application.loan_success',array('loan_type'=>'Emergency Loan','control_number'=>$control_number));
  // }

  public function bl_loan_new(Request $request)
  {

   $current_year=date('Y');
   $control=DB::table('loan_app_series')->where('loan_type',2)->first();
   if($control->year==$current_year)
   {
    $current_counter=$control->current_counter+1;
    $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
    $control_number=$control->loan_type_code.'-'.$control->year.'-'.date('m').'-'.$counter_digits;
    DB::table('loan_app_series')
    ->where('loan_type', 2)
    ->update(['current_last' => $control_number,'current_counter' => $current_counter]);


  }
  else
  {
    $year=$current_year;
    $current_counter=0+1;
    $counter_digits=str_pad($current_counter, $control->counter_length, '0', STR_PAD_LEFT);
    $control_number=$control->loan_type_code.'-'.$year.'-'.date('m').'-'.$counter_digits;
    DB::table('loan_app_series')
    ->where('loan_type', 2)
    ->update(['year'=>$year,'current_last' => $control_number,'current_counter' => $current_counter]);


  }

  if($request->update_profile)
  {
    DB::table('users')
    ->where('id', getUserdetails()->user_id)
    ->update(['email'=>$request->email,'contact_no' => $request->c_number]);
  }

  $loanapp_id=DB::table('loan_applications')->insertGetId(
    ['member_no' => getUserdetails()->member_no, 'loan_type' => 2,'control_number'=>$control_number, 'active_email'=>$request->email, 'active_number'=>$request->c_number, 'status' => 'PROCESSING']);

  $loandet_id=DB::table('loan_applications_peb')->insertGetId(
    ['bank' => $request->bank, 'loan_app_id' => $loanapp_id, 'account_number' => $request->acc_num, 'account_name' => $request->acc_name, 'type' => 'NEW', 'amount' => $request->amount]);


  $target_dir = public_path()."/storage/app/loan_application/";
  $target_file = $target_dir . basename($_FILES["identification"]["name"]);
  $temp = $_FILES["identification"]["name"];
  $file_ext = substr($temp, strripos($temp, '.'));
  $uploadOk = 1;


  $newfilename = 'id-'.$loanapp_id.$file_ext;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  move_uploaded_file($_FILES["identification"]["tmp_name"], $target_dir.$newfilename);


  $identification=$newfilename;

  DB::table('loan_applications_peb')
  ->where('id', $loandet_id)
  ->update(
    ['p_id' => $identification]);

  $temp = $_FILES["payslip1"]["name"];
  $file_ext = substr($temp, strripos($temp, '.'));
  $newfilename = 'payslip1-'.$loanapp_id.$file_ext;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  move_uploaded_file($_FILES["payslip1"]["tmp_name"], $target_dir.$newfilename);


  $payslip1=$newfilename;

  DB::table('loan_applications_peb')
  ->where('id', $loandet_id)
  ->update(
    ['payslip_1' => $payslip1]);


  $temp = $_FILES["payslip2"]["name"];
  $file_ext = substr($temp, strripos($temp, '.'));
  $newfilename = 'payslip2-'.$loanapp_id.$file_ext;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  move_uploaded_file($_FILES["payslip2"]["tmp_name"], $target_dir.$newfilename);



  $payslip2=$newfilename;

  DB::table('loan_applications_peb')
  ->where('id', $loandet_id)
  ->update(
    ['payslip_2' => $payslip2]);

  $temp = $_FILES["passbook"]["name"];
  $file_ext = substr($temp, strripos($temp, '.'));
  $newfilename = 'passbook-'.$loanapp_id.$file_ext;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  move_uploaded_file($_FILES["passbook"]["tmp_name"], $target_dir.$newfilename);


  $passbook=$newfilename;

  DB::table('loan_applications_peb')
  ->where('id', $loandet_id)
  ->update(
    ['atm_passbook' => $passbook]);

  $this->add_log($loanapp_id, $control_number, 'BL APPLICATION SUBMITTED', NULL, NUll, 1, 0, getUserdetails()->user_id);

  $data['loan_type']='Bridge Loan';
  $data['control_number']=$control_number;

  $emailadd=getUserdetails()->email;

  $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

  Mail::send('emailTemplates.loanSuccess', ['firstName' => $name,'loan_type'=>'Bridge Loan','control_number'=>$control_number], function ($message)use ($emailadd)
  {
   $message->subject('Loan Application Received');

   $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

   $message->to($emailadd);

 });

  $cluster=DB::table('cluster_email')
  ->where('cluster_id', getUserdetails()->cluster_id)
  ->first();  
  $cluster_email=$cluster->email;

  $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

  Mail::send('emailTemplates.loanAdminnotif', ['member'=>$name, 'member_no'=>getUserdetails()->member_no,'loan_type'=>'Bridge Loan','control_number'=>$control_number], function ($message)use ($cluster_email)
  {
   $message->subject('New Loan Application');

   $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

   $message->to($cluster_email);

 });  

  return view('member.loan_application.loan_success',array('loan_type'=>'Bridge Loan','control_number'=>$control_number));



}

// public function bl_loan_renew(Request $request)
// {
//   $loanapp_id=DB::table('loan_applications')->insertGetId(
//     ['member_no' => getUserdetails()->member_no, 'loan_type' => 2, 'status' => 'PROCESSING']);

//   $loandet_id=DB::table('loan_applications_peb')->insertGetId(
//     ['bank' => $request->bank, 'loan_app_id' => $loanapp_id, 'account_number' => $request->acc_num, 'account_name' => $request->acc_name, 'type' => 'RENEW', 'renewal_type'=>$request->renewal_option]);

//   $target_dir = public_path()."/storage/app/loan_application/";
//   $target_file = $target_dir . basename($_FILES["identification"]["name"]);
//   $temp = $_FILES["identification"]["name"];
//   $file_ext = substr($temp, strripos($temp, '.'));
//   $uploadOk = 1;


//   $newfilename = 'id-'.$loanapp_id.$file_ext;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//   move_uploaded_file($_FILES["identification"]["tmp_name"], $target_dir.$newfilename);


//   $identification=$newfilename;

//   DB::table('loan_applications_peb')
//   ->where('id', $loandet_id)
//   ->update(
//     ['p_id' => $identification]);

//   $newfilename = 'payslip1-'.$loanapp_id.$file_ext;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//   move_uploaded_file($_FILES["payslip1"]["tmp_name"], $target_dir.$newfilename);


//   $payslip1=$newfilename;

//   DB::table('loan_applications_peb')
//   ->where('id', $loandet_id)
//   ->update(
//     ['payslip_1' => $payslip1]);

//   $newfilename = 'payslip2-'.$loanapp_id.$file_ext;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//   move_uploaded_file($_FILES["payslip2"]["tmp_name"], $target_dir.$newfilename);



//   $payslip2=$newfilename;

//   DB::table('loan_applications_peb')
//   ->where('id', $loandet_id)
//   ->update(
//     ['payslip_2' => $payslip2]);

//   $newfilename = 'passbook-'.$loanapp_id.$file_ext;
//   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//   move_uploaded_file($_FILES["passbook"]["tmp_name"], $target_dir.$newfilename);



//   $passbook=$newfilename;

//   DB::table('loan_applications_peb')
//   ->where('id', $loandet_id)
//   ->update(
//     ['atm_passbook' => $passbook]);

//   $this->add_log($loanapp_id, $control_number, 'BL APPLICATION SUBMITTED', NULL, NUll, 1, 0, getUserdetails()->user_id);

//   $data['loan_type']='Bridge Loan';
//   $data['control_number']=$control_number;

//   $emailadd=$loan->email;

//   $name=getUserdetails()->first_name.' '.getUserdetails()->last_name;

//   Mail::send('emailTemplates.loanSuccess', ['firstName' => $name,'loan_type'=>'Bridge Loan','control_number'=>$control_number], function ($message)use ($emailadd)
//   {
//    $message->subject('Loan Application Processing ');

//    $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

//    $message->to($emailadd);

//  });

//   return view('member.loan_application.loan_success',array('loan_type'=>'Bridge Loan','control_number'=>$control_number));


// }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function admin_loan_processing($id)
    {

      $loan=DB::table('loan_applications')
      ->select('*')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$id)
      ->first();     
      
//dd(date("Y-m-d H:i:s"));
      $emailadd=$loan->email;

      $name=$loan->first_name.' '.$loan->last_name;

      Mail::send('emailTemplates.loanProcessing', ['firstName' => $name], function ($message)use ($emailadd)
      {
       $message->subject('Loan Application Processing');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($emailadd);

     });

      DB::table('loan_applications')
      ->where('id', $id)
      ->update(
        ['status' => 'PROCESSING', 'date_processed'=>date('Y-m-d H:i:s'), 'processed_by'=>getUserdetails()->user_id]);

      return redirect('admin/loan-app')
      ->with('success', 'Loan Application Successfully Updated');
    }

    public function admin_loan_closed(Request $request)
    {

      // dd($request->all());

      DB::table('loan_applications_deductions')->insert([
        ['loan_app_id' =>$request->loan_app_id , 'description' => 'Service Fee', 'amount'=>str_replace( ',', '', $request->servicefee_amount)]
      ]);


      if($request->out_pel_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(PEL)', 'amount'=>str_replace( ',', '', $request->out_pel_amount)]
        ]);
      }

      if($request->out_bl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(BL)', 'amount'=>str_replace( ',', '', $request->out_bl_amount)]
        ]);
      }

      if($request->out_eml_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(EML)', 'amount'=>str_replace( ',', '', $request->out_eml_amount)]
        ]);
      }

      if($request->out_cbl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(CBL)', 'amount'=>str_replace( ',', '', $request->out_cbl_amount)]
        ]);
      }

      if($request->int_pel_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - PEL', 'amount'=>str_replace( ',', '', $request->int_pel_amount)]
        ]);
      }

      if($request->int_bl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - BL', 'amount'=>str_replace( ',', '', $request->int_bl_amount)]
        ]);
      }

      if($request->int_eml_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - EML', 'amount'=>str_replace( ',', '', $request->int_eml_amount
        )]
        ]);
      }

      if($request->int_cbl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - CBL', 'amount'=>str_replace( ',', '', $request->int_cbl_amount)]
        ]);
      }

      if($request->surge_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Surcharge', 'amount'=>str_replace( ',', '', $request->surge_amount)]
        ]);
      }


      if($request->other1_desc)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => $request->other1_desc, 'amount'=>str_replace( ',', '', $request->other1_amount)]
        ]);
      }

      if($request->other2_desc)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => $request->other2_desc, 'amount'=>str_replace( ',', '', $request->other2_amount)]
        ]);
      }
      

      
      $cd=strtotime($request->ecd);
      $cfrom=strtotime($request->colfrom);
      $cto=strtotime($request->colto);
      $loan_type=$request->loan_type;

      $newformat = date('Y-m-d H:i:s',$cd);
      $newfrom = date('Y-m-d H:i:s',$cfrom);
      $newto = date('Y-m-d H:i:s',$cto);

      DB::table('loan_applications')
      ->where('id', $request->loan_app_id)
      ->update(
        ['status' => 'DONE','loan_type' => $loan_type,'approved_amount'=>str_replace( ',', '', $request->approved_amount), 'crediting_date'=>$newformat, 'monthly_amort'=>str_replace( ',', '', $request->monthly_amort), 'collect_from'=>$newfrom,'collect_to'=>$newto,'net_proceeds'=>str_replace( ',', '', $request->net_proceeds),  'date_closed'=>date('Y-m-d H:i:s'), 'closed_by'=>getUserdetails()->user_id]);

      $loan=DB::table('loan_applications')
      ->select('*')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$request->loan_app_id)
      ->first();  

       if(isset($request->renewal_type))
      {
         DB::table('loan_applications_peb')
      ->where('id', $request->loan_app_id)
      ->update(['renewal_type'=>$request->renewal_type]);
      }   

      $loan_details=DB::table('loan_applications_peb')
      ->where('loan_app_id',$request->loan_app_id)
      ->first();


      $emailadd=$loan->email;

      $name=$loan->first_name.' '.$loan->last_name;
      $loandesc=$loan->description;
      $loancontrol=$loan->control_number;
      $loanamt=$loan->approved_amount;
      $loancd=$loan->crediting_date;
      $loanamort=$loan->monthly_amort;
      $loanproceeds=$loan->net_proceeds;
      $loanbank=$loan_details->bank;
      $loanname=$loan_details->account_name;
      $loannum=$loan_details->account_number;


      $data=array();

      $data['loan']=DB::table('loan_applications')
      ->select('*', 'loan_applications.date_created as date_created','loan_type.description as loan')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('loan_applications_peb','loan_applications_peb.loan_app_id','loan_applications.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('member_detail','member.member_no', 'member_detail.member_no')
      ->leftjoin('campus','member.campus_id', 'campus.id')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$request->loan_app_id)
      ->first();

      $data['less']=DB::table('loan_applications_deductions')
      ->select('*')

      ->where('loan_app_id',$request->loan_app_id)
      ->get();
      // dd($data);

      $pdf = PDF::loadView('pdf.loan_form', $data);


      Mail::send('emailTemplates.loanClosed', ['firstName' => $name, 'loandesc'=>$loandesc, 'loancontrol'=>$loancontrol,'loanamt'=>$loanamt, 'loancd'=>$loancd, 'loanbank'=>$loanbank, 'loanname'=>$loanname,'loannum'=>$loannum, 'loanamort'=>$loanamort, 'loanproceeds'=>$loanproceeds], function ($message)use ($emailadd, $pdf)
      {
       $message->subject('Loan Application Approved');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($emailadd);
       $message->attachData($pdf->output(), "loan information slip.pdf");

     });

      

      return redirect('admin/loan-app')
      ->with('success', 'Loan Application Successfully Updated');
    }

     public function admin_loan_update(Request $request)
    {



DB::table('loan_applications_deductions')->where('loan_app_id',$request->loan_app_id)->delete();
 DB::table('loan_applications_deductions')->insert([
        ['loan_app_id' =>$request->loan_app_id , 'description' => 'Service Fee', 'amount'=>str_replace( ',', '', $request->servicefee_amount)]
      ]);


      if($request->out_pel_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(PEL)', 'amount'=>str_replace( ',', '', $request->out_pel_amount)]
        ]);
      }

      if($request->out_bl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(BL)', 'amount'=>str_replace( ',', '', $request->out_bl_amount)]
        ]);
      }

      if($request->out_eml_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(EML)', 'amount'=>str_replace( ',', '', $request->out_eml_amount)]
        ]);
      }

      if($request->out_cbl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Outstanding Loan - Principal(CBL)', 'amount'=>str_replace( ',', '', $request->out_cbl_amount)]
        ]);
      }

      if($request->int_pel_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - PEL', 'amount'=>str_replace( ',', '', $request->int_pel_amount)]
        ]);
      }

      if($request->int_bl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - BL', 'amount'=>str_replace( ',', '', $request->int_bl_amount)]
        ]);
      }

      if($request->int_eml_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - EML', 'amount'=>str_replace( ',', '', $request->int_eml_amount)]
        ]);
      }

      if($request->int_cbl_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Interest - CBL', 'amount'=>str_replace( ',', '', $request->int_cbl_amount)]
        ]);
      }

      if($request->surge_amount)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => 'Surcharge', 'amount'=>str_replace( ',', '', $request->surge_amount)]
        ]);
      }


      if($request->other1_desc)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => $request->other1_desc, 'amount'=>str_replace( ',', '', $request->other1_amount)]
        ]);
      }

      if($request->other2_desc)
      {
        DB::table('loan_applications_deductions')->insert([
          ['loan_app_id' =>$request->loan_app_id , 'description' => $request->other2_desc, 'amount'=>str_replace( ',', '', $request->other2_amount)]
        ]);
      }
      

      
      $cd=strtotime($request->ecd);
      $cfrom=strtotime($request->colfrom);
      $cto=strtotime($request->colto);
      $loan_type=$request->loan_type;

      $newformat = date('Y-m-d H:i:s',$cd);
      $newfrom = date('Y-m-d H:i:s',$cfrom);
      $newto = date('Y-m-d H:i:s',$cto);

      DB::table('loan_applications')
      ->where('id', $request->loan_app_id)
      ->update(
        ['status' => 'DONE', 'loan_type' => $loan_type, 'approved_amount'=>str_replace( ',', '', $request->approved_amount), 'crediting_date'=>$newformat, 'monthly_amort'=>str_replace( ',', '', $request->monthly_amort ), 'collect_from'=>$newfrom,'collect_to'=>$newto,'net_proceeds'=>str_replace( ',', '', $request->net_proceeds),  'date_closed'=>date('Y-m-d H:i:s'), 'closed_by'=>getUserdetails()->user_id]);

      $loan=DB::table('loan_applications')
      ->select('*')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$request->loan_app_id)
      ->first();     

      if(isset($request->renewal_type))
      {
         DB::table('loan_applications_peb')
      ->where('id', $request->loan_app_id)
      ->update(['renewal_type'=>$request->renewal_type]);
      }

      $loan_details=DB::table('loan_applications_peb')
      ->where('loan_app_id',$request->loan_app_id)
      ->first();


      $emailadd=$loan->email;

      $name=$loan->first_name.' '.$loan->last_name;
      $loandesc=$loan->description;
      $loancontrol=$loan->control_number;
      $loanamt=$loan->approved_amount;
      $loancd=$loan->crediting_date;
      $loanamort=$loan->monthly_amort;
      $loanproceeds=$loan->net_proceeds;
      $loanbank=$loan_details->bank;
      $loanname=$loan_details->account_name;
      $loannum=$loan_details->account_number;


      $data=array();

      $data['loan']=DB::table('loan_applications')
      ->select('*', 'loan_applications.date_created as date_created','loan_type.description as loan')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('loan_applications_peb','loan_applications_peb.loan_app_id','loan_applications.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('member_detail','member.member_no', 'member_detail.member_no')
      ->leftjoin('campus','member.campus_id', 'campus.id')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$request->loan_app_id)
      ->first();

      $data['less']=DB::table('loan_applications_deductions')
      ->select('*')

      ->where('loan_app_id',$request->loan_app_id)
      ->get();
      // dd($data);

      $pdf = PDF::loadView('pdf.loan_form', $data);


      Mail::send('emailTemplates.loanClosed', ['firstName' => $name, 'loandesc'=>$loandesc, 'loancontrol'=>$loancontrol,'loanamt'=>$loanamt, 'loancd'=>$loancd, 'loanbank'=>$loanbank, 'loanname'=>$loanname,'loannum'=>$loannum, 'loanamort'=>$loanamort, 'loanproceeds'=>$loanproceeds], function ($message)use ($emailadd, $pdf)
      {
       $message->subject('Loan Application Approved (UPDATED)');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($emailadd);
       $message->attachData($pdf->output(), "loan information slip.pdf");

     });

      

      return redirect('admin/loan-app')
      ->with('success', 'Loan Application Successfully Updated');
    
    }


    public function admin_loan_cancelled(Request $request)
    {



      $loan=DB::table('loan_applications')
      ->select('*')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$request->loan_app_id)
      ->first();     
      
// dd(date("Y-m-d H:i:s"));
      $emailadd=$loan->email;

      $name=$loan->first_name.' '.$loan->last_name;
      $loancontrol=$loan->control_number;
      $loandesc=$loan->description;

      Mail::send('emailTemplates.loanCancel', ['firstName' => $name,'loancontrol'=>$loancontrol,'loandesc'=>$loandesc], function ($message)use ($emailadd)
      {
       $message->subject('Loan Application Cancelled');

       $message->from('information@upprovidentfund.com', 'UP Provident Fund Inc.');

       $message->to($emailadd);

     });

      DB::table('loan_applications')
      ->where('id', $request->loan_app_id)
      ->update(
        ['cancellation_reason'=>$request->reason,'status' => 'CANCELLED', 'date_closed'=>date('Y-m-d H:i:s'), 'closed_by'=>getUserdetails()->user_id]);

      return redirect('admin/loan-app')
      ->with('success', 'Loan Application Successfully Updated');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generate_loan_form($id)
    {
      $data=array();

      $data['loan']=DB::table('loan_applications')
      ->select('*', 'loan_applications.date_created as date_created','loan_type.description as loan')
      ->leftjoin('loan_type','loan_applications.loan_type','loan_type.id')
      ->leftjoin('loan_applications_peb','loan_applications_peb.loan_app_id','loan_applications.id')
      ->leftjoin('member','loan_applications.member_no','member.member_no')
      ->leftjoin('member_detail','member.member_no', 'member_detail.member_no')
      ->leftjoin('campus','member.campus_id', 'campus.id')
      ->leftjoin('users','member.user_id','users.id')
      ->where('loan_applications.id',$id)
      ->first();

      $data['less']=DB::table('loan_applications_deductions')
      ->select('*')

      ->where('loan_app_id',$id)
      ->get();
      // dd($data);

      $pdf = PDF::loadView('pdf.loan_form', $data);

      return $pdf->stream($data['loan']->loan_app_id.'-'.$data['loan']->last_name.', '.$data['loan']->first_name.'.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
  }
