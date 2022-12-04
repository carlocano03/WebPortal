@extends('layouts/main')
@section('content_body')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style type="text/css">
hr { 
  display: block;
  margin-top: 0.5em;
  margin-bottom: 0.5em;
  margin-left: auto;
  margin-right: auto;
  border-style: inset;
  border-width: 1px;
} 
</style>
<div class="container mp-container">

  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2" style="padding-bottom: 0px!important;">
      <a href="{{url('/admin/election')}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Election Module</span>
      </a>
    </div>
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Election Dashboard
    </div>
  </div>

  <div class="row no-gutters mp-mb4">



    <div class="col-md-4 col-lg-4 mp-ph2 mp-pv2">
      <div class="mp-card mp-ph3 mp-pv3">
        <div class="mp-text-c-gray mp-text-fs-small">
          Total Members 
        </div>
        <div class="mp-card__body mp-text-fs-xlarge">
         Total - {{$allmembers}}
       </div>
       <br>
       @foreach($member_per_campus as $mc)
       <div class="mp-card__body mp-text-fs-medium">
         {{$mc->name}} - {{$mc->count}}
       </div>
       @endforeach
       
       <div class="mp-text-right mp-dashboard__icon mp-dashboard__icon--2x">
         @include('layouts.icons.i-vote')
       </div>
     </div>
   </div>

   <div class="col-md-4 col-lg-4 mp-ph2 mp-pv2">
    <div class="mp-card mp-ph3 mp-pv3">
      <div class="mp-text-c-gray mp-text-fs-small">
        Total Members Voted 
      </div>
      <div class="mp-card__body mp-text-fs-xlarge">
       Total - {{$allmembers_voted}}
     </div>
     <br>
     @foreach($member_per_campus_voted as $mc)
     <div class="mp-card__body mp-text-fs-medium">
       {{$mc->name}} - {{$mc->count}}
     </div>
     @endforeach
     <div class="mp-text-right mp-dashboard__icon mp-dashboard__icon--2x">
       @include('layouts.icons.i-vote')
     </div>
   </div>
 </div>

 <div class="col-md-4 col-lg-4 mp-ph2 mp-pv2">
  <div class="mp-card mp-ph3 mp-pv3">
    <div class="mp-text-c-gray mp-text-fs-small">
      Total Members Not Yet Voted 
    </div>
    <div class="mp-card__body mp-text-fs-xlarge">
     Total - {{$allmembers-$allmembers_voted}}
   </div>
   <br>
   <div class="mp-text-right mp-dashboard__icon mp-dashboard__icon--2x">
     @include('layouts.icons.i-vote')
   </div>
 </div>
</div>




</div>


<div class="col-12 mp-ph2 mp-pv2">
 <div class=" mp-card mp-card" align="left">
  <div class="mp-text-c-gray mp-text-fs-medium" align="center">
    <br>
    
    <strong>Salary Grade 1-15</strong>
    
    <br>
    Total Voters: {{$members15}}
    <br>
    @foreach($member15_voted as $mc)

    {{$mc->name}} Voted: {{$mc->count}}
    <br>
    @endforeach

  </div>
   <div class="mp-text-c-gray mp-text-fs-xlarge" align="center">
    <br>
    <strong>WINNER:</strong>
    <br>
    <strong style="color:green;">{{$elect->sg1_15}}</strong>
    <br>
    
  </div>
  <div style="padding: 10px">
   <br>
   <span><strong>ABSTAIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOTES: {{$member15_result_abstain}}</strong></span><div class="progress">
    <div class="progress-bar progress-bar-striped" style="width:{{($member15_result_abstain/$members15)*100}}%">{{($member15_result_abstain/$members15)*100}}%</div>
  </div>
  <br>
  <br>
  @foreach($member15_result as $res)
  @if($res->cand_name<>null)
  <span><strong>{{strtoupper($res->cand_name)}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOTES: {{$res->votes}}</strong></span><div class="progress">
    <div class="progress-bar progress-bar-striped" style="width:{{($res->votes/$members15)*100}}%">{{($res->votes/$members15)*100}}%</div>
  </div>
  <br>
  <br>
  @endif
  @endforeach
  
</div>
</div>
</div>

<div class="col-12 mp-ph2 mp-pv2">
 <div class=" mp-card mp-card" align="left">
  <div class="mp-text-c-gray mp-text-fs-medium" align="center">
    <br>
    <strong>Salary Grade 16 and Above</strong>
    <br>
    <br>
    Total Voters: {{$members16}}
    <br>
    @foreach($member16_voted as $mc)
    
    {{$mc->name}} Voted: {{$mc->count}}
    <br>
    @endforeach
  </div>
  <div class="mp-text-c-gray mp-text-fs-xlarge" align="center">
    <br>
    <strong>WINNER:</strong>
    <br>
    <strong style="color:green;">{{$elect->sg16_ABOVE}}</strong>
    <br>
    
  </div>
  <div style="padding: 10px">
   <br>
   <span><strong>ABSTAIN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOTES: {{$member16_result_abstain}}</strong></span><div class="progress">
    <div class="progress-bar progress-bar-striped" style="width:{{($member16_result_abstain/$members16)*100}}%">{{($member16_result_abstain/$members16)*100}}%</div>
  </div>
  <br>
  <br>
  @foreach($member16_result as $res)
  @if($res->cand_name<>null)
  <span><strong>{{strtoupper($res->cand_name)}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOTES: {{$res->votes}}</strong></span><div class="progress">
    <div class="progress-bar progress-bar-striped" style="width:{{($res->votes/$members16)*100}}%">{{($res->votes/$members16)*100}}%</div>
  </div>
  <br>
  <br>
  @endif
  @endforeach
  
</div>
</div>
</div>


@endsection