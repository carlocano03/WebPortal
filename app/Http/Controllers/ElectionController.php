<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ElectionController extends Controller
{
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

    	$voted15=DB::table('electionsg1-15')
    	->where('member_no','=',getUserdetails()->member_no)
    	->first();


    	$voted16=DB::table('electionsg16-above')
    	->where('member_no','=',getUserdetails()->member_no)
    	->first();

        if( $voted15==null && $voted16==null)
        {
        	$voted=false;
        }
        else
        {
        	$voted=true;
        }

        $salarygrade=DB::table('member_sg')
        ->select('sg')
        ->where('member_no','=',getUserdetails()->member_no)
        ->first()
        ->{'sg'};
        return view('member.election', array('sg'=>$salarygrade, 'voted'=>$voted));
    }

    public function admin_election()
    {
    	
    	$manila = DB::table('member')->rightjoin('member_sg','member_sg.member_no','=','member.member_no')->where('campus_id',"=",4)->count();
    	$pgh = DB::table('member')->rightjoin('member_sg','member_sg.member_no','=','member.member_no')->where('campus_id',"=",5)->count();
    	$allmembers=$manila+$pgh;

    	$manila15 = DB::table('member')->rightjoin('electionsg1-15','electionsg1-15.member_no','=','member.member_no')->where('campus_id',"=",4)->count();
    	$manila16 = DB::table('member')->rightjoin('electionsg16-above','electionsg16-above.member_no','=','member.member_no')->where('campus_id',"=",4)->count();

    	$pgh15 = DB::table('member')->rightjoin('electionsg1-15','electionsg1-15.member_no','=','member.member_no')->where('campus_id',"=",5)->count();
    	$pgh16 = DB::table('member')->rightjoin('electionsg16-above','electionsg16-above.member_no','=','member.member_no')->where('campus_id',"=",5)->count();

        $manilavoted=$manila15+$manila16;
        $pghvoted=$pgh15+$pgh16;

        $totalvoted=$manilavoted+$pghvoted;

        $manilanotvoted=$manila-$manilavoted;
        $pghnotvoted=$pgh-$pghvoted;

        $totalnotvoted=$manilanotvoted+$pghnotvoted;

        $manila15tot = DB::table('member')->rightjoin('member_sg','member_sg.member_no','=','member.member_no')->where('campus_id',"=",4)->where('campus_id',"=",4)->where('sg','<=','15')->count();
        $manila16tot = DB::table('member')->rightjoin('member_sg','member_sg.member_no','=','member.member_no')->where('campus_id',"=",4)->where('sg','>','15')->count();

        $pgh15tot = DB::table('member')->rightjoin('member_sg','member_sg.member_no','=','member.member_no')->where('campus_id',"=",5)->where('sg','<=','15')->count();
        $pgh16tot = DB::table('member')->rightjoin('member_sg','member_sg.member_no','=','member.member_no')->where('campus_id',"=",5)->where('sg','>','15')->count();

        $salary15voted=DB::table('electionsg1-15')->leftjoin('member','member.member_no','=','electionsg1-15.member_no')->count();
        $salary16voted=DB::table('electionsg16-above')->leftjoin('member','member.member_no','=','electionsg16-above.member_no')->count();
        // dd($manila15tot);

        $results15=DB::table('electionsg1-15')->select(DB::raw('count(*) as count'), 'vote_casted')
        ->groupBy('electionsg1-15.vote_casted')
        ->orderby('electionsg1-15.vote_casted')
        ->get();
        $results16=DB::table('electionsg16-above')->select(DB::raw('count(*) as count'), 'vote_casted')
        ->groupBy('electionsg16-above.vote_casted')
        ->orderby('electionsg16-above.vote_casted')
        ->get();

        return view('admin.election', array('manila'=>$manila, 'pgh'=>$pgh, 'allmembers'=>$allmembers, 'manilavoted'=>$manilavoted, 'pghvoted'=>$pghvoted, 'totalvoted'=>$totalvoted, 'manilanotvoted'=>$manilanotvoted,'pghnotvoted'=>$pghnotvoted, 'totalnotvoted'=>$totalnotvoted, 'results15'=>$results15, 'results16'=>$results16, 'manila15tot'=>$manila15tot, 'manila16tot'=>$manila16tot, 'pgh15tot'=>$pgh15tot, 'pgh16tot'=>$pgh16tot, 'manila15'=>$manila15, 'manila16'=>$manila16, 'pgh15'=>$pgh15, 'pgh16'=>$pgh16));
    }

    public function savevote(Request $request)
    {
    	
    	if($request->sg<=15)
    	{
            $voted=DB::table('electionsg1-15')->where('member_no', getUserdetails()->member_no)->first();
            if(count($voted)>=1)
            {
              return redirect('/member/election');
          }
          else
          {
            $id=DB::table('electionsg1-15')->insertGetId(
                ['member_no' => getUserdetails()->member_no, 'vote_casted' => $request->vote]
            );

            $vote=DB::table('electionsg1-15')->where('id','=',$id)->first();
        }


    }
    else
    {
        $voted=DB::table('electionsg16-above')->where('member_no', getUserdetails()->member_no)->first();
        if(count($voted)>=1)
        {
          return redirect('/member/election');
      }
      else
      {
          $id=DB::table('electionsg16-above')->insertGetId(
           ['member_no' => getUserdetails()->member_no, 'vote_casted' => $request->vote]
       );

          $vote=DB::table('electionsg16-above')->where('id','=',$id)->first();
      }
  }
    	// dd($vote->vote_casted);
  $casted=$vote->vote_casted;
  echo json_encode($casted);

}

public function abstainvote(Request $request)
{

 if($request->sg<=15)
 {
  DB::table('electionsg1-15')->insert(
   ['member_no' => getUserdetails()->member_no, 'vote_casted' => $request->vote]
);
}
else
{
  DB::table('electionsg16-above')->insert(
   ['member_no' => getUserdetails()->member_no, 'vote_casted' => $request->vote]
);
}

return 1;

}
}
