@extends('layouts/main')
@section('content_body')
  <div class="container mp-container">
    <div class="row no-gutters mp-mt4 justify-content-center">
      <div class="col-12 col-lg-6 mp-ph2 mp-pv2">
        <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">
          Update Password
        </div>
      </div>
    </div>
    <div class="row no-gutters mp-mb4 justify-content-center">
      <div class="col-12 col-lg-6 mp-ph2 mp-pv2">
        <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
          <div class="mp-text-fs-small {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}">
            @if(Session::has('error'))
            <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
            @endif
            @if(Session::has('success'))
            <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
            @endif
          </div>
        
       {{ Form::open(array('url' => '/member/update-password', 'method' => 'post')) }}

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="currentPassword">
                Current Password
              </label>
              <input class="mp-input-group__input mp-text-field" 
                type="password" 
                id="currentPassword" 
                name="currentPassword"
                autofocus 
                required 
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="password">
                New Password
              </label>
              <input 
                class="mp-input-group__input mp-text-field" 
                type="password" 
                id="password" 
                name="password"
                required 
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="confirmPassword">
                Confirm New Password
              </label>
              <input 
                class="mp-input-group__input mp-text-field" 
                type="password" 
                id="confirmPassword" 
                name="confirmPassword"
                required 
              />
            </div>
            <div class="mp-pt3 row justify-content-end align-items-center">
              <div class="col col-auto">
                <button type="submit" class="mp-button mp-button--accent">Update</button>
              </div>
            </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script src="{{ asset('/dist/updatePassword.js') }}"></script>
@endsection
