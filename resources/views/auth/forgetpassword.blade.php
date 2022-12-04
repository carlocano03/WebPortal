@extends('layouts/splitPane')

@section('left')
  <div class="mp-pb4 mp-text-center">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
  </div>
  <div class="mp-pb5 mp-text-c-primary mp-text-fs-large mp-text-center mp-split-pane__title">
    Reset Your Password
  </div>
  <div class="mp-pb3 mp-text-c-gray">
   Submit your email address and we'll send you a "Reset your Password" email. If you cannot find the email in your Inbox, wait a few minutes then refresh your Inbox or, alternatively, look for it in your Spam or Junk folder. If you do not remember your email address, please <a href="https://www.upprovidentfund.com/contact-us/" target="_blank">contact us</a> so we can assist you in resetting your password.
  </div>
  <div class="mp-text-fs-small">

    @if($errors->any())
  <div class='mp-flash mp-flash--danger'>
     @foreach ($errors->all() as $error)

  {{ $error }}

@endforeach

  </div>
  @endif 

 
    @if (session('status'))
    <div class="mp-text-fs-small">
                        <div class="mp-flash mp-flash--success">
                            {{ session('status') }}
                        </div>
                      </div>
                    @endif  
  </div>
  <form id="forgot-password-form" class="mp-pt3 mp-mb5" method="post" action="{{ route('password.email') }}">
    {{ csrf_field() }}
    <div class="mp-pb4 mp-input-group">
      <label class="mp-input-group__label" for="email">Email</label>
      <input class="mp-input-group__input mp-text-field" type="email" id="email" name="email" required autofocus />
    </div>
    <div class="mp-pt3 row justify-content-between align-items-center">
      <div class="col col-auto order-last">
        <button type="submit" class="mp-button mp-button--accent">Send Email</button>
      </div>
      <div class="col order-first">
        <a class="mp-text-fs-small mp-link" href="{{ isset($_GET['admin']) ? '/admin' : '/login' }}">Back to Login</a>
      </div>
    </div>
  </form>
@endsection

@section('right')
<?php
if(isset($_GET['admin']))
{
$source='../assets/images/bg-admin.svg';
}
else
{
  $source='../assets/images/bg-member.svg';
}

?>
<div class="mp-bg {{ isset($_GET['admin']) ? 'mp-bg--admin' : 'mp-bg--member' }}" style="background-image:url({{ $source }})">
  <div class="mp-mhauto mp-pv5">
    <div class="mp-hide-xs mp-hide-sm mp-text-fs-xxxlarge mp-text-fw-heavy mp-text-c-white mp-text-shadow">
      Welcome to UP Provident Fund
    </div>
  </div>
</div>
@endsection
