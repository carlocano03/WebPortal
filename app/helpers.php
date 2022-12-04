<?php

function getUserdetails()
{
 
	$user_type=\App\Member::where('user_id',Auth::user()->id)->select('*')->first();

	if($user_type==null)
	{

		$user_type='admin';
	}
	else
	{
		$user_type='member';
	}
	if($user_type=='member')
	{
	$user=\App\User::where('users.id',Auth::user()->id)
	->select('*','member.id as member_id','users.id as user_id','campus.name as campus_name','position.name as position_name')
	->leftjoin('member','users.id','=','member.user_id')
	->leftjoin('campus','member.campus_id','=','campus.id')
	->leftjoin('position','member.position_id','=','position.id')
	->first();
	 $user['usertype']=$user_type;
	}
	else
	{
	$user=\App\User::where('users.id',Auth::user()->id)
	->select('*','admin.id as admin_id','users.id as user_id')
	->leftjoin('admin','users.id','=','admin.user_id')
	->leftjoin('cluster','admin.cluster_id','=','cluster.id')
	->first();
	$user['usertype']=$user_type;
	}
	return $user;


}

function voting()
{
 
	$voting = true;

	return $voting;


}

