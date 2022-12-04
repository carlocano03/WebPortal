@extends('layouts/main')
@section('content_body')
<style type="text/css">
#main {
  display: inline-block;
  white-space: nowrap;
  width:94%;
}
#main span, #main input {
  display: inline-block;
}
</style>

<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
     
    <div class="col-12 col-lg-6 mp-ph2 mp-pv2">

      <a href="{{url('/member/dashboard')}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Dashboard</span>
      </a>
      <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">
        Update Details
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
        
        {{ Form::open(array('url' => '/member/edit_details', 'method' => 'post', 'autocomplete'=>'off')) }}

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Cellphone Number
          </label>
          <br>
         <div id="main">
          <span>+63</span>
          <input class="mp-input-group__input mp-text-field"  
          type="text" 
          maxlength="10"
          pattern="[1-9]{1}[0-9]{9}"
          name="contact_no"
          value="{{ $member->contact_no }}"
          onkeypress="return isNumber(event)"
          required="true" 
          />
        </div>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Landline Number
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text"
          name="landline"
          value="{{  $details ? $details->landline : '' }}"
          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="password">
            Gender
          </label>

          <select class="mp-input-group__input mp-text-field" name="gender">
            <option value="MALE" {{  isset($details)  ? $details->gender=='MALE' ? 'selected': ' '  : ' '  }}>Male</option>
            <option value="FEMALE" {{  isset($details)  ? $details->gender=='FEMALE' ? 'selected': ' '  : ' '  }}>Female</option>
          </select>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Employee Number
          </label>
          <input 
          class="mp-input-group__input mp-text-field" 
          type="text"
          name="employee_no" 
          value="{{  $details ? $details->employee_no : '' }}" 

          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Status of Appointment
          </label>
          <select class="mp-input-group__input mp-text-field" name="appointment_status">
            <option value="PERMANENT" {{  isset($details)  ? $details->appointment_status=='PERMANENT' ? 'selected': ''  : ''  }}>Permanent</option>
            <option value="TEMPORARY" {{  isset($details)  ? $details->appointment_status=='TEMPORARY' ? 'selected': ''  : ''  }}>Temporary</option>
            <option value="CONTRACTUAL" {{  isset($details)  ? $details->appointment_status=='CONTRACTUAL' ? 'selected': ''  : ''  }}>Contractual</option>
            <option value="CASUAL" {{  isset($details)  ? $details->appointment_status=='CASUAL' ? 'selected': ''  : ''  }}>Casual</option>
          </select>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            TIN
          </label>
          <input 
          class="mp-input-group__input mp-text-field" 
          type="text" 
          name="tin"
          value="{{  $details ? $details->tin : '' }}"
          
          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Permanent Address
          </label>
          <textarea autocomplete="none" rows="2" cols="100" class="mp-input-group__input mp-text-field"name="permanent_address">{{  $details ? $details->permanent_address : '' }}</textarea>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Current Address
          </label>
          <textarea autocomplete="none" rows="2" cols="100" class="mp-input-group__input mp-text-field" name="current_address">{{  $details ? $details->current_address : '' }}</textarea>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Birthday
          </label>

          <input autocomplete="none"
          class="mp-input-group__input mp-text-field" 
          type="text" 
          id="birth_date"
          name="birth_date"

          value="{{  $details ? date('m/d/Y', strtotime($details->birth_date)): '' }}"

          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Monthly Salary
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text"
          name="monthly_salary"
          value="{{  $details ? number_format($details->monthly_salary,2, '.', '') : '0.00' }}"
          onkeypress="return isNumber(event)"
          >
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('/dist/updatePassword.js') }}"></script>
<script>
  $( function() {
    $( "#birth_date" ).datepicker();
  } );

  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
</script>
@endsection
