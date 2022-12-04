@extends('layouts/main')
@section('content_body')
<style type="text/css">

</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-12 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-accent">
        Update Details
      </div>
      <a href="{{url('admin/member_profile/'.$member->user_id)}}" class="mp-link mp-link--primary">
            <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
            <span class="mp-text-fs-medium">Back to Member Details</span>
          </a>
    </div>
  </div>
  <div class="row no-gutters mp-mb4 justify-content-center">
    <div class="col-12 col-lg-12 mp-ph2 mp-pv2">
      <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">

        <div class="mp-text-fs-small {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}" align="center">
          @if(Session::has('error'))
          <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
          @endif
          @if(Session::has('success'))
          <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
          @endif
        </div>
        <br>
        <br>
        {{ Form::open(array('url' => '/admin/member_save_details', 'method' => 'post', 'id'=>'update_profile', 'autocomplete'=>'off')) }}
        <input type="hidden" name="user_id" value="{{$member->user_id}}">
        <input type="hidden" name="member_no" value="{{$member->member_no}}">
        <div class="row">
         <div class="col-sm-5">
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
            <label class="mp-input-group__label" for="password">
              Campus
            </label>

            <select class="mp-input-group__input mp-text-field" name="campus_id">
              @foreach($campus as $camp)
              <option value="{{$camp->id}}" {{  isset($details)  ? $member->campus_id==$camp->id ? 'selected': ' '  : ' '  }}>{{$camp->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mp-pb4 mp-input-group">
            <label class="mp-input-group__label" for="password">
              Department
            </label>

            <select class="mp-input-group__input mp-text-field" name="department_id">
             @foreach($department as $dept)
             <option value="{{$dept->id}}" {{  isset($details)  ? $member->department_id==$dept->id ? 'selected': ' '  : ' '  }}>{{$dept->name}}</option>
             @endforeach
           </select>
         </div>

         <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Position
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text" 
          name="position_id"
          value="{{ $member->position_id }}"
          
          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Appointment Date
          </label>

          <input autocomplete="none"
          class="mp-input-group__input mp-text-field" 
          type="text" 
          id="original_appointment_date"
          name="original_appointment_date"

          value="{{  $details ? date('m/d/Y', strtotime($member->original_appointment_date)): '' }}"

          />
        </div>

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Membership Date
          </label>

          <input autocomplete="none"
          class="mp-input-group__input mp-text-field" 
          type="text" 
          id="membership_date"
          name="membership_date"

          value="{{  $details ? date('m/d/Y', strtotime($member->membership_date)): '' }}"

          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="currentPassword">
            Cellphone Number
          </label>
          <input class="mp-input-group__input mp-text-field"  
          type="text" 
          maxlength="10"
          pattern="[1-9]{1}[0-9]{9}"
          name="contact_no"
          value="{{ $member->contact_no }}"
          onkeypress="return isNumber(event)"
          />
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
            <option value="MALE" {{  isset($details)  ? $details->gender=='MALE' ? 'selected': ' '  : ' '  }}>MALE</option>
            <option value="FEMALE" {{  isset($details)  ? $details->gender=='FEMALE' ? 'selected': ' '  : ' '  }}>FEMALE</option>
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
            <option value="PERMANENT" {{  isset($details)  ? $details->appointment_status=='PERMANENT' ? 'selected': ''  : ''  }}>PERMANENT</option>
            <option value="TEMPORARY" {{  isset($details)  ? $details->appointment_status=='TEMPORARY' ? 'selected': ''  : ''  }}>TEMPORARY</option>
            <option value="CONTRACTUAL" {{  isset($details)  ? $details->appointment_status=='CONTRACTUAL' ? 'selected': ''  : ''  }}>CONTRACTUAL</option>
            <option value="CASUAL" {{  isset($details)  ? $details->appointment_status=='CASUAL' ? 'selected': ''  : ''  }}>CASUAL</option>
          </select>
        </div>


      </div>
      <div class="col-sm-5 offset-sm-1">

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Permanent Address
          </label>
          <textarea autocomplete="none" rows="2" cols="100" class="mp-input-group__input mp-text-field" name="permanent_address">{{  $details ? $details->permanent_address : '' }}</textarea>
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" >
            Current Address
          </label>
          <textarea autocomplete="none" rows="2" cols="100" class="mp-input-group__input mp-text-field" name="current_address">{{  $details ? $details->current_address : '' }}</textarea>
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
            Birthdate
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
            Email
          </label>
          <input class="mp-input-group__input mp-text-field" 
          type="email"
          name="email" 
          value="{{ $member->email }}" 
          />
        </div>
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="password">
            Salary Grade
          </label>
          <select class="mp-input-group__input mp-text-field" name="salary_grade">
            <option value="1-15" {{  isset($details)  ? $details->salary_grade=='1-15' ? 'selected': ''  : ''  }}>1-15</option>
            <option value="16-ABOVE" {{  isset($details)  ? $details->salary_grade=='16-ABOVE' ? 'selected': ''  : ''  }}>16-ABOVE</option>
          </select>
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
        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="password">
            Civil Status
          </label>
          <select class="mp-input-group__input mp-text-field" name="civil_status">
            <option value="SINGLE" {{  isset($details)  ? $details->civil_status=='SINGLE' ? 'selected': ''  : ''  }}>SINGLE</option>
            <option value="MARRIED" {{  isset($details)  ? $details->civil_status=='MARRIED' ? 'selected': ''  : ''  }}>MARRIED</option>
            <option value="WIDOWED" {{  isset($details)  ? $details->civil_status=='WIDOWED' ? 'selected': ''  : ''  }}>WIDOWED</option>
            <option value="ANNULED / LEGALLY SEPARATED" {{  isset($details)  ? $details->civil_status=='ANNULED / LEGALLY SEPARATED' ? 'selected': ''  : ''  }}>ANNULED / LEGALLY SEPARATED</option>
          </select>
        </div>

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="confirmPassword">
            Member Contribution Type
          </label>
          <select class="mp-input-group__input mp-text-field" name="contribution_type">
            <option value="FIXED" {{  isset($details)  ? $details->contribution_type=='FIXED' ? 'selected': ''  : ''  }}>FIXED</option>
            <option value="PERCENTAGE" {{  isset($details)  ? $details->contribution_type=='PERCENTAGE' ? 'selected': ''  : ''  }}>PERCENTAGE</option>
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
          value="{{  $details ? $details->contribution : '' }}"
          />
        </div>

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="confirmPassword">
            Cocolife Form
          </label>
          <select class="mp-input-group__input mp-text-field" name="with_cocolife_form">
            <option value="1" {{  isset($details)  ? $details->with_cocolife_form=='1' ? 'selected': ''  : ''  }}>YES</option>
            <option value="0" {{  isset($details)  ? $details->with_cocolife_form=='0' ? 'selected': ''  : ''  }}>NO</option>
          </select>
        </div>

        <div class="mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="confirmPassword">
            Proxy Form Validity
          </label>
          <input autocomplete="none"
          class="mp-input-group__input mp-text-field" 
          type="text" 
          id="proxy_date"
          name="validity"

          value="{{  isset($details)  ? $details->validity ? date('m/d/Y', strtotime($details->validity)): ''  : ''  }}"

          />
        </div>
      </div>
    </div>
    <div class="mp-pt3 row justify-content-end align-items-center">
      <div class="col col-auto">
        <button type="button" class="mp-button mp-button--accent update">Update</button>
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
  $( function() {
    $( "#proxy_date" ).datepicker();
  } );

  $( function() {
    $( "#membership_date" ).datepicker();
  } );

  $( function() {
    $( "#original_appointment_date" ).datepicker();
  } );

  function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
     return false;

   return true;
 }

$('.update').click(function () {
  
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
   Swal.fire({
  title: 'Are you sure you want to update?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, proceed'
}).then((result) => {
  if (result.value) {
   $( "#update_profile" ).submit();
  }
})
  })

</script>
@endsection
