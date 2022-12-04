<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Excel;

class RefundController extends Controller
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
    $prme_pr=DB::table('prme_pr')
    ->get();


    return view('admin.prme_pr.index',array('prme_pr'=>$prme_pr));
  }


  public function prme_pr_det($id)
  {

    $prme_pr=DB::table('prme_pr')
    ->where('id',$id)
    ->first();

    $prmepr_count=DB::table('prme_pr_applications')->count();

    $clusters=DB::table('campus')->get();
    


    return view('admin.prme_pr.prme_pr_det',array('prme_pr'=>$prme_pr,'prmepr_count'=>$prmepr_count, 'campus'=> $clusters));
  }

  public function prmepr_generate(Request $request)
  {
    $record=array('Member No', 'Name', 'Earnings UP', 'Earnings Member', 'Total', '10% Tax', 'Net Ammount', 'Patronage Refund', 'Total', 'Option Selected','TIN', 'BANK','Account Name', 'Account Number');
     $recordcsv=array();
     array_push($recordcsv,$record);

     $prme_pr=DB::table('prme_pr')
    ->where('id',$request->prmepr_id)
    ->first();

 $clusterselected=DB::table('campus')->where('id',$request->camp_id)->first();


     $applications=DB::table('prme_pr_applications')
     ->leftjoin('member','prme_pr_applications.member_no','=','member.member_no')
     ->leftjoin('users','member.user_id','=','users.id')
     ->leftjoin('campus','member.campus_id','=','campus.id')
     ->leftjoin('member_detail','member.member_no','=','member_detail.member_no')
     ->leftjoin('member_pr','member.member_no','=','member_pr.member_no')
     ->leftjoin('member_prme','member.member_no','=','member_prme.member_no')
     ->where('campus.id',$request->camp_id)
     ->where('prme_pr_applications.prme_pr_id',$request->prmepr_id)
     ->get();

   
foreach ($applications as $app) {
 
array_push($recordcsv, [$app->member_no, $app->last_name.', '.$app->first_name.' '.$app->middle_name, $app->up_contri, $app->mem_contri, $app->total,  $app->tax, $app->net_total,  $app->amount, $app->amount+$app->net_total, $app->option_selected, $app->tin, $app->bank, $app->account_name, $app->account_number]);
};



 Excel::create('prme_pr_report-'.$prme_pr->year.'('.$clusterselected->name.')', function($excel) use ($recordcsv) {

      $excel->sheet('Sheetname', function($sheet) use ($recordcsv) {

        $sheet->fromArray($recordcsv, null, 'A1', false, false);

      });

    })->download('xls');
  }

  public function prme_pr($id)
  {

    $prme_pr_id=prme_pr()->id;
    $user=DB::table('users')->leftjoin('member','users.id','=','member.user_id')->where('users.id',$id)->first();
    
    $pr=DB::table('member_pr')->where('member_no',$user->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    $prme=DB::table('member_prme')->where('member_no',$user->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    
    $existing_application=DB::table('prme_pr_applications')->where('member_no',$user->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    

    return view('member.prme_pr.index',array('pr'=>$pr, 'prme'=>$prme, 'existing'=>$existing_application));
  }

  public function submit_prme_pr(Request $request, $id)
  {

    $tosave=array();

    $prme_pr_id=prme_pr()->id;
    $user=DB::table('users')->leftjoin('member','users.id','=','member.user_id')->where('users.id',$id)->first();

    $tosave['member_no']=$user->member_no;
    $tosave['prme_pr_id']=$prme_pr_id;
    $tosave['option_selected']=$request->optradio;
    if($request->optradio=='A')
    {
      $tosave['bank']=$request->bank;
      $tosave['account_number']=$request->acc_num;
      $tosave['account_name']=$request->acc_name;
    }

    DB::table('prme_pr_applications')
    ->insert($tosave);
    $existing_application=DB::table('prme_pr_applications')->where('member_no',$user->member_no)->first();

    $pr=DB::table('member_pr')->where('member_no',$user->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    $prme=DB::table('member_prme')->where('member_no',$user->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    
return redirect('/member/prme_pr/'.$id);
    // return view('member.prme_pr.index',array('pr'=>$pr, 'prme'=>$prme, 'existing'=>$existing_application));
  }

  

  public function generate_form($id)
  {


    $prme_pr_id=prme_pr()->id;
    $member=DB::table('users')->leftjoin('member','users.id','=','member.user_id')
    ->leftjoin('campus','member.campus_id','=','campus.id')
    ->leftjoin('member_detail','member.member_no','=','member_detail.member_no')->where('users.id',$id)->first();
// dd($member);
    

    $pr=DB::table('member_pr')->where('member_no',$member->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    $prme=DB::table('member_prme')->where('member_no',$member->member_no)->where('prme_pr_id',$prme_pr_id)->first();

    $prme_pr_app_det=DB::table('prme_pr_applications')->where('member_no',$member->member_no)->where('prme_pr_id',$prme_pr_id)->first();
    
    $data['member']=$member;
    $data['pr']=$pr;
    $data['prme']=$prme;
    $data['prme_pr']=$prme_pr_app_det;

    $pdf = PDF::loadView('pdf.prme_pr', $data);
    return $pdf->stream('prme_pr.pdf');
  }
}
