@extends('layouts/main')
@section('content_body')
<style>
.tooltip {
  position: relative;
  display: inline-block;
  /*border-bottom: 1px dotted black;*/
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  top: 150%;
  left: 50%;
  margin-left: -60px;
  font-size: 12px;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  bottom: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: transparent transparent black transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-12 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-accent">
        Add New Member
      </div>
      <!-- <a href="{{url('admin/member_profile/')}}" class="mp-link mp-link--accent">
            <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
            <span class="mp-text-fs-large">Back to Member Details</span>
          </a> -->
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
              <span style="color:green"><strong>{{ Session::get('success') }}</strong></span><br>
              <span style="color:red">To add loans and contributions please activate the member first to send his/her member's portal credentials</span>
              @endif
            </div>
            <br>
            <br>
            {{ Form::open(array('url' => '/admin/member_add_new', 'method' => 'post', 'id'=>'save_profile', 'autocomplete'=>'off')) }}

            <div class="row">
             <div class="col-sm-5">
              <div class="mp-pb4 mp-input-group">
                <label class="mp-input-group__label" for="currentPassword">
                  First Name
                </label>
                <input class="mp-input-group__input mp-text-field"  
                type="text" 
                name="first_name"
                value=""
                style="text-transform:uppercase;"
               

                />
              </div>
              <div class="mp-pb4 mp-input-group">
                <label class="mp-input-group__label" for="currentPassword">
                  Middle Name
                </label>
                <input class="mp-input-group__input mp-text-field"  
                type="text" 
                name="middle_name"
                value=""
                style="text-transform:uppercase;"

                />
              </div>
              <div class="mp-pb4 mp-input-group">
                <label class="mp-input-group__label" for="currentPassword">
                  Last Name
                </label>
                <input class="mp-input-group__input mp-text-field"  
                type="text" 
                name="last_name"
                value=""
                style="text-transform:uppercase;"

                />
              </div>
              <div class="mp-pb4 mp-input-group">
                <label class="mp-input-group__label" for="password">
                  Campus
                </label>

                <select class="mp-input-group__input mp-text-field" name="campus_id" id="campus_id">
                  @foreach($campus as $camp)
                  <option value="{{$camp->id}}">{{$camp->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="mp-pb4 mp-input-group">
                <label class="mp-input-group__label" for="password">
                  Department
                </label>

                <select class="mp-input-group__input mp-text-field" name="department_id" id="department_id">
                 @foreach($department as $dept)
                 <option value="{{$dept->id}}">{{$dept->name}}</option>
                 @endforeach
               </select>
             </div>

             <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="currentPassword">
                Unit
              </label>
              <input class="mp-input-group__input mp-text-field"  
              type="text" 
              name="unit_dept"
              value=""
           
              />
            </div>

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="currentPassword">
                Position
              </label>
              <input class="mp-input-group__input mp-text-field"  
              type="text" 
              name="position_id"
              value=""
             style="text-transform:uppercase;"


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

              value=""

              />
            </div>

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="currentPassword">
                Cellphone Number <span style="font-size:10; color:red;" >(Enter 10 digit numbers only eg.9955515544)</span>
              </label>
              <input class="mp-input-group__input mp-text-field"  
              type="text" 
              maxlength="10"
              pattern="[1-9]{1}[0-9]{9}"
              name="contact_no"
              value=""
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
              value=""
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="password">
                Gender
              </label>

              <select class="mp-input-group__input mp-text-field" name="gender">
                <option value="MALE" >MALE</option>
                <option value="FEMALE" >FEMALE</option>
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
              value="" 

              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" >
                Status of Appointment
              </label>
              <select class="mp-input-group__input mp-text-field" name="appointment_status">
                <option value="PERMANENT" >PERMANENT</option>
                <option value="TEMPORARY" >TEMPORARY</option>
                <option value="CONTRACTUAL" >CONTRACTUAL</option>
                <option value="CASUAL" >CASUAL</option>
              </select>
            </div>


          </div>
          <div class="col-sm-5 offset-sm-1">

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" >
                Permanent Address
              </label>
              <textarea autocomplete="none" rows="2" cols="100" class="mp-input-group__input mp-text-field" name="permanent_address"  ></textarea>
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" >
                Current Address
              </label>
              <textarea autocomplete="none" rows="2" cols="100" class="mp-input-group__input mp-text-field" name="current_address" ></textarea>
            </div>

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" >
                TIN
              </label>
              <input 
              class="mp-input-group__input mp-text-field" 
              type="text" 
              name="tin"
              value=""

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

              value=""

              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="currentPassword">
                Email
              </label>
              <input class="mp-input-group__input mp-text-field" 
              type="email"
              name="email" 
              value="" 
              />
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="password">
                Salary Grade
              </label>
              <select class="mp-input-group__input mp-text-field" name="salary_grade">
                <option value="1-15" >1-15</option>
                <option value="16-ABOVE" >16-ABOVE</option>
              </select>
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="currentPassword">
                Monthly Salary
              </label>
              <input class="mp-input-group__input mp-text-field"  
              type="text"
              name="monthly_salary"
              value=""
              onkeypress="return isNumber(event)"
              >
            </div>
            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="password">
                Civil Status
              </label>
              <select class="mp-input-group__input mp-text-field" name="civil_status">
                <option value="SINGLE" >SINGLE</option>
                <option value="MARRIED" >MARRIED</option>
                <option value="WIDOWED" >WIDOWED</option>
                <option value="ANNULED / LEGALLY SEPARATED" >ANNULED / LEGALLY SEPARATED</option>
              </select>
            </div>

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="confirmPassword">
                Member Contribution Type
              </label>
              <select class="mp-input-group__input mp-text-field" name="contribution_type">
                <option value="FIXED" >FIXED</option>
                <option value="PERCENTAGE" >PERCENTAGE</option>
              </select>
            </div>
            <div class="mp-pb4 mp-input-group">
              <div class="tooltip">
                <label class="mp-input-group__label" for="confirmPassword">
                  Monthly Contribution
                </label>
                <span class="tooltiptext">For FIXED contribution type, input the exact amount. For PERCENTAGE please input percent value without percent sign. (e.g 1% = 1)</span>
              </div>
              <input 
              class="mp-input-group__input mp-text-field" 
              type="text"
              name="contribution"
              onkeypress="return isNumber(event)"
              value=""
              />
            </div>

            <div class="mp-pb4 mp-input-group">
              <label class="mp-input-group__label" for="confirmPassword">
                Cocolife Form
              </label>

              <select class="mp-input-group__input mp-text-field" name="with_cocolife_form" id="with_cocolife_form">
                <option value="1" >YES</option>
                <option value="0" >NO</option>
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

              value=""

              />
            </div>
          </div>
        </div>
        <div class="mp-pt3 row justify-content-end align-items-center">
          <div class="col col-auto">
            <button type="submit" id="form_submit" value="Submit" class="mp-button mp-button--accent save">Save</button>
            <submit></submit>
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



 
 $('#form_submit').on('click',function(e){
  e.preventDefault();
  var form = $('form');
  var queryString = $('#save_profile').serializeArray();
  var data='<div align="left">';

  console.log(queryString);

  for (var i = 0; i < queryString.length; i++) 
  {
    if(queryString[i].name=='_token')
    {
      
    }
     else if(queryString[i].name=='campus_id')
    {
      data=data.concat('<br>'+queryString[i].name+':&nbsp;&nbsp;&nbsp;<strong>'+$("#campus_id option:selected").html()+'</strong>');

    }

      else if(queryString[i].name=='department_id')
    {
      data=data.concat('<br>'+queryString[i].name+':&nbsp;&nbsp;&nbsp;<strong>'+$("#department_id option:selected").html()+'</strong>');

    }
      else if(queryString[i].name=='with_cocolife_form')
    {
      data=data.concat('<br>'+queryString[i].name+':&nbsp;&nbsp;&nbsp;<strong>'+$("#with_cocolife_form option:selected").html()+'</strong>');

    }
    else
    {
      data=data.concat('<br>'+queryString[i].name+':&nbsp;&nbsp;&nbsp;<strong>'+queryString[i].value.toUpperCase()+'</strong>');
    }
  }
  data=data.concat('</div>');

  swal.fire({
    title: 'Are you sure you want to add this member?',
      html: data,

      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, proceed'
        }).then((result) => {
      if (result.value) {
        console.log(result.value);
     $('#save_profile').trigger('submit');
     }
   })
 
});


</script>
@endsection
