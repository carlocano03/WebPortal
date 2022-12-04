 
<link href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@700&display=swap" rel="stylesheet">

<style type="text/css">
/* fira-sans-regular - latin */


table {
  border-collapse: collapse;
}
div {
  color: #414042!important;
  font-family: 'Fira Sans', sans-serif;
  font-size: 15px;
}
tr {
  color: #636569!important;
  font-family: 'Fira Sans', sans-serif;
  font-size: 15px;
}
strong{
 font-family: 'Fira Sans', sans-serif;

}

.page-break {
  page-break-after: always;
}

</style>

<div class="" align="center">

  <img src="{!! asset('assets/images/loan_info_logo.png') !!}" width="40%" alt="UPPFI">


</div>
<br>
<div class="">
  <div align="center" class="">
    <div class="" style="color: #414042!important;  font-size: 18px;">
     <strong> LOAN INFORMATION SLIP </strong>
   </div>
 </div>

 <br>
 <div align="right" class="">
  <div class="" style="color: #414042!important; font-size: 16px; ">
    <strong>DATE FILED:</strong> {{ date("m/d/Y h:i A", strtotime($loan->date_created)) }}
  </div>
</div>

<br>

<div align="left" class="">
 <div class="" style="color: #414042!important;   font-size: 16px; ">
  <strong>MEMBER DETAILS</strong> 
</div>
<br>
<div class="" style="color: #414042!important;   font-size: 14px; ">
  <strong>Name:</strong> {{ $loan->last_name }}, {{ $loan->first_name }} {{ $loan->middle_name }}
</div>

<div class="" style="color: #414042!important;   font-size: 14px; ">
  <strong>UPPFI Member's ID No.:</strong> {{ $loan->member_no }}
</div>

<div class="" style="color: #414042!important;   font-size: 14px; ">
  <strong>Campus:</strong> {{ $loan->campus_key }}
</div>
<div class="" style="color: #414042!important;   font-size: 14px; ">
 <strong>Unit:</strong> {{$loan->unit_dept}}
</div>

<div class="" style="color: #414042!important;   font-size: 14px; ">
  <strong>Employee No.:</strong> {{ $loan->employee_no }}
</div>

<div class="" style="color: #414042!important;   font-size: 14px; ">
  <strong>Active Mobile Number:</strong> +63{{$loan->active_number}}
</div>

<div class="" style="color: #414042!important;   font-size: 14px; ">
  <strong>Active Email Address:</strong> {{$loan->active_email}}
</div>
</div>


<br>

<div align="left" class="">
  <div class="" style="color: #414042!important;   font-size: 16px; ">
    <strong>LOAN DETAILS</strong> 
  </div>
  <br>
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Loan Application No.:</strong> {{$loan->control_number}}
  </div>
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Loan Type:</strong> {{$loan->loan}}
  </div>
  @if($loan->loan=='Personal Equity Loan')
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>New or Renewal:</strong> {{$loan->type}}
  </div>
  @endif
  @if($loan->type=='RENEW')
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Renewal Type:</strong> {{$loan->renewal_type}}
  </div>
  @else
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Loan Amount Requested:</strong> PHP {{number_format(abs($loan->amount),2)}}
    
  </div>
  @endif

  <div align="left" class="">
     
    <div class="" style="color: #414042!important;   font-size: 14px; ">
      <strong>Bank:</strong> 
      @if($loan->bank=='LB')
      LANDBANK
      @endif

      @if($loan->bank=='PNB')
      PHILIPPINE NATIONAL BANK
      @endif

      @if($loan->bank=='DBP')
      DEVELOPMENT BANK OF THE PHILIPPINES
      @endif

      @if($loan->bank=='Veterans')
      PHILIPPINE VETERANS BANK
      @endif
    </div>
    <div class="" style="color: #414042!important;   font-size: 14px; ">
      <strong>Account Number:</strong> {{ $loan->account_number}}    
    </div>
    <div class="" style="color: #414042!important;   font-size: 14px; ">
      <strong>Account Name:</strong> {{ $loan->account_name}}
    </div>


  </div>
  <br>
  <hr>
  <br>

  @if($loan->status=='DONE' || $loan->status=='CONFIRMED')
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Approved Loan Amount:</strong> PHP {{number_format(abs($loan->approved_amount),2)}}
    
  </div>
  <br>
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Less:</strong>
    @if($less)
      @foreach($less as $l)
      <br>
      {{$l->description}}&nbsp;- PHP &nbsp;{{number_format($l->amount,2)}}
      @endforeach
    @endif
    
  </div>
  <br>
   <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Monthly Amortization:</strong> PHP {{number_format(abs($loan->monthly_amort),2)}}
    
  </div>

   <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Net Proceeds:</strong> PHP {{number_format(abs($loan->net_proceeds),2)}}
    
  </div>

   <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Collection Period:</strong> {{ date("m/Y", strtotime($loan->collect_from)) }} To {{ date("m/Y", strtotime($loan->collect_to)) }}
    
  </div>
  <div class="" style="color: #414042!important;   font-size: 14px; ">
    <strong>Expected Crediting Day:</strong> {{ date("m/d/Y", strtotime($loan->crediting_date)) }}
    
  </div>
  

</div>
@endif






<script src="{{ asset('/dist/vendor.js') }}"></script>
