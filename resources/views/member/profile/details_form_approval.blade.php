@extends('layouts/main')
@section('content_body')
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-6 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">
        Update Details (For Approval)
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
            First Name
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text" 
          name="first_name"
          value="{{ $member->first_name }}"

          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Middle Name
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text" 
          name="middle_name"
          value="{{ $member->middle_name }}"

          />
        </div>

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Last Name
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text" 
          name="last_name"
          value="{{ $member->last_name }}"

          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Email
          </label>
          <input class="mp-input-group__input mp-text-field" 
          type="email" 


          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="password">
            Salary Grade
          </label>
          <select class="mp-input-group__input mp-text-field" name="appointment_status">
            <option value="1-15">1-15</option>
            <option value="16-Above">16-Above</option>
          </select>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="confirmPassword">
            Civil Status
          </label>
          <input 
          class="mp-input-group__input mp-text-field" 
          type="password" 

          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="confirmPassword">
            Member Contribution Type
          </label>
          <select class="mp-input-group__input mp-text-field" name="contribution_type">
            <option value="fixed">Fixed</option>
            <option value="percentage">Percentage</option>
          </select>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="confirmPassword">
            Monthly Contribution
          </label>
          <input 
          class="mp-input-group__input mp-text-field" 
          type="text"
          name="contribution"
          onkeypress="return isNumber(event)"

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
<script>
  function isNumber(evt)
  {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
     return false;

   return true;
 }
</script>
@endsection
