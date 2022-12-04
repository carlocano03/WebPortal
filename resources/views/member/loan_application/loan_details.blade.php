@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">

  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 mp-ph2 mp-pv2" style="padding-bottom: 0px!important;">
      <a href="{{url('/member/loan-app')}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Loan Application</span>
      </a>
    </div>
    <div class="col-12  mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">
       Loan Details
     </div>
   </div>
 </div>
 <div class="row no-gutters mp-mb4 justify-content-center">
  <div class="col-12 mp-ph2 mp-pv2">
    <div class="mp-ph4 mp-pv4 mp-card mp-card--plain" align='center'>
      @if($loan_details->type=='NEW')
      <div  class='col-12'>
        <br>
        <div align="center" class="mp-text-fs-large mp-text-fw-heavy">

          <strong>APPLICATION TYPE: <span>NEW</span></strong>  

        </div>
        <br>
        <div class="row mp-mb2">
          <div class="col mp-text-fw-heavy" align="left" >Current Status:</div>
          @if($loan->status=="SUBMITTED")
          <div class="col-md-auto"  style="color:#feb236; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
          @endif
          @if($loan->status=="PROCESSING")
          <div class="col-md-auto"  style="color:#82b74b; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
          @endif
          @if($loan->status=="DONE")
          <div class="col-md-auto"  style="color:#034f84; text-align: center!important; width:300px;"><strong>FOR MEMBER CONFIRMATION</strong></div>
          @endif
          @if($loan->status=="CANCELLED")
          <div class="col-md-auto"  style="color:#d64161; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
          @endif
          @if($loan->status=="CONFIRMED")
          <div class="col-md-auto"  style="color:#894168; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
          @endif
          <div class="col mp-text-fw-heavy" align="left" >Member No.:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;"><strong>{{$loan->member_no}}</strong></div>
        </div>

        <div class="row mp-mb2">
          <div class="col mp-text-fw-heavy" align="left" >Loan Type:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;">{{$loan->description}}</div>
          <div class="col mp-text-fw-heavy" align="left" >Date Submitted:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y h:i A", strtotime($loan->date_created))}}</div>
        </div>

        <div class="row mp-mb2">
          <div class="col mp-text-fw-heavy" align="left" >Loan Application No.:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;">{{$loan->control_number}}</div>
          <div class="col mp-text-fw-heavy" align="left" >&nbsp;</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;">&nbsp;</div>
        </div>

        <br>
        <hr style="background-color: #b4b3b3;" >
        <br>
        <div class="row mp-mb2">
          <div class="col mp-text-fw-heavy" align="left" >Bank:</div>
          @if($loan_details->bank=='LB')
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >LANDBANK</div>
          @endif
          @if($loan_details->bank=='PNB')
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHILIPPINE NATIONAL BANK</div>
          @endif

          @if($loan_details->bank=='DBP')
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >DEVELOPMENT BANK OF THE PHILIPPINES</div>
          @endif

          @if($loan_details->bank=='Veterans')
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHILIPPINE VETERANS BANK</div>
          @endif

          <div class="col mp-text-fw-heavy" align="left" >Account Number:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->account_number}}</div>
        </div>

        <div class="row mp-mb2">
          <div class="col mp-text-fw-heavy" align="left" >Account Name:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->account_name}}</div>
          <div class="col mp-text-fw-heavy" align="left" >Amount:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan_details->amount,2) }}</div>
        </div>

        <div class="row mp-mb2">
          <div class="col mp-text-fw-heavy" align="left" >Active Email:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan->active_email}}</div>
          <div class="col mp-text-fw-heavy" align="left" >Active Mobile Number:</div>
          <div class="col-md-auto" style="width:300px;text-align: center!important;" >+63{{$loan->active_number}}</div>
        </div>

        <br>
        <br>

        <div align="center" class="mp-text-fs-large mp-text-fw-heavy">
          <strong>ATTACHMENTS</strong>          
        </div>
        <br>

        <label class="col-6" for="album_cover">ID:
        </label>
        <br>
        @if($loan_details->p_id)
        <?php
        $file=explode(".",$loan_details->p_id);
        $file_ex=$file[1];
        ?>
        <a href="{{ asset('storage/app/loan_application/'.$loan_details->p_id) }}" target="_blank">
          @if($file_ex=='pdf' || $file_ex=='PDF')
          VIEW PDF
          @else
          <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->p_id) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
          @endif
        </a>
        @else
        <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
        @endif
        <br>

        <br>

        <label class="col-6" for="album_cover">Payslip 1:
        </label>
        <br>
        @if($loan_details->payslip_1)
        <?php
        $file=explode(".",$loan_details->payslip_1);
        $file_ex=$file[1];
        ?>
        <a href="{{ asset('storage/app/loan_application/'.$loan_details->payslip_1) }}" target="_blank">
         @if($file_ex=='pdf' || $file_ex=='PDF')
         VIEW PDF
         @else
         <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->payslip_1) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
         @endif
       </a>
       @else
       <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
       @endif
       <br>
       <br>

       <label class="col-6" for="album_cover">Payslip 2:
       </label>
       <br>
       @if($loan_details->payslip_2)
       <?php
       $file=explode(".",$loan_details->payslip_2);
       $file_ex=$file[1];
       ?>
       <a href="{{ asset('storage/app/loan_application/'.$loan_details->payslip_2) }}" target="_blank">
         @if($file_ex=='pdf' || $file_ex=='PDF')
         VIEW PDF
         @else
         <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->payslip_2) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
         @endif
       </a>
       @else
       <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
       @endif
       <br>
       <br>

       <label class="col-6" for="album_cover">Proof of Account Number:
       </label>
       <br>
       @if($loan_details->atm_passbook)
       <?php
       $file=explode(".",$loan_details->atm_passbook);
       $file_ex=$file[1];
       ?>
       <a href="{{ asset('storage/app/loan_application/'.$loan_details->atm_passbook) }}" target="_blank">
        @if($file_ex=='pdf' || $file_ex=='PDF')
        VIEW PDF
        @else
        <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->atm_passbook) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
        @endif
      </a>
      @else
      <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
      @endif
      <br>
      <br>
      <hr style="background-color: #b4b3b3;" >
      <br>

      @if($loan->status == 'DONE')
      <div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
        <strong>LOAN APPROVAL</strong>          
      </div>
      <br>
      <div class="row mp-mb2">
        <div class="col mp-text-fw-heavy"  align="left">Approved Loan Amount:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->approved_amount,2) }}</div>
        <div class="col mp-text-fw-heavy"  align="left">LESS:</div>
        <div class="" style="width:300px;text-align: left!important; font-size: 13px;">
         @if($loan_ded)
         @foreach($loan_ded as $l)
         {{$l->description}}&nbsp; - PHP &nbsp;{{number_format($l->amount,2)}}
         <br>
         @endforeach
         @endif
       </div>
     </div>

     <div class="row mp-mb2">
      <div class="col mp-text-fw-heavy"  align="left">Monthly Amortization:</div>
      <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->monthly_amort,2) }}</div>
      <div class="col mp-text-fw-heavy"  align="left">Net Proceeds:</div>
      <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->net_proceeds,2) }}</div>
    </div>

    <div class="row mp-mb2">
      <div class="col mp-text-fw-heavy"  align="left">Collection Period:</div>
      <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/Y", strtotime($loan->collect_from))}} to {{date("m/Y", strtotime($loan->collect_to))}}</div>
      <div class="col mp-text-fw-heavy"  align="left">Expected Crediting Day:</div>
      <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y", strtotime($loan->crediting_date))}}</div>
    </div>
    <br>
    <strong>AGREEMENT</strong>
    <br>
    <br>
    <div style="text-align:justify;">

      I acknowledge receipt of a copy of this loan computation and that I fully understand and agree to the terms and conditions of my loan.
      <br>
      <br>
      I authorize the UP Provident Fund, Inc. (UPPFI) to obtain access of my payroll information from the UP Accounting Office only for the purpose of verifying my creditworthiness and paying capacity related to this loan.
      <br>
      <br>
      I also authorize UPPFI to credit the bank account number I have written above for the net proceeds of this loan. I am holding UPPFI free from any liability and/or damages that may happen arising from this authorization, related to incorrect information that I will provide, negligence on my part, fraud conducted by a third party, or similar instances.
      <br>
      <br>
      I authorize the UP Payroll Division to deduct from my salaries, emoluments and other benefits, dues and loan amortizations owing to the UPPFI before any and all deductions owing to third parties, except those deductions owing to government agencies and/or other deductions mandated by existing laws.          
      <br>
      <br>           
      I understand and agree that failure to pay the required monthly amortization after 3 months is considered delinquent and my loan will be subject to surcharge of 1/2 of 1% per month, compounded monthly. I also hereby authorize UPPFI to offset my outstanding loan balance (including all interests and surcharges) against my Equity in UPPFI (starting from earnings and member's contributions, in this order of application) one (1) year from the date of default.
    </div>
    <br>
    <br>
    <div class="mp-text-fs-medium mp-text-center">
     <button type="button" class="mp-button mp-button--accent" id="button_new_agree">AGREE</button>
     <a id="new_agree" href="{{url('/member/confirm_agree/'.$loan->id)}}" style="visibility: hidden"></a>
     <button type="button" class="mp-button mp-button--primary" id="button_new_cancel">CANCEL APPLICATION</button>
     <a id="new_cancel" href="{{url('/member/app_cancel/'.$loan->id)}}" style="visibility: hidden"></a>
   </div>

   @elseif($loan->status == 'CANCELLED')
   <div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
    <strong>REASON FOR CANCELLATION</strong>          
  </div>
  <br>

  <div class="mp-text-fs-medium" style="text-align: center!important;">
    {{ $loan->cancellation_reason }}

  </div>
  @elseif($loan->status == 'CONFIRMED')
  <div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
    <strong>CONFIRMED LOAN</strong>          
  </div>
  <br>
  <div class="row mp-mb2">
    <div class="col mp-text-fw-heavy"  align="left">Approved Loan Amount:</div>
    <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->approved_amount,2) }}</div>
    <div class="col mp-text-fw-heavy"  align="left">LESS:</div>
    <div class="" style="width:300px;text-align: left!important; font-size: 13px;">
     @if($loan_ded)
     @foreach($loan_ded as $l)
     {{$l->description}}&nbsp; - PHP &nbsp;{{number_format(abs($l->amount),2)}}
     <br>
     @endforeach
     @endif
   </div>
 </div>

 <div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Monthly Amortization:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->monthly_amort,2) }}</div>
  <div class="col mp-text-fw-heavy"  align="left">Net Proceeds:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->net_proceeds,2) }}</div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Collection Period:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/Y", strtotime($loan->collect_from))}} to {{date("m/Y", strtotime($loan->collect_to))}}</div>
  <div class="col mp-text-fw-heavy"  align="left">Expected Crediting Day:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y", strtotime($loan->crediting_date))}}</div>
</div>
<br>

@endif
<br>






</div>

@elseif($loan_details->type=='RENEW')
<div  class='col-12'>
 <br>
 <div align="center" class="mp-text-fs-large mp-text-fw-heavy">
  <strong>APPLICATION TYPE: <span>RENEWAL</span></strong>          
</div>
<br>
<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy" align="left" >Current Status:</div>
  @if($loan->status=="SUBMITTED")
  <div class="col-md-auto"  style="color:#feb236; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
  @endif
  @if($loan->status=="PROCESSING")
  <div class="col-md-auto"  style="color:#82b74b; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
  @endif
  @if($loan->status=="DONE")
  <div class="col-md-auto"  style="color:#034f84; text-align: center!important; width:300px;"><strong>FOR MEMBER CONFIRMATION</strong></div>
  @endif
  @if($loan->status=="CANCELLED")
  <div class="col-md-auto"  style="color:#d64161; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
  @endif
  @if($loan->status=="CONFIRMED")
  <div class="col-md-auto"  style="color:#894168; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
  @endif
  <div class="col mp-text-fw-heavy" align="left" >Member No.:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;"><strong>{{$loan->member_no}}</strong></div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy" align="left" >Loan Type:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{$loan->description}}</div>
  <div class="col mp-text-fw-heavy" align="left" >Date Submitted:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y h:i A", strtotime($loan->date_created))}}</div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy" align="left" >Loan Application No.:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{$loan->control_number}}</div>
  <div class="col mp-text-fw-heavy" align="left" >&nbsp;</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">&nbsp;</div>
</div>

<br>
<hr style="background-color: #b4b3b3;" >
<br>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy" align="left" >Bank:</div>
  @if($loan_details->bank=='LB')
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >LANDBANK</div>
  @endif
  @if($loan_details->bank=='PNB')
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHILIPPINE NATIONAL BANK</div>
  @endif

  @if($loan_details->bank=='DBP')
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >DEVELOPMENT BANK OF THE PHILIPPINES</div>
  @endif

  @if($loan_details->bank=='Veterans')
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHILIPPINE VETERANS BANK</div>
  @endif

  <div class="col mp-text-fw-heavy" align="left" >Account Number:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->account_number}}</div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy" align="left" >Account Name:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->account_name}}</div>
  <div class="col mp-text-fw-heavy" align="left" >Renewal Type:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->renewal_type}}</div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy" align="left" >Active Email:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan->active_email}}</div>
  <div class="col mp-text-fw-heavy" align="left" >Active Mobile Number:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;" >+63{{$loan->active_number}}</div>
</div>





<br>
<br>

<div align="center" class="mp-text-fs-large mp-text-fw-heavy">
  <strong>ATTACHMENTS</strong>          
</div>
<br>

<label class="col-6" for="album_cover">ID:
</label>
<br>
@if($loan_details->p_id)
<?php
$file=explode(".",$loan_details->p_id);
$file_ex=$file[1];
?>
<a href="{{ asset('storage/app/loan_application/'.$loan_details->p_id) }}" target="_blank">
  @if($file_ex=='pdf' || $file_ex=='PDF')
  VIEW PDF
  @else
  <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->p_id) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
  @endif
</a>
@else
<img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
@endif
<br>

<br>

<label class="col-6" for="album_cover">Payslip 1:
</label>
<br>
@if($loan_details->payslip_1)
<?php
$file=explode(".",$loan_details->payslip_1);
$file_ex=$file[1];
?>
<a href="{{ asset('storage/app/loan_application/'.$loan_details->payslip_1) }}" target="_blank">
 @if($file_ex=='pdf' || $file_ex=='PDF')
 VIEW PDF
 @else
 <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->payslip_1) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
 @endif
</a>
@else
<img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
@endif
<br>
<br>

<label class="col-6" for="album_cover">Payslip 2:
</label>
<br>
@if($loan_details->payslip_2)
<?php
$file=explode(".",$loan_details->payslip_2);
$file_ex=$file[1];
?>
<a href="{{ asset('storage/app/loan_application/'.$loan_details->payslip_2) }}" target="_blank">
 @if($file_ex=='pdf' || $file_ex=='PDF')
 VIEW PDF
 @else
 <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->payslip_2) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
 @endif
</a>
@else
<img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
@endif
<br>
<br>

<label class="col-6" for="album_cover">Proof of Account Number:
</label>
<br>
@if($loan_details->atm_passbook)
<?php
$file=explode(".",$loan_details->atm_passbook);
$file_ex=$file[1];
?>
<a href="{{ asset('storage/app/loan_application/'.$loan_details->atm_passbook) }}" target="_blank">
  @if($file_ex=='pdf' || $file_ex=='PDF')
  VIEW PDF
  @else
  <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->atm_passbook) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
  @endif
</a>
@else
<img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
@endif
<br>
<br>
<hr style="background-color: #b4b3b3;" >
<br>
@if($loan->status == 'DONE')
<div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
  <strong>LOAN APPROVAL</strong>          
</div>
<br>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Approved Loan Amount:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->approved_amount,2) }}</div>
  <div class="col mp-text-fw-heavy"  align="left">LESS:</div>
  <div class="" style="width:300px;text-align: left!important; font-size: 13px;">
   @if($loan_ded)
   @foreach($loan_ded as $l)
   {{$l->description}}&nbsp; - PHP &nbsp;{{number_format($l->amount,2)}}
   <br>
   @endforeach
   @endif
 </div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Monthly Amortization:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->monthly_amort,2) }}</div>
  <div class="col mp-text-fw-heavy"  align="left">Net Proceeds:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->net_proceeds,2) }}</div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Collection Period:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/Y", strtotime($loan->collect_from))}} to {{date("m/Y", strtotime($loan->collect_to))}}</div>
  <div class="col mp-text-fw-heavy"  align="left">Expected Crediting Day:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y", strtotime($loan->crediting_date))}}</div>
</div>

<br>
<strong>AGREEMENT</strong>
<br>
<br>
<div style="text-align:justify;">

  I acknowledge receipt of a copy of this loan computation and that I fully understand and agree to the terms and conditions of my loan.
  <br>
  <br>
  I authorize the UP Provident Fund, Inc. (UPPFI) to obtain access of my payroll information from the UP Accounting Office only for the purpose of verifying my creditworthiness and paying capacity related to this loan.
  <br>
  <br>
  I also authorize UPPFI to credit the bank account number I have written above for the net proceeds of this loan. I am holding UPPFI free from any liability and/or damages that may happen arising from this authorization, related to incorrect information that I will provide, negligence on my part, fraud conducted by a third party, or similar instances.
  <br>
  <br>
  I authorize the UP Payroll Division to deduct from my salaries, emoluments and other benefits, dues and loan amortizations owing to the UPPFI before any and all deductions owing to third parties, except those deductions owing to government agencies and/or other deductions mandated by existing laws.          
  <br>
  <br>           
  I understand and agree that failure to pay the required monthly amortization after 3 months is considered delinquent and my loan will be subject to surcharge of 1/2 of 1% per month, compounded monthly. I also hereby authorize UPPFI to offset my outstanding loan balance (including all interests and surcharges) against my Equity in UPPFI (starting from earnings and member's contributions, in this order of application) one (1) year from the date of default.
</div>
<br>
<br>
<div class="mp-text-fs-medium mp-text-center">
 <button type="button" class="mp-button mp-button--accent" id="button_renew_agree">AGREE</button>
 <a id="renew_agree" href="{{url('/member/confirm_agree/'.$loan->id)}}" style="visibility: hidden"></a>
 <button type="button" class="mp-button mp-button--primary" id="button_renew_cancel">CANCEL APPLICATION</button>
 <a id="renew_cancel" href="{{url('/member/app_cancel/'.$loan->id)}}" style="visibility: hidden"></a>
</div>

@elseif($loan->status == 'CANCELLED')
<div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
  <strong>REASON FOR CANCELLATION</strong>          
</div>
<br>

<div class="mp-text-fs-medium" style="text-align: center!important;">
  {{ $loan->cancellation_reason }}

</div>

</div>
@elseif($loan->status == 'CONFIRMED')
<div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
  <strong>CONFIRMED LOAN</strong>          
</div>
<br>
<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Approved Loan Amount:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->approved_amount,2) }}</div>
  <div class="col mp-text-fw-heavy"  align="left">LESS:</div>
  <div class="" style="width:300px;text-align: left!important; font-size: 13px;">
   @if($loan_ded)
   @foreach($loan_ded as $l)
   {{$l->description}}&nbsp; - PHP &nbsp;{{number_format(abs($l->amount),2)}}
   <br>
   @endforeach
   @endif
 </div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Monthly Amortization:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->monthly_amort,2) }}</div>
  <div class="col mp-text-fw-heavy"  align="left">Net Proceeds:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan->net_proceeds,2) }}</div>
</div>

<div class="row mp-mb2">
  <div class="col mp-text-fw-heavy"  align="left">Collection Period:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/Y", strtotime($loan->collect_from))}} to {{date("m/Y", strtotime($loan->collect_to))}}</div>
  <div class="col mp-text-fw-heavy"  align="left">Expected Crediting Day:</div>
  <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y", strtotime($loan->crediting_date))}}</div>
</div>
<br>
@endif
<br>


</div>

@endif








</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
  $(document).ready(function(){

    $('#button_new_agree').on('click',function(e){

    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you agree?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Agree',
      cancelButtonText: 'Go Back',
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#new_agree')[0].click();

      }
    })

  });

    $('#button_renew_agree').on('click',function(e){

    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you agree?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Agree',
      cancelButtonText: 'Go Back',
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#renew_agree')[0].click();

      }
    })

  });

    $('#button_new_cancel').on('click',function(e){

    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to cancel this application?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'Go Back',
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#new_cancel')[0].click();

      }
    })

  });

    $('#button_renew_cancel').on('click',function(e){

    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to cancel this application?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'Go Back',
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#renew_cancel')[0].click();

      }
    })

  });
  });

</script>