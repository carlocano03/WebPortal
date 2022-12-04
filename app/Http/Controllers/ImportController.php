<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campus;
use App\Department;
use App\Position;
use App\Member;
use App\User;
use App\Contribution;
use App\ContributionTransaction;
use App\LoanTransaction;
use App\LoanType;
use App\Loan;
use App\Tempass;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Excel;
use Response;
use Hash;
use DB;

class ImportController extends Controller
{
  private $requiredheaders;
  private $requiredheadersequity;
  private $requiredheadersloan;
  private $requireddata;
  private $requireddataequity;
  private $requireddataloan;
  private $uppfi_length;
  private $contact_length;
  private $haserror;
  private $passwords;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
        // $this->passwords=array(['uppfi_number'=>'213123','email'=>'reginaldmurill@yahoo','password'=>'asdsadsad'],['uppfi_number'=>'213123','email'=>'reginaldmurill@yahoo','password'=>'asdsadsad']);
      $this->passwords=array();
      $this->middleware('auth');
      $this->haserror=false;
      $this->uppfi_length=9;
      $this->contact_length=10;
      $this->requiredheaders=([
       'uppfi_no',
       'last_name',
       'first_name',
       'middle_name',
       'email_address',
       'contact_number',
       'membership_date',
       'orig_appointment_date',
       'campus',
       'class',
       'position'
     ]);

      $this->requireddata=([
       'uppfi_no',
       'last_name',
       'first_name',
       'email_address',
       'membership_date',
       'orig_appointment_date',
       'campus',
       'class',
       'position'
     ]);

      $this->requiredheadersequity=([
       'date',
       'uppfi_no',
       'transaction',
       'up_contribution',
       'member_contribution',
       'earnings_on_up_contribution',
       'earnings_on_member_contribution'
     ]);

      $this->requireddataequity=([
        'date',
        'uppfi_no'
            // 'up_contribution',
            // 'member_contribution',
            // 'earnings_on_up_contribution',
            // 'earnings_on_member_contribution'
      ]);

      $this->requiredheadersloan=([
       'date',
       'uppfi_no',
       'transaction',
       'type',
       'amount',
       'amortization',
       'interest',
       'amortization_start_date',
       'amortization_end_date'
     ]);


      $this->requireddataloan=([
       'date',
       'uppfi_no',
       'type',
       'amount',
       'amortization',
       'interest'
     ]);
    }
    public function index()
    {
        //
    }

    public function import_member()
    {
        // dd(getUserdetails());
      return view('admin.import_members');

    }

    public function import_equity()
    {

      return view('admin.import_equity');

    }

    public function import_loan()
    {

      return view('admin.import_loan');

    }


    public function loan_action(Request $request)
    {


     $uploadedFile = $request->file('file')[0];



     $filename = date("Y-m-dHis").'-'.$uploadedFile->getClientOriginalName();
     $destinationPath = public_path().'/storage/app/csv_upload/loan/';
     $uploadedFile->move($destinationPath,$filename);
     $success=true;

     $path =public_path().'/storage/app/csv_upload/loan/'.$filename;
     $datas= Excel::load($path, false, 'ISO-8859-1')->get();

     $headers=$datas->first()->keys()->toArray();

     $this->validateHeadersLoan($headers);

     $errors=$this->validateDataLoan($datas);
         // dd($datas);

     if(!$this->haserror)
     {

      $this->processDataLoan($datas);
      return 'success';     
    }
    
        // success


        //with errors



    return Response::json($errors)->setStatusCode(400);

  }

  private function validateHeadersLoan($headers) {

    $diffHeaders = array_diff($this->requiredheadersloan, $headers);
    $hasSameHeaders = empty($diffHeaders);


    if (!$hasSameHeaders) {
      $headers = implode(', ', $this->requiredheadersloan);
      $message = sprintf('Invalid CSV headers.  Expected headers are %s', $headers);

      throw new \Exception($message);
    }
  }

  public function validateDataLoan($datas)
  {


   $errors=['errors'=>[]];
   $witherrors=false;
   foreach ($datas as $data) {

     $data=$data->toArray();
     $data=array_map('trim', $data);

     $err=array();
     foreach ($data as $key => $value) {

       if(($value==null && $value<>0) && in_array($key, $this->requireddataloan))
       {

        $witherrors=true;

      }



    }

    if($witherrors)
    {
      $requiredd = implode(', ', $this->requireddataloan);
      $message = sprintf('Required data are %s', $requiredd);
      array_push($err, $message);

    }
    if(getUserdetails()->role=="SUPER_ADMIN")
    {
     $member=Member::where('member_no',$data['uppfi_no'])->first();
   }
   else
   {

     $member=Member::leftjoin('campus','member.campus_id','campus.id')->where('member_no',$data['uppfi_no'])->where('campus.cluster_id','=',getUserdetails()->cluster_id)->first();
   }
   if ($member==null) 
   {
    $message=sprintf('Member does not exist or is not included in your cluster (ID: %s)', $data['uppfi_no']);
    array_push($err, $message);
  }

  $loantype=LoanType::where('name',$data['type'])->first();
  if ($loantype==null) 
  {
    $message=sprintf('Invalid Loan Type');
    array_push($err, $message);
  }

  try {
   $opdate = new \DateTime($data['date']);
   $operrors = \DateTime::getLastErrors();

   if ($operrors['warning_count'] > 0 || $operrors['error_count'] > 0) {
    $message=sprintf('Invalid date');
    array_push($err, $message);
  }
} catch (\Exception $e) {
 $message=sprintf('Invalid date');
 array_push($err, $message);
}

try {
 $opdate = new \DateTime($data['amortization_start_date']);
 $operrors = \DateTime::getLastErrors();

 if ($operrors['warning_count'] > 0 || $operrors['error_count'] > 0) {
  $message=sprintf('Invalid amortization_start_date');
  array_push($err, $message);
}
} catch (\Exception $e) {
 $message=sprintf('Invalid amortization_start_date');
 array_push($err, $message);
}

try {
 $opdate = new \DateTime($data['amortization_end_date']);
 $operrors = \DateTime::getLastErrors();

 if ($operrors['warning_count'] > 0 || $operrors['error_count'] > 0) {
  $message=sprintf('Invalid amortization_end_date');
  array_push($err, $message);
}
} catch (\Exception $e) {
 $message=sprintf('Invalid amortization_end_date');
 array_push($err, $message);
}


$allerrors=implode(', ', $err);
if(!$this->haserror)
{
  if( $allerrors != "")
  {
    $this->haserror=true;
  }
}

array_push($errors['errors'], $allerrors);


}



return $errors;

}

public function processDataLoan($datas)
{



  foreach ($datas as $data) {
   $data=$data->toArray();
   $data=array_map('trim', $data);

   $member=Member::where('member_no',$data['uppfi_no'])->first();

   $transaction=$data['transaction'];
   $date=date("Y-m-d", strtotime($data['date']));
   $loantype=LoanType::where('name',$data['type'])->first();


   $existingloan=Loan::where('member_id','=',$member['id'])->where('type_id','=',$loantype['id'])->first();

   if($existingloan==null)
   {
     $loanid = Loan::insertGetId(['member_id' => $member['id'], 'type_id' => $loantype['id'],'added_by'=>getUserdetails()->user_id]);
   }
   else
   {
    $loanid=$existingloan['id'];
  }



  $amount=floatval(str_replace( ',', '',$data['amount']));
  $amortization=floatval(str_replace( ',', '',$data['amortization']));
  $interest=floatval(str_replace( ',', '',$data['interest']));
  $startdate=date("Y-m-d", strtotime($data['amortization_start_date']));
  $enddate=date("Y-m-d", strtotime($data['amortization_end_date']));
  loanTransaction::insert(['loan_id'=>$loanid, 'reference_no'=>$transaction, 'date'=>$date, 'amortization'=>$amortization, 'amount'=>$amount, 'interest'=>$interest, 'start_amort_date'=>$startdate, 'end_amort_date'=>$enddate,'added_by'=>getUserdetails()->user_id]);



}




}


public function equity_action(Request $request)
{


 $uploadedFile = $request->file('file')[0];

 $filename = date("Y-m-dHis").'-'.$uploadedFile->getClientOriginalName();
 $destinationPath = public_path().'/storage/app/csv_upload/equity/';
 $uploadedFile->move($destinationPath,$filename);
 $success=true;

 $path =public_path().'/storage/app/csv_upload/equity/'.$filename;
 $datas= Excel::load($path, false, 'ISO-8859-1')->get();

 $headers=$datas->first()->keys()->toArray();
 $this->validateHeadersEquity($headers);

 $errors=$this->validateDataEquity($datas);
         // dd($datas);

 if(!$this->haserror)
 {
// dd(1);
  $this->processDataEquity($datas);
  return 'success';     
}

        // success


        //with errors



return Response::json($errors)->setStatusCode(400);

}

private function validateHeadersEquity($headers) {

  $diffHeaders = array_diff($this->requiredheadersequity, $headers);
  $hasSameHeaders = empty($diffHeaders);


  if (!$hasSameHeaders) {
    $headers = implode(', ', $this->requiredheadersequity);
    $message = sprintf('Invalid CSV headers.  Expected headers are %s', $headers);

    throw new \Exception($message);
  }
}

public function validateDataEquity($datas)
{

 $members=DB::table('member_cluster')->where('cluster_id','=',getUserdetails()->cluster_id)->pluck('member_no')->toArray();


 $errors=['errors'=>[]];
 $witherrors=false;
 foreach ($datas as $data) {

   $data=$data->toArray();
   $data=array_map('trim', $data);

   $err=array();
   foreach ($data as $key => $value) {

     if( $value==null && in_array($key, $this->requireddataequity))
     {

       $requiredd = implode(', ', $this->requireddataequity);
       $message = sprintf('Required data are %s', $requiredd);
       array_push($err, $message);

     }



   }

$member='';
   if(getUserdetails()->role=="SUPER_ADMIN")
   {

     $member=Member::where('member_no',$data['uppfi_no'])->first();
   }
   else
   {
    if (in_array($data['uppfi_no'], $members)) 
    { 
     $member=1;
   } 


   
 }
 if ($member==null or $member=='' ) 
 {
  $message=sprintf('Member does not exist or is not included in your cluster (ID: %s)', $data['uppfi_no']);
  array_push($err, $message);
}

try {
 $opdate = new \DateTime($data['date']);
 $operrors = \DateTime::getLastErrors();

 if ($operrors['warning_count'] > 0 || $operrors['error_count'] > 0) {
  $message=sprintf('Invalid date');
  array_push($err, $message);
}
} catch (\Exception $e) {
 $message=sprintf('Invalid date');
 array_push($err, $message);
}

//$number=floatval(str_replace( ',', '',$data['up_contribution']));

  // if (is_string(floatval(str_replace( ',', '',$data['up_contribution'])))) 
  //    {
  //       $message=sprintf('Invalid up_contribution');
  //       array_push($err, $message);
  //    }

  //    if (is_string(floatval(str_replace( ',', '',$data['member_contribution'])))) 
  //    {
  //       $message=sprintf('Invalid member_contribution');
  //       array_push($err, $message);
  //    }

  //    if (is_string(floatval(str_replace( ',', '',$data['earnings_on_up_contribution'])))) 
  //    {
  //       $message=sprintf('earnings_on_member_contribution');
  //       array_push($err, $message);
  //    }

  //     if (is_string(floatval(str_replace( ',', '',$data['earnings_on_member_contribution'])))) 
  //    {
  //       $message=sprintf('earnings_on_member_contribution');
  //       array_push($err, $message);
  //    }

$allerrors=implode(', ', $err);
if(!$this->haserror)
{
  if( $allerrors != "")
  {
    $this->haserror=true;
  }
}

array_push($errors['errors'], $allerrors);


}


// dd(1);
return $errors;

}

public function processDataEquity($datas)
{

// dd(1);

  foreach ($datas as $data) {
   $data=$data->toArray();
   $data=array_map('trim', $data);

   $member=Member::where('member_no',$data['uppfi_no'])->first();

   $transaction=$data['transaction'];
   $date=date("Y-m-d", strtotime($data['date']));

            // $memberpass=array();
            // $uppfino=(int)$data['uppfi_no'];
            // $email=$data['email_address'];
            // $tempass=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$tempass_length);
            // $hashedpass = Hash::make($tempass);

            // $memberpass['uppfi_number'] = $uppfino;
            // $memberpass['email'] = $email;
            // $memberpass['password'] = $tempass;
            // array_push($this->passwords, $memberpass); 

   $contrid= Contribution::insertGetId(['member_id' => $member['id'], 'reference_no' => $transaction, 'date' => $date, 'added_by'=>getUserdetails()->user_id]
 );


   $membercontri=floatval(str_replace( ',', '',$data['member_contribution']));
   $upcontri=floatval(str_replace( ',', '',$data['up_contribution']));
   $earningsmember=floatval(str_replace( ',', '',$data['earnings_on_member_contribution']));
   $earningsup=floatval(str_replace( ',', '',$data['earnings_on_up_contribution']));
   ContributionTransaction::insert(['contribution_id'=>$contrid, 'account_id'=>1, 'amount'=>$upcontri]);
   ContributionTransaction::insert(['contribution_id'=>$contrid, 'account_id'=>2, 'amount'=>$membercontri]);
   ContributionTransaction::insert(['contribution_id'=>$contrid, 'account_id'=>3, 'amount'=>$earningsup]);
   ContributionTransaction::insert(['contribution_id'=>$contrid, 'account_id'=>4, 'amount'=>$earningsmember]);


 }




}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function member_action(Request $request)
    {

      $uploadedFile = $request->file('file')[0];

      $filename = date("Y-m-dHis").'-'.$uploadedFile->getClientOriginalName();

        // Storage::put("public\csv_upload".$filename,'public');
      $destinationPath = public_path().'/storage/app/csv_upload/member/';
      $uploadedFile->move($destinationPath,$filename);
      $success=true;


      $path =public_path().'/storage/app/csv_upload/member/'.$filename;
      $datas= Excel::load($path, false, 'ISO-8859-1')->get();


      $headers=$datas->first()->keys()->toArray();
      $this->validateHeaders($headers);

 // return $success;
        // return $errors;
      $errors=$this->validateData($datas);

      if(!$this->haserror)
      {
        $this->processData($datas);
        return 'success';     
      }

        // success


        //with errors



      return Response::json($errors)->setStatusCode(400);
    }

    public function validateData($datas)
    {


     $errors=['errors'=>[]];
     $witherrors=false;
     foreach ($datas as $data) {
      $data=$data->toArray();
      $data=array_map('trim', $data);
 // dd($data);

      $err=array();
      foreach ($data as $key => $value) {

       if($value=='' && in_array($key, $this->requireddata))
       {
       
         $requiredd = implode(', ', $this->requireddata);
         $message = sprintf('Required data are %s', $requiredd);
         array_push($err, $message);


         array_push($errors['errors'], $err);

       }     
     }

     // dd(1);

     $member=Member::where('member_no',$data['uppfi_no'])->first();
     $user=User::where('email',$data['email_address'])->first();
     if ($member!=null || $user!=null) 
     {
      $message=sprintf('Member already exists or email is already in use');
      array_push($err, $message);
    }
    $uppfino=(int)$data['uppfi_no'];


    if(strlen((string)$uppfino)!=$this->uppfi_length)
    {
      $message=sprintf('uppfi_no must be exactly %s characters in length', $this->uppfi_length);
      array_push($err, $message);
    }

    if($data['contact_number']!=null)
    {
      $contactno=(int)$data['contact_number'];
      if(strlen((string) $contactno)!=$this->contact_length)
      {
       $message=sprintf('contact_number must be exactly %s characters in length', $this->contact_length);
       array_push($err, $message);
     }
   }

   if (!filter_var($data['email_address'], FILTER_VALIDATE_EMAIL)) {
    $message=sprintf('Invalid email_address format');
    array_push($err, $message);
  }

  $campus=Campus::where('campus_key',$data['campus'])->first();
  if ($campus==null) {
    $message=sprintf('Invalid campus');
    array_push($err, $message);
  }

  $department=Department::where('name',$data['class'])->first();
  if ($department==null) {
    $message=sprintf('Invalid class');
    array_push($err, $message);
  }

    // $position=Position::where('name',$data['position'])->first();
    // if ($position==null) {
    //     $message=sprintf('Invalid position');
    //     array_push($err, $message);
    // }

  try {
   $opdate = new \DateTime($data['orig_appointment_date']);
   $operrors = \DateTime::getLastErrors();

   if ($operrors['warning_count'] > 0 || $operrors['error_count'] > 0) {
    $message=sprintf('Invalid orig_appointment_date');
    array_push($err, $message);
  }
} catch (\Exception $e) {
 $message=sprintf('Invalid orig_appointment_date');
 array_push($err, $message);
}

$allerrors=implode(', ', $err);

if(!$this->haserror)
{
  if( $allerrors != "")
  {
    $this->haserror=true;
  }
}

array_push($errors['errors'], $allerrors);


}



return $errors;

}

private function validateHeaders($headers) {

  $diffHeaders = array_diff($this->requiredheaders, $headers);
  $hasSameHeaders = empty($diffHeaders);


  if (!$hasSameHeaders) {
    $headers = implode(', ', $this->requiredheaders);
    $message = sprintf('Invalid CSV headers.  Expected headers are %s', $headers);

    throw new \Exception($message);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function processData($datas)
    {

         //datetime-clusterid-user_id-name
      $filename=date("Y-m-dHis").'-'.getUserdetails()->cluster_id.'-'.getUserdetails()->user_id.'-'.str_replace(' ', '', getUserdetails()->name);
      $tempass_length=10;

      foreach ($datas as $data) {

       $data=$data->toArray();
       $data=array_map('trim', $data);

       $memberpass=array();
       $uppfino=(int)$data['uppfi_no'];
       $email=$data['email_address'];
       $tempass=substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$tempass_length);
       $hashedpass = Hash::make($tempass);

       $memberpass['uppfi_number'] = $uppfino;
       $memberpass['email'] = $email;
       $memberpass['password'] = $tempass;
       array_push($this->passwords, $memberpass); 

       $userid= User::insertGetId(['first_name' => strtoupper($data['first_name']), 'middle_name' => strtoupper($data['middle_name']), 'last_name' => strtoupper($data['last_name']), 'email' => $data['email_address'],
        'password' =>  $hashedpass, 'contact_no' => (int)$data['contact_number'],'archived' => 0,'password_set' => 0]
      );


       $appoint=date("Y-m-d", strtotime($data['orig_appointment_date']));
       $campus=Campus::where('campus_key',$data['campus'])->first();
       $department=Department::where('name',$data['class'])->first();
            // $position=Position::where('name',$data['position'])->first();
       Member::insert(['member_no'=>$uppfino, 'user_id'=>$userid, 'campus_id'=>$campus['id'], 'department_id'=>$department['id'], 'position_id'=>$data['position'], 'membership_date'=>$data['membership_date'], 'original_appointment_date'=>$appoint, 'added_by'=>getUserdetails()->user_id]);




     }

     Excel::create($filename, function($excel) {

      $excel->sheet('Sheetname', function($sheet) {

        $sheet->fromArray($this->passwords, null, 'A1', false, true);

      });

    })->store('csv', public_path().'/storage/app/passwords');


     Tempass::insert(['filename' => $filename.'.csv', 'cluster' => getUserdetails()->cluster_id, 'uploaded_by' => getUserdetails()->user_id]);



   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
