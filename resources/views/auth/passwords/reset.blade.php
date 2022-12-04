@extends('layouts/splitPane')

@section('left')

  <div class="mp-pb4 mp-text-center">
    <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
  </div>
  <div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
    <div>Welcome {{ $user->first_name}} {{ $user->last_name}}!</div>
    <div>Please set your password below.</div>
  </div>
 <div class="mp-text-fs-small">
      @if($errors->any())
  <div class='mp-flash mp-flash--danger'>
     @foreach ($errors->all() as $error)

  {{ $error }}

@endforeach

  
  @endif 
  </div>
    
       {{ Form::open(array('url' => route('password.request'), 'method' => 'post')) }}
       <input type="hidden" name="token" value="{{ $token }}">
  <input type="hidden" id="email" name="email" value="{{ $user->email}}"/>
    <div class="mp-pb4 mp-input-group">
      <label class="mp-input-group__label" for="password">New Password</label>
      <input class="mp-input-group__input mp-text-field" type="password" id="password" name="password" minlength="8" autofocus required />
    </div>
    <div class="mp-pb4 mp-input-group">
      <label class="mp-input-group__label" for="confirm-password">Confirm New Password</label>
      <input class="mp-input-group__input mp-text-field" type="password" id="confirmPassword" name="password_confirmation" minlength="8" required />
    </div>
    <div class="mp-pt3 row justify-content-between align-items-center">
      <div class="col col-auto order-last">
        <button type="submit" class="mp-button mp-button--accent">Submit</button>
      </div>
      <div class="col order-first"></div>
    </div>
  {{ Form::close() }}
@endsection

@section('right')
  <div class="mp-bg mp-bg--member">
    <div class="mp-mhauto mp-pv5">
      <div class="mp-hide-xs mp-hide-sm mp-text-fs-xxxlarge mp-text-fw-heavy mp-text-c-white mp-text-shadow">
        Welcome to UP Provident Fund
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('/dist/dashboard.js') }}"></script>
@endsection