@extends('layouts/main')
@section('content_body')
  <div class="container mp-container">
    <div class="row no-gutters mp-mt4">
      <div class="col mp-ph2 mp-pv2">
        <div class="mp-card mp-card--plain mp-pv4">
          <div class="row align-items-center">
            <div class="col-lg-4">
              <div id="campusSelector" class="mp-dropdown mp-ph3">
                <a href="#" class="mp-dropdown__toggle mp-link mp-link--accent">
                  <span class="mp-text-fs-xxlarge">
                    @if(getUserdetails()->role=='SUPER_ADMIN')
                    @if(isset($_GET['campus_id']))
                    {{$activecampus->name}}
                    @else
                    All UP Campuses
                    @endif
                    @else
                      @if(isset($_GET['campus_id']))
                    {{$activecampus->name}}
                    @else
                    {{$campuses[0]->name}}
                    @endif
                    @endif
                  </span>
                  <i class="mp-icon icon-arrow-down mp-ml2"></i>
                </a>
                <div class="mp-dropdown__menu">
                @if(getUserdetails()->role=='SUPER_ADMIN')
                    <a href="{{url('/admin/dashboard')}}" class="mp-dropdown__item mp-link mp-link--normal">All UP Campuses</a>
                @endif
                 @foreach($campuses as $campus)
                    <a href="{{url('/admin/dashboard')}}?campus_id={{$campus->id}}" class="mp-dropdown__item mp-link mp-link--normal">
                      {{$campus->name}}
                    </a>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="mp-text-c-gray mp-text-fs-small mp-pt3">
                Total Members
              </div>
              <div class="row align-items-center mp-pb3">
                <div class="col">
                  <span class="mp-mr2 mp-dashboard__icon">@include('layouts.icons.i-members')</span>
                  <span class="mp-text-fs-xlarge">{{ $totalmembers }}</span>
                </div>
                <div class="col-auto col-lg-12 col-xl-auto mp-text-right">
                  <a href="{{url('/admin/members')}}" class="mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small">
                    View All Members
                  </a>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="mp-text-c-gray mp-text-fs-small mp-pt3">
                Total Loans Granted
                {{ $totalloansgranted >= 1000000 ? '(in million Pesos)' : '' }}
              </div>
              <div class="row align-items-center mp-pb3">
                <div class="col">
                  <span class="mp-mr2 mp-dashboard__icon">@include('layouts.icons.i-loans')</span>
                  <span class="mp-text-fs-xlarge">
                    {{ $totalloansgranted >= 1000000 ? number_format(($totalloansgranted/1000000),2): number_format($totalloansgranted,2)}}
                  </span>
                </div>
                <div class="col-auto col-lg-12 col-xl-auto mp-text-right">
                  <a href="{{url('/admin/loans')}}" class="mp-button mp-button--primary mp-button--ghost mp-button--raised mp-button--mini mp-text-fs-small">
                    View All Loans
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row no-gutters mp-mb4">
     @if(getUserdetails()->role=='SUPER_ADMIN')
        <div class="col-lg-4 mp-ph2 mp-pv2">
          <div class="mp-card mp-ph4 mp-pv4">
            <div class="mp-card__header">
              <div class="row">
                <div class="col mp-text-c-gray mp-text-fs-small">
                  Members per Campus
                </div>
                <div class="col-auto mp-dashboard__icon mp-dashboard__icon--2x">
                  @include('layouts.icons.i-members')
                </div>
              </div>
            </div>
            <div class="mp-card__body mp-text-fs-medium mp-pt3">
              @foreach($campusmembers as $member)
                <div class="row mp-mt1">
                  <div class="col mp-text-c-gray">{{ $member->name }}</div>
                  <div class="col-sm-auto mp-text-c-gray">{{ $member->count }}</div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @endif
      <div class="{{ getUserdetails()->role=='SUPER_ADMIN' ? 'col-lg-8' : 'col-12' }}">
       
        <div class="row no-gutters">
         @foreach($contributions as $contri)
            <div class="col-md-6 {{ getUserdetails()->role=='SUPER_ADMIN' ? '' : 'col-lg-4' }} mp-ph2 mp-pv2">
              <div class="mp-card mp-ph3 mp-pv3">
                <div class="mp-text-c-gray mp-text-fs-small">
                  @if($contri->account_id==1)
                  Total UP Contribution
                  @endif
                  @if($contri->account_id==2)
                  Total Member Contribution
                  @endif
                  @if($contri->account_id==3)
                  Earnings on UP Contributions
                  @endif
                  @if($contri->account_id==4)
                  Earnings on Member Contributions
                  @endif
                </div>
                <div class="mp-card__body mp-text-fs-xlarge">
                 PHP {{number_format($contri->amount,2)}}
                </div>
                <div class="mp-text-right mp-dashboard__icon mp-dashboard__icon--2x">
                 @include('layouts.icons.i-loans')
                </div>
              </div>
            </div>
          @endforeach
           <div class="col-md-6 {{ getUserdetails()->role=='SUPER_ADMIN' ? '' : 'col-lg-4' }} mp-ph2 mp-pv2">
              <div class="mp-card mp-ph3 mp-pv3">
                <div class="mp-text-c-gray mp-text-fs-small">
                  Total Members' Outstanding Loans 
                </div>
                <div class="mp-card__body mp-text-fs-xlarge">
                 PHP {{number_format($totalloansgranted,2)}}
                </div>
                <div class="mp-text-right mp-dashboard__icon mp-dashboard__icon--2x">
                 @include('layouts.icons.i-loans')
                </div>
              </div>
            </div>
            <div class="col-md-6 {{ getUserdetails()->role=='SUPER_ADMIN' ? '' : 'col-lg-4' }} mp-ph2 mp-pv2">
              <div class="mp-card mp-ph3 mp-pv3">
                <div class="mp-text-c-gray mp-text-fs-small">
                  Total Members' Equity
                </div>
                <div class="mp-card__body mp-text-fs-xlarge">
                 PHP {{number_format($totalequity,2)}}
                </div>
                <div class="mp-text-right mp-dashboard__icon mp-dashboard__icon--2x">
                 @include('layouts.icons.i-loans')
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script src="{{ asset('/dist/adminDashboard.js') }}"></script>   
@endsection


