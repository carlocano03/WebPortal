@extends('layouts/splitPane')

@section('left')

<div class="mp-pb4 mp-text-center">
  <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
</div>
<div class="mp-pb4 mp-text-fs-large mp-text-center mp-split-pane__title mp-text-c-primary">
 {{ (Request::route()->getName() == 'admin' ? 'Admin' : 'Member')}} Login
</div>
<div class="mp-text-fs-small">
  @if(Session::get('error'))
  <div class='mp-flash mp-flash--danger'>
    {{ Session::get('error') }}
  </div>
  @endif 
   @if (session('status'))
                        <div class="mp-flash mp-flash--success">
                            {{ session('status') }}
                        </div>
                    @endif 
</div>
<form id="loginForm" class="mp-pt4 mp-mb5" method="post" action="{{ url('/login') }}">
 {{ csrf_field() }}
 <div class="mp-pb4 mp-input-group">
  <label class="mp-input-group__label" for="email">
   {{ Request::route()->getName() == 'admin' ? 'Email' : "Member's ID Number" }}
 </label>
 <input type="hidden" name="usertype" value="{{ Request::route()->getName() == 'admin' ? 'admin' : 'member' }}">
 <input 
 class="mp-input-group__input mp-text-field" 
 type="{{ Request::route()->getName() == 'admin' ? 'email' : 'text' }}" 
 id="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}" 
 name="{{ Request::route()->getName() == 'admin' ? 'email' : 'memberNo' }}"
 maxlength="{{ Request::route()->getName() == 'admin' ? ' ' : '9' }}"
 value="{{ Session::get('user') }}" 
 autofocus 
 required 
 />
</div>
<div class="mp-pb4 mp-input-group">
  <label class="mp-input-group__label" for="password">Password</label>
  <input class="mp-input-group__input mp-text-field" type="password" id="password" name="password" required />
</div>
<div class="mp-pt3 row justify-content-between align-items-center">
  <div class="col col-auto order-last">
    <button type="submit" class="mp-button mp-button--accent">Login</button>
  </div>
  <div class="col order-first">
    <a class="mp-text-fs-small mp-link" href="{{ url('/password/reset') }}{{ Request::route()->getName() == 'admin' ? '?admin=true' : '' }}">
      Forgot password?
    </a>
    <br/>
    <a class="mp-text-fs-small mp-link" href="https://www.upprovidentfund.com/">
      Back to www.upprovidentfund.com
    </a>
  </div>
</div>
</form>
@endsection

@section('right')
<div class="mp-bg {{ Request::route()->getName() == 'admin' ? 'mp-bg--admin' : 'mp-bg--member' }}" style="background-image:url({{ Request::route()->getName() == 'admin' ? 'assets/images/bg-admin.svg' : 'assets/images/bg-member.svg'}})">
  <div class="mp-mhauto mp-pv5">
    <div class="mp-hide-xs mp-hide-sm mp-text-fs-xxxlarge mp-text-fw-heavy mp-text-c-white mp-text-shadow">
      Welcome to UP Provident Fund
    </div>
  </div>
</div>
@endsection




