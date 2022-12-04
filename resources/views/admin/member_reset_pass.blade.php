
@extends('layouts/main')
@section('content_body')

  <div class="container mp-container">
     <div class="row no-gutters mp-mt5" >
        <div class="col-12 mp-ph2 mp-pv2">
          <a href="{{url('/admin/members')}}" class="mp-link mp-link--accent">
            <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
            <span class="mp-text-fs-large">Back to Members</span>
          </a>
        </div>
      </div>
    <div class="row no-gutters mp-mh4" style="margin-top: 0px!important;">
      <div class="col-lg-6">
        <div class="row no-gutters">
          <div class="col-12 mp-ph2 mp-pv2">
            <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
              <div class="mp-text-no-lh">
                <div class="mp-mb1 mp-text-c-light-gray mp-text-fs-small">Member ID</div>
                <div class="mp-text-fs-large mp-text-fw-heavy">
                  {{ $member->member_no }}
                </div>
              </div>
              <div class="mp-mh2 mp-text-no-lh mp-text-word-wrap mp-dashboard__title">
                {{ $member->last_name }}, {{ $member->first_name}}
              </div>
              <div class="mp-text-no-lh">
                <div class="mp-mb2 mp-text-fs-large">{{ $member->name }}</div>
                <div class="mp-text-fs-large">{{ $member->position_id }}</div>
              </div>

              <br>

              <div class="mp-text-no-lh">
                <div class="mp-mb2 mp-text-fs-large" align="Center">New Password</div>
                <div class="mp-text-fs-xxlarge mp-text-fw-heavy" align="Center" style="font-family: Consolas, Garamond, Comic Sans MS;">{{ $newpass }}</div>
              <br>
              <span style="color:red; font-size:12px;">*Do not refresh the page! It will generate a new password for the member. Just click "Back to Members" or Select a page in the sidebar to navigate away from this page. Make sure you copy the new password before navigating away from this page. </span>
              </div>   
             
           
         
            </div>
          </div>
          
        </div>
      </div>
      
    </div>
  </div>
@endsection

@section('script')

@endsection