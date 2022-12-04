<style type="text/css">
  .notification {
  text-decoration: none;
  padding: 15px 26px;
  position: relative;
  display: inline-block;
  border-radius: 2px;
}



.notification .badge {
  position: absolute;
  top: -1px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: red;
  color:white;
}

@media only screen and (max-width: 425px) {
   .mp-nav{
      padding-left: 10%;
      padding-right: 10%;
   }
}

</style>


<div class="mp-nav" style="overflow:auto;">
  <ul class="mp-nav__list">

    @if(getUserdetails()->usertype=='member')
    <?php
    $dashboard=array('dashboard','profile');
    $transaction=array('transaction','equity','loans');
    $election=array('election');
    $loan_app=array('loan-app','new-loan','loan-details');
    $url=basename(Request::url());
     $url2=basename(dirname(Request::url()));

    ?>

    <li class="mp-nav__item {{ in_array($url, $dashboard) ? 'mp-nav__selected' : '' }}">
      <a class="mp-nav__link" href="{{url('/member/dashboard')}}">
        <span class="mp-nav__icon">
         @include('layouts.icons.i-dash')
       </span>
       <span class="mp-nav__label">
         Dashboard
       </span>
     </a>
   </li>
   <li class="mp-nav__item {{ in_array($url, $transaction) ? 'mp-nav__selected' : '' }}">
    <a class="mp-nav__link" href="{{url('/member/equity')}}">
      <span class="mp-nav__icon">
       @include('layouts.icons.i-transactions')
     </span>
     <span class="mp-nav__label">
       Transactions
     </span>
   </a>
 </li>
  <li class="mp-nav__item ">
    <a class="mp-nav__link" href="https://www.upprovidentfund.com/forms/" target="_blank">
      <span class="mp-nav__icon">
       @include('layouts.icons.i-forms')
     </span>
     <span class="mp-nav__label">
       Member Forms
     </span>
   </a>
 </li>
  <li class="mp-nav__item  {{ in_array($url, $loan_app)||in_array($url2, $loan_app) ? 'mp-nav__selected' : '' }}">
    <a class="mp-nav__link" href="{{url('/member/loan-app')}}">
      <span class="mp-nav__icon">
       @include('layouts.icons.i-loan-app')
     </span>
     <span class="mp-nav__label">
       Loan Application
     </span>
   </a>
 </li>
  <li class="mp-nav__item ">
    <a class="mp-nav__link" href="https://www.upprovidentfund.com/contact-us/" target="_blank">
      <span class="mp-nav__icon">
       @include('layouts.icons.i-contact')
     </span>
     <span class="mp-nav__label">
       Contact Us
     </span>
   </a>
 </li>
 @if(election())
  <li class="mp-nav__item {{ in_array($url, $election) ? 'mp-nav__selected' : '' }}">
    <a class="mp-nav__link" href="{{url('/member/election/')}}{{  election() ? '/'.election()->id : '' }}" >
      <span class="mp-nav__icon">
       @include('layouts.icons.i-vote')
     </span>
     <span class="mp-nav__label">
       Election
     </span>
   </a>
 </li>
 @endif

 @elseif(getUserdetails()->usertype=='admin')
 <?php
 $dashboard=array('dashboard');
 $members=array('members','member_soa', 'member_equity', 'member_loans');
 $loans=array('loans','loan-details');
 $loan_app=array('loan-app','new-loan','loan-app-details');
 $import=array('import_member','import_equity','import_loan','tempass');
 $modules=array('modules','prme_pr','election');
 $url=basename(Request::url());
 $url2=basename(dirname(Request::url()));
 $url3=basename(dirname(dirname(Request::url())));

 
 
 ?>

 <li class="mp-nav__item {{ in_array($url, $dashboard) ? 'mp-nav__selected' : '' }}">
  <a class="mp-nav__link" href="{{url('/admin/dashboard')}}">
    <span class="mp-nav__icon">
     @include('layouts.icons.i-dash')
   </span>
   <span class="mp-nav__label">
     Dashboard
   </span>
 </a>
</li>

<li class="mp-nav__item {{ in_array($url, $members) || in_array($url2, $members)  ? 'mp-nav__selected' : '' }}">
  <a class="mp-nav__link" href="{{url('/admin/members')}}">
    <span class="mp-nav__icon">
     @include('layouts.icons.i-members')
   </span>
   <span class="mp-nav__label">
     Members
   </span>
 </a>
</li>

<li class="mp-nav__item {{ in_array($url, $loans) || in_array($url2, $loans)  ? 'mp-nav__selected' : '' }}">
  <a class="mp-nav__link" href="{{url('/admin/loans')}}">
    <span class="mp-nav__icon">
     @include('layouts.icons.i-loans')
   </span>
   <span class="mp-nav__label">
     Loans
   </span>
 </a>
</li>
<li class="mp-nav__item  {{ in_array($url, $loan_app) || in_array($url2, $loan_app) ? 'mp-nav__selected' : '' }}">
    <a class="mp-nav__link notification" href="{{url('/admin/loan-app')}}">
      <span class="mp-nav__icon">
       @include('layouts.icons.i-loan-app')
     </span>
     <span class="mp-nav__label">
       Loan Application
     </span>
     {{-- @if(loan_app_count()<>0)
    
     <span class="badge">{{loan_app_count()}}</span>
     @endif --}}
   </a>
 </li>
<li class="mp-nav__item {{ in_array($url, $import) ? 'mp-nav__selected' : '' }}">
  <a class="mp-nav__link" href="{{url('/admin/import_member')}}">
    <span class="mp-nav__icon">
     @include('layouts.icons.i-import')
   </span>
   <span class="mp-nav__label">
     Import
   </span>
 </a>
</li>
<li class="mp-nav__item {{ in_array($url, $modules) || in_array($url2, $modules)|| in_array($url3, $modules)  ? 'mp-nav__selected' : '' }}">

   <a class="mp-nav__link" href="{{url('/admin/modules')}}" >
      <span class="mp-nav__icon">
       @include('layouts.icons.i-module')
     </span>
     <span class="mp-nav__label">
       Modules
     </span>
   </a>

 </li>
@if(getUserdetails()->role=='SUPER_ADMIN')

  {{--<li class="mp-nav__item {{ in_array($url, $modules) ? 'mp-nav__selected' : '' }}">
    <a class="mp-nav__link" href="{{url('/admin/election')}}" >
      <span class="mp-nav__icon">
       @include('layouts.icons.i-vote')
     </span>
     <span class="mp-nav__label">
       Election
     </span>
   </a> 

   <a class="mp-nav__link" href="{{url('/admin/modules')}}" >
      <span class="mp-nav__icon">
       @include('layouts.icons.i-module')
     </span>
     <span class="mp-nav__label">
       Modules
     </span>
   </a>

 </li>--}}

 @endif

@endif

</ul>
</div>
