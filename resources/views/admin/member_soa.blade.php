
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
           <div class="mp-text-right">

             <strong>Membership Status: </strong>
             @if($member->membership_status=='ACTIVE')
             <span style="color: green"><strong>{{ $member->membership_status }}</strong></span>
             @else
             <span style="color: red"><strong>{{ $member->membership_status }}</strong></span>
             @endif
             <br>
             <a href="{{url('/admin/change_status/'.$member->user_id)}}" class="mp-link mp-link--primary" >Change Membership Status</a> 
             <!-- <a href="{{url('/admin/add_member')}}" class="mp-link mp-link--normal" >Add New Member</a> -->
           </div>
           <div class="mp-mb1 mp-text-c-light-gray mp-text-fs-small">Member ID</div>
           <div class="mp-text-fs-large mp-text-fw-heavy">
            {{ $member->member_no }} 
          </div>
        </div>
        <div class="mp-mh2 mp-text-no-lh mp-text-word-wrap mp-dashboard__title">
          {{ $member->last_name }}, {{ $member->first_name}}
        </div>
        <div class="mp-text-no-lh">
          <div class="mp-mb2 mp-text-fs-large">{{ $member->campus_name }}</div>
          <div class="mp-text-fs-large">{{ $member->position_id }}</div>
        </div>
        
        <div class="mp-mt3">
          <i class="mp-icon icon-user mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>
          
          
          <a  href="{{url('/admin/member_profile/'.$member->user_id)}}" class="mp-link mp-link--primary ">
            Edit Member Details
          </a>
          
        </div>
        <div>
          <i class="mp-icon icon-envelope mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>
          
          
          <a id="email" href="#" class="mp-link mp-link--primary mp-link--editable">
            {{ $member->email }}
          </a> &nbsp;&nbsp;&nbsp;
          <i class="mp-icon icon-phone mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>
          
          
          <a id="contactNo" href="#" class="mp-link mp-link--primary mp-link--editable">
            +63{{ $member->contact_no }}
          </a>
          
        </div>
        
        
        
        
      </div>
    </div>
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
        <div class="mp-mb2 mp-text-fs-medium">
          Your Member's Equity History
        </div>
        <div class="mp-overflow-x">
          <table class="mp-table mp-table--mini">
            <thead>
              <tr>
                <th>Date</th>
                <th>Transaction</th>
                <th>Account</th>
                <th class="mp-text-right">Amount</th>
              </tr>
            </thead>
            <tbody>
             @foreach($recentcontributions as $contribution)
             <tr>
              <td>{{ date("m/d/Y", strtotime($contribution->date)) }}</td>
              <td>{{ $contribution->reference_no }}</td>
              <td>{{ $contribution->name }}</td>
              <td class="mp-text-right">PHP {{ number_format($contribution->amount,2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mp-mt1 mp-text-right">
        <a href="{{url('/admin/member_equity/'.$member->user_id)}}" class="mp-link mp-link--primary }}">
          See All
        </a>
      </div>

      <div class="mp-mt2 mp-mb2 mp-text-fs-medium">
        Your Loan Transactions History
      </div>
      <div class="mp-overflow-x">
        <table class="mp-table mp-table--mini">
          <thead>
            <tr>
              <th>Date</th>
              <th>Account</th>
              <th class="mp-text-center">Monthly Amort.</th>
              <th class="mp-text-center">Amount</th>
              <th class="mp-text-right">Principal Balance</th>
            </tr>
          </thead>
          <tbody>
           <?php $date=""; ?>
           @foreach($recentloans as $loans)
           <?php
           $samedate=true;
           if($date == date("m/d/Y", strtotime($loans->date)) )
           {
            $samedate=false;
          }
          else
          {
            $samedate=true;
          }
          $date=date("m/d/Y", strtotime($loans->date))
          ?>
          <tr>
            <td>{{ date("m/d/Y",strtotime($loans->date)) }}</td>
            <td class="mp-text-center">{{ $loans->name }}</td>
            <td class="mp-text-center">{{  $loans->amortization == 0 ? '' : 'PHP '.number_format($loans->amortization,2) }}</td>
            <td class="mp-text-center">{{ 'PHP '.number_format($loans->amount,2) }}</td>
            <td class="mp-text-right">   {{ !$samedate ? '' :'PHP '.number_format($loans->balance,2) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="mp-mt1 mp-text-right">
      <a href="{{url('/admin/member_loans/'.$member->user_id)}}" class="mp-link mp-link--primary">See All</a>
    </div>
  </div>
</div>
</div>
</div>
<div class="col-lg-6 mp-ph2 mp-pv2">
  <div class="mp-ph4 mp-pv4 mp-card">
    <div class="mp-card__header">
      <div class="mp-text-fs-medium">Statement of Account</div>
      <div class="mp-text-c-light-gray">As of {{ date("m/d/Y") }}</div>
    </div>
    <div class="mp-card__body mp-mh5">
      <div class="mp-mb3 mp-text-fw-heavy">Your Member's Equity</div>
      <div class="row mp-mb2">
        <div class="col">Total Member's Contribution</div>
        <div class="col-md-auto">PHP {{ number_format($contributions['membercontribution'],2) }}</div>
      </div>
      <div class="row mp-mb2">
        <div class="col">Total UP Contribution</div>
        <div class="col-md-auto">PHP {{ number_format($contributions['upcontribution'],2) }}</div>
      </div>
      <div class="row mp-mb2">
        <div class="col">Earnings on Member's Contribution</div>
        <div class="col-md-auto">PHP {{ number_format($contributions['emcontribution'],2) }}</div>
      </div>
      <div class="row mp-mb3">
        <div class="col">Earnings on UP Contribution</div>
        <div class="col-md-auto">PHP {{ number_format($contributions['eupcontribution'],2) }}</div>
      </div>
      <hr>
      <div class="row mp-mt3 mp-mb2">
        <div class="col">Total Equity Balance</div>
        <div class="col-md-auto">PHP {{ number_format($totalcontributions,2) }}</div>
      </div>
      @if(!empty($outstandingloans))
      <div class="mp-mt5 mp-mb3 mp-text-fw-heavy">Your Outstanding Loans</div>
      @foreach($outstandingloans as $oloans)
      <div class="row mp-mb2">
        <div class="col">{{ $oloans->type }}</div>
        <div class="col-md-auto">PHP {{ number_format($oloans->balance,2) }}</div>
      </div>
      @endforeach
      <hr class="mp-mt3">
      <div class="row mp-mt3 mp-mb2">
        <div class="col">Total Outstanding Loan Balance</div>
        <div class="col-md-auto">PHP {{ number_format($totalloanbalance,2) }}</div>
      </div>
      @endif
    </div>
    <div class="mp-card__footer mp-text-right">
      <a href="{{url('/admin/generate/soa/'.$member->user_id)}}" target="_blank" class="mp-link mp-link--primary">
        Download PDF
      </a>
    </div>
  </div>
</div>
</div>
</div>
@endsection

@section('script')

@endsection