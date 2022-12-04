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
                 <div class="mp-card__body mp-text-fs-medium">
                 Manila - {{$manila}}
                </div>
                 <div class="mp-card__body mp-text-fs-medium">
                 PGH - {{$pgh}}
                </div>
                <div class="mp-card__body mp-text-fs-xlarge">
               
                </div>
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
                 Total - {{$totalvoted}}
                </div>
                <br>
                 <div class="mp-card__body mp-text-fs-medium">
                 Manila - {{$manilavoted}}
                </div>
                 <div class="mp-card__body mp-text-fs-medium">
                 PGH - {{$pghvoted}}
                </div>
                <div class="mp-card__body mp-text-fs-xlarge">
               
                </div>
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
                 Total - {{$totalnotvoted}}
                </div>
                <br>
                 <div class="mp-card__body mp-text-fs-medium">
                 Manila - {{$manilanotvoted}}
                </div>
                 <div class="mp-card__body mp-text-fs-medium">
                 PGH - {{$pghnotvoted}}
                </div>
                <div class="mp-card__body mp-text-fs-xlarge">
               
                </div>
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
                  Total Voters: {{$manila15tot+$pgh15tot}}
                    <br>
                  Manila Votes: {{$manila15}}
                    <br>
                  PGH Votes: {{$pgh15}}
                </div>
       <div style="padding: 10px">
         <br>
   
      @foreach($results15 as $res)
       <span><strong>{{strtoupper($res->vote_casted)}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOTES: {{$res->count}}</strong></span><div class="progress">
  <div class="progress-bar progress-bar-striped" style="width:{{($res->count/($manila15+$pgh15))*100}}%">{{($res->count/($manila15+$pgh15))*100}}%</div>
</div>
    <br>
     <br>
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
                  Total Voters: {{$manila16tot+$pgh16tot}}
                    <br>
                  Manila Votes: {{$manila16}}
                    <br>
                  PGH Votes: {{$pgh16}}
                </div>
       <div style="padding: 10px">
         <br>
    @foreach($results16 as $res)
       <span><strong>{{strtoupper($res->vote_casted)}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;VOTES: {{$res->count}}</strong></span><div class="progress">
  <div class="progress-bar progress-bar-striped" style="width:{{($res->count/($manila16+$pgh16))*100}}%">{{($res->count/($manila16+$pgh16))*100}}%</div>
</div>
    <br>
     <br>
     @endforeach
   
    </div>
       </div>
      </div>
    

@endsection