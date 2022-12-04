@extends('layouts/main')
@section('content_body')
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
       Loan Application
     </div>
   </div>
 </div>
 <div class="row no-gutters mp-mb4 justify-content-center">
  <div class="col-12 mp-ph2 mp-pv2">
    <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
     <div class="mp-text-fs-medium">

       Thank you for submitting your &nbsp;<strong>{{$loan_type}}</strong>&nbsp; application documents. We will now process your application. 
       <br>
       <br>
       Within the next two (2) business days, you will receive another message from us regarding the status of your loan application. If approved, you will know the approved loan amount and expected day of crediting of your loan proceeds.
       <br>
       <br>
       If you need to follow up your application, please note that your Loan Application Number is &nbsp;<strong>{{$control_number}}</strong>&nbsp;.
       <br>
       <br>
       Thank you very much.

     </div>

     <br>
     <br>
     <div class="mp-card__footer__split mp-text-center">
      <a href="{{url('/member/loan-app')}}"  class="mp-button mp-button--primary">
        Back to Loan Application
      </a>
    </div>

  </div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>

</script>