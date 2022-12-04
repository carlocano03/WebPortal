
@extends('layouts/main')
@section('content_body')
<div class="container mp-container">

  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary">
      <a class="mp-link mp-link--accent" href="{{url('/admin/members')}}">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        Back to Members
      </a>
    </div>
  </div>

  <div class="row no-gutters">
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
              <div class="mp-mb2 mp-text-fs-large">{{ $member->campus_name }}</div>
              <div class="mp-text-fs-large">{{ $member->position_id }}</div>
            </div>
            <!-- <div class="mp-mt3">
              <i class="mp-icon icon-envelope mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>


              <a id="email" href="#" class="mp-link mp-link--primary mp-link--editable">
                {{ $member->email }}
              </a>

            </div>
            <div>
              <i class="mp-icon icon-phone mp-mr1 mp-text-fs-medium mp-text-c-primary"></i>


              <a id="contactNo" href="#" class="mp-link mp-link--primary mp-link--editable">
                +63{{ $member->contact_no }}
              </a>

            </div> -->

          </div>
        </div>
        <div class="col-12 mp-ph2 mp-pv2">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--plain" >
            <div class="mp-mb2 mp-text-fs-medium">
              Beneficiaries
            </div>
            <div class="mp-overflow-x">
              <table class="mp-table mp-table--mini">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Birth Date</th>
                    <th>Relationship to Member</th>
                  </tr>
                </thead>
                <tbody>
                  @if($beneficiaries)
                  @foreach($beneficiaries as $bene)
                  <tr>
                    <td>{{ $bene->beni_name }}</td>
                    <td>{{ $bene->birth_date }}</td>
                    <td>{{ $bene->relationship }}</td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          <!--   <div class="mp-mt1 mp-text-right">
              <a href="{{url('/member/equity')}}" class="mp-link mp-link--primary }}">
                See All
              </a>
            </div> -->

            <!-- <div class="mp-mt2 mp-mb2 mp-text-fs-medium">
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

                </tbody>
              </table>
            </div> -->
            <div class="mp-mt1 mp-text-right">
              <a href="{{url('/admin/member_edit_beneficiaries/'.$member->user_id)}}" class="mp-link mp-link--primary">Edit</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mp-ph2 mp-pv2">
      <div class="mp-ph4 mp-pv4 mp-card">
        <div class="mp-card__header" style="padding-bottom: 10px!important; margin-bottom:10px!important">
          <div class="mp-text-fs-medium">Member's Details</div>
          <div class="">
            <span style="font-size:10px; color:red">*Warning! Using this function will auto generate temporary password for member. Please double check if the member you want to reset password is correct.</span>
            <a href="{{url('/admin/resetpass/'.$member->user_id)}}" class="mp-link mp-link--normal mp-text-fs-small" >Reset Password</a>
          </div>
          <!--   <div class="mp-text-c-light-gray">As of {{ date("m/d/Y") }}</div> -->
        </div>
        <div class="mp-card__body mp-mh5" style="padding-top: 0px!important; margin-top:0px!important" >
          <!--   <div class="mp-mb3 mp-text-fw-heavy">Your Member's Equity</div> -->
          
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Cellphone Number:</div>
            <div class="col-md-auto">+63{{ $member->contact_no }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Landline Number:</div>
            <div class="col-md-auto">{{ $details ? $details->landline:'' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Gender:</div>
            <div class="col-md-auto">{{  $details ? $details->gender : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Employee no:</div>
            <div class="col-md-auto">{{  $details ? $details->employee_no : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Original Appointment Date:</div>
            <div class="col-md-auto">{{   $member ? date('m/d/Y', strtotime($member->original_appointment_date)): '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Status of Appointment:</div>
            <div class="col-md-auto">{{  $details ? $details->appointment_status : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">TIN:</div>
            <div class="col-md-auto">{{  $details ? $details->tin : '' }}</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Permanent Address:</div>
            <div class="col-md-auto"  style="width:100%">{{  $details ? $details->permanent_address : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Current Address:</div>
            <div class="col-md-auto"  style="width:100%" >{{  $details ? $details->current_address : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Birthdate:</div>
            <div class="col-md-auto">{{  $details ? $details->birth_date : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Email:</div>
            <div class="col-md-auto" >{{ $member->email }}</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Salary Grade:</div>
            <div class="col-md-auto">{{  $details ? $details->salary_grade : '' }}</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Monthly Salary:</div>
            <div class="col-md-auto">PHP {{  $details ? number_format($details->monthly_salary,2) : '0.00' }}</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Civil Status:</div>
            <div class="col-md-auto">{{  $details ? $details->civil_status : '' }}</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Member Contribution Type:</div>
            <div class="col-md-auto">{{  $details ? strtoupper($details->contribution_type) : '' }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Member Monthly Contribution:</div>
            <div class="col-md-auto">{{  isset($details)  ? $details->contribution_type=='FIXED' ? 'PHP '.number_format($details->contribution,2) : intval($details->contribution).'%'  : ''  }}</div>
          </div>
          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Cocolife Form:</div>
            <div class="col-md-auto">{{  $details ? $details->with_cocolife_form == 1 ? 'YES': 'NO' : '' }}</div>
          </div>

          <div class="row mp-mb2">
            <div class="col mp-text-fw-heavy">Proxy Form Validity:</div>
            <div class="col-md-auto">{{  $details ? $details->validity <> "" ? $details->validity: 'Not submitted' : '' }}</div>
          </div>



        </div>
        <div class="mp-card__footer mp-text-right">
          <a href="{{url('/admin/member_edit_details/'.$member->user_id)}}" class="mp-link mp-link--primary">
            Edit
          </a>
        </div>
      </div>
    </div>


  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/dist/dashboard.js') }}"></script>   
@endsection