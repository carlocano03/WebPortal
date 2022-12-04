@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<style type="text/css">
[data-md-tooltip]:before {

  width: 150px;

}
.swal2-content {
 font-size: 15px;
}
.swal2-title {
 font-size: 17px;
}


</style>

<div class="container mp-container">

  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 mp-ph2 mp-pv2" style="padding-bottom: 0px!important;">
      <a href="{{url('/admin/loan-app-details/'.$loan->id)}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Loan Details</span>
      </a>
    </div>
    <div class="col-12  mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-accent">
       Loan Details
     </div>
   </div>
 </div>
 <div class="row no-gutters mp-mb4 justify-content-center">
  <div class="col-12 mp-ph2 mp-pv2">

    <div class="mp-ph4 mp-pv4 mp-card mp-card--plain" align='center'>

    
     <div  class='col-12'>
      <br>
      <div align="center" class="mp-text-fs-large mp-text-fw-heavy">

        <strong>LOAN APPLICATION NO.:  <span>{{$loan->control_number}}</span></strong>  
        <br>  
        <strong>APPLICATION TYPE:@if($loan_details->type=='NEW')<span>NEW</span>@else<span>RENEWAL</span>@endif</strong>  
        <br>  
        <strong>MEMBER: <span>{{$loan->full_name}}</span></strong>  




      </div>
      <br>

      <div class="row mp-mb2">
        <div class="col mp-text-fw-heavy" align="left" >Current Status:</div>
        @if($loan->status=="SUBMITTED")
        <div class="col-md-auto"  style="color:#feb236; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
        @endif
        @if($loan->status=="PROCESSING")
        <div class="col-md-auto"  style="color:#82b74b; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
        @endif
        @if($loan->status=="DONE")
        <div class="col-md-auto"  style="color:#034f84; text-align: center!important; width:300px;"><strong>FOR MEMBER CONFIRMATION</strong></div>
        @endif
        @if($loan->status=="CANCELLED")
        <div class="col-md-auto"  style="color:#d64161; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
        @endif
        @if($loan->status=="CONFIRMED")
        <div class="col-md-auto"  style="color:#894168; text-align: center!important; width:300px;"><strong>{{$loan->status}}</strong></div>
        @endif
        <div class="col mp-text-fw-heavy" align="left" >Member No.:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;"><strong>{{$loan->member_no}}</strong></div>
      </div>

      <div class="row mp-mb2">
        <div class="col mp-text-fw-heavy" align="left" >Loan Type:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;">{{$loan->description}}</div>
        <div class="col mp-text-fw-heavy" align="left" >Date Submitted:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;">{{date("m/d/Y h:i A", strtotime($loan->date_created))}}</div>
      </div>
      
      <div class="row mp-mb2">
        <div class="col mp-text-fw-heavy" align="left" >Active Email:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan->active_email}}</div>
        <div class="col mp-text-fw-heavy" align="left" >Active Mobile Number:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >+63{{$loan->active_number}}</div>
      </div>

      <br>
      <hr style="background-color: #b4b3b3;" >
      <br>
      <div class="row mp-mb2">
        <div class="col mp-text-fw-heavy" align="left" >Bank:</div>
        @if($loan_details->bank=='LB')
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >LANDBANK</div>
        @endif
        @if($loan_details->bank=='PNB')
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHILIPPINE NATIONAL BANK</div>
        @endif

        @if($loan_details->bank=='DBP')
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >DEVELOPMENT BANK OF THE PHILIPPINES</div>
        @endif

        @if($loan_details->bank=='Veterans')
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHILIPPINE VETERANS BANK</div>
        @endif

        <div class="col mp-text-fw-heavy" align="left" >Account Number:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->account_number}}</div>
      </div>

      <div class="row mp-mb2">
        <div class="col mp-text-fw-heavy" align="left" >Account Name:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >{{$loan_details->account_name}}</div>
        @if($loan_details->type=='RENEW')
         <div class="col mp-text-fw-heavy"  align="left">Renewal Type:</div>
         <div class="col-md-auto" style="width:300px;text-align: center!important;">{{$loan_details->renewal_type}}</div>
         @else
        <div class="col mp-text-fw-heavy" align="left" >Amount:</div>
        <div class="col-md-auto" style="width:300px;text-align: center!important;" >PHP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($loan_details->amount,2) }}</div>
        @endif
      </div>

      

      <br>
      <br>

      <div align="center" class="mp-text-fs-large mp-text-fw-heavy">
        <strong>ATTACHMENTS</strong>          
      </div>
      <br>

      <label class="col-6" for="album_cover">ID:
      </label>
      <br>
      @if($loan_details->p_id)
      <?php
      $file=explode(".",$loan_details->p_id);
      $file_ex=$file[1];
      ?>
      <a href="{{ asset('storage/app/loan_application/'.$loan_details->p_id) }}" target="_blank">
        @if($file_ex=='pdf' || $file_ex=='PDF')
        VIEW PDF
        @else
        <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->p_id) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
        @endif
      </a>
      @else
      <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
      @endif
      <br>

      <br>

      <label class="col-6" for="album_cover">Payslip 1:
      </label>
      <br>
      @if($loan_details->payslip_1)
      <?php
      $file=explode(".",$loan_details->payslip_1);
      $file_ex=$file[1];
      ?>
      <a href="{{ asset('storage/app/loan_application/'.$loan_details->payslip_1) }}" target="_blank">
       @if($file_ex=='pdf' || $file_ex=='PDF')
       VIEW PDF
       @else
       <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->payslip_1) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
       @endif
     </a>
     @else
     <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
     @endif
     <br>
     <br>

     <label class="col-6" for="album_cover">Payslip 2:
     </label>
     <br>
     @if($loan_details->payslip_2)
     <?php
     $file=explode(".",$loan_details->payslip_2);
     $file_ex=$file[1];
     ?>
     <a href="{{ asset('storage/app/loan_application/'.$loan_details->payslip_2) }}" target="_blank">
       @if($file_ex=='pdf' || $file_ex=='PDF')
       VIEW PDF
       @else
       <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->payslip_2) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
       @endif
     </a>
     @else
     <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
     @endif
     <br>
     <br>

     <label class="col-6" for="album_cover">Proof of Account Number:
     </label>
     <br>
     @if($loan_details->atm_passbook)
     <?php
     $file=explode(".",$loan_details->atm_passbook);
     $file_ex=$file[1];
     ?>
     <a href="{{ asset('storage/app/loan_application/'.$loan_details->atm_passbook) }}" target="_blank">
      @if($file_ex=='pdf' || $file_ex=='PDF')
      VIEW PDF
      @else
      <img id="blah" src="{{ asset('storage/app/loan_application/'.$loan_details->atm_passbook) }}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
      @endif
    </a>
    @else
    <img id="blah" src="{!! asset('assets/images/noimage.png') !!}" style="padding-top: 10px;  max-width: 30%" alt="your image" />
    @endif
    <br>
    <br>
    <hr style="background-color: #b4b3b3;" >
    <br>
    
<div align="center" class="mp-text-fs-medium mp-text-fw-heavy">
  <strong>Approved Details</strong>          
</div>
<br>
{{ Form::open(array('url' => '/admin/loan-app-update', 'method' => 'post', 'id'=>'update_application', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}

<div class="mp-pb4 mp-input-group" style="width:50%">
            <label class="mp-input-group__label" for="password">
              Loan Type
            </label>

            <select class="mp-input-group__input mp-text-field" name="loan_type">
              @foreach($loan_type as $type)
              @if($type->id != 4)
              @if($type->id != 5)
              <option value="{{$type->id}}" {{  $loan->loan_type==$type->id ? 'selected': ' '   }}>{{$type->name}}</option>
              @endif
              @endif
              @endforeach
            </select>
</div>
<br/>
 @if($loan_details->type=='RENEW')
<div class="mp-pb4 mp-input-group" style="width:50%">
            <label class="mp-input-group__label" for="password">
              Renewal Type
            </label>

            <select class="mp-input-group__input mp-text-field" name="renewal_type">
              <option value="FULL EQUITY" {{  $loan_details->renewal_type=="FULL EQUITY" ? 'selected': ' '   }}>FULL EQUITY</option>
              <option value="SAME DEDUCTION" {{  $loan_details->renewal_type=="SAME DEDUCTION" ? 'selected': ' '   }}>SAME DEDUCTION</option>
            </select>
</div>

<br/>
@endif

<div class="mp-pb4 mp-input-group" style="width:50%" >
  <label class="mp-input-group__label" for="confirmPassword">
    Approved Loan Amount
  </label>
  <input 
  class="mp-input-group__input mp-text-field" 
  type="text"
  name="approved_amount"
  onkeypress="return isNumber(event)"
  style="text-align: center" 
  value="{{number_format($loan->approved_amount,2)}}"
  placeholder="0.00" 
  required

  />
</div>
<br>


<div class="mp-pb4 mp-input-group" style="width:50%" align="left">
  <label class="mp-input-group__label" >
    LESS
  </label>
  <br>

  <span align="left" >SERVICE FEE:
   <input 
   class="mp-text-field" 
   type="text"
   name="servicefee_amount"
   onkeypress="return isNumber(event)"
   value="200"
   style="text-align: right" 
   readonly

   />
 </span>
 <br>
 <br>
 <input type="checkbox" id="out_pel" {{ array_key_exists("Outstanding Loan - Principal(PEL)",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Outstanding Loan - Principal (PEL):
   <input 
   class="mp-text-field" 
   type="text"
   id="out_pel_amount"
   style="text-align: right" 
   name="out_pel_amount"
   onkeypress="return isNumber(event)"
   @if(array_key_exists('Outstanding Loan - Principal(PEL)',$loan_ded))
   value='{{number_format($loan_ded["Outstanding Loan - Principal(PEL)"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Outstanding Loan - Principal(PEL)",$loan_ded) ? '': 'disabled'  }}
   required 

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="out_bl" {{ array_key_exists("Outstanding Loan - Principal(BL)",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Outstanding Loan - Principal (BL):
   <input 
   class="mp-text-field" 
   type="text"
   id="out_bl_amount"
   name="out_bl_amount"
   onkeypress="return isNumber(event)"
    @if(array_key_exists('Outstanding Loan - Principal(BL)',$loan_ded))
   value='{{number_format($loan_ded["Outstanding Loan - Principal(BL)"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   style="text-align: right" 
   {{ array_key_exists("Outstanding Loan - Principal(BL)",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="out_eml" {{ array_key_exists("Outstanding Loan - Principal(EML)",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Outstanding Loan - Principal (EML):
   <input 
   class="mp-text-field" 
   type="text"
   id="out_eml_amount"
   name="out_eml_amount"
   onkeypress="return isNumber(event)"
    @if(array_key_exists('Outstanding Loan - Principal(EML)',$loan_ded))
   value='{{number_format($loan_ded["Outstanding Loan - Principal(EML)"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   style="text-align: right" 
  {{ array_key_exists("Outstanding Loan - Principal(EML)",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="out_cbl" {{ array_key_exists("Outstanding Loan - Principal(CBL)",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Outstanding Loan - Principal (CBL):
   <input 
   class="mp-text-field" 
   type="text"
   style="text-align: right" 
   id="out_cbl_amount"
   name="out_cbl_amount"
   onkeypress="return isNumber(event)"
    @if(array_key_exists('Outstanding Loan - Principal(CBL)',$loan_ded))
   value='{{number_format($loan_ded["Outstanding Loan - Principal(CBL)"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Outstanding Loan - Principal(CBL)",$loan_ded) ? '': 'disabled'  }}
   required

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="int_pel" {{ array_key_exists("Interest - PEL",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Interest - PEL:
   <input 
   class="mp-text-field" 
   type="text"
   style="text-align: right" 
   id="int_pel_amount"
   name="int_pel_amount"
   onkeypress="return isNumber(event)"
   @if(array_key_exists('Interest - PEL',$loan_ded))
   value='{{number_format($loan_ded["Interest - PEL"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Interest - PEL",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="int_bl" {{ array_key_exists("Interest - BL",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Interest - BL:
   <input 
   class="mp-text-field" 
   style="text-align: right" 
   type="text"
   id="int_bl_amount"
   name="int_bl_amount"
   onkeypress="return isNumber(event)"
   @if(array_key_exists('Interest - BL',$loan_ded))
   value='{{number_format($loan_ded["Interest - BL"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Interest - BL",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="int_eml" {{ array_key_exists("Interest - EML",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Interest - EML:
   <input 
   class="mp-text-field" 
   type="text"
   style="text-align: right" 
   id="int_eml_amount"
   name="int_eml_amount"
   onkeypress="return isNumber(event)"
    @if(array_key_exists('Interest - EML',$loan_ded))
   value='{{number_format($loan_ded["Interest - EML"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Interest - EML",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="int_cbl" {{ array_key_exists("Interest - CBL",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Interest - CBL:
   <input 
   class="mp-text-field" 
   type="text"
   id="int_cbl_amount"
   name="int_cbl_amount"
   style="text-align: right" 
   onkeypress="return isNumber(event)"
    @if(array_key_exists('Interest - CBL',$loan_ded))
   value='{{number_format($loan_ded["Interest - CBL"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Interest - CBL",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 <input type="checkbox" id="surge" {{ array_key_exists("Surcharge",$loan_ded) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >Surcharge:
   <input 
   class="mp-text-field" 
   type="text"
   id="surge_amount"
   name="surge_amount"
   style="text-align: right" 
   onkeypress="return isNumber(event)"
    @if(array_key_exists('Surcharge',$loan_ded))
   value='{{number_format($loan_ded["Surcharge"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("Interest - Surcharge",$loan_ded) ? '': 'disabled'  }}

   />
 </span>

 <br>
 <br>
 Others
 <br>
 <input type="checkbox" id="other1" {{ array_key_exists("other1",$other) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">
 <span align="left" >

   <input 
   class="mp-text-field" 
   type="text"
   id="other1_desc"
   name="other1_desc"
   style="text-align: center; width:250px;"  
    @if(array_key_exists('other1',$other))
   value='{{$other["other1"]["description"]}}'
   @else
   value=''
   @endif
   placeholder="Description" 
   {{ array_key_exists("other1",$other) ? '': 'disabled'  }}

   />
   &nbsp;
   &nbsp;
   &nbsp;
   &nbsp;
   <input 
   class="mp-text-field" 
   type="text"
   id="other1_amount"
   name="other1_amount"
   style="text-align: right" 
   onkeypress="return isNumber(event)"
    @if(array_key_exists('other1',$other))
   value='{{number_format($other["other1"]["amount"],2)}}'
   @else
   value=''
   @endif
   placeholder="0.00" 
   {{ array_key_exists("other1",$other) ? '': 'disabled'  }}

   />
 </span>
 <br>
 <input type="checkbox" id="other2" {{ array_key_exists("other2",$other) ? 'checked': ' '  }} onclick="EnableDisableTextBox(this)">

 <span align="left" >
  <input 
  class="mp-text-field" 
  type="text"
  id="other2_desc"
  name="other2_desc"
  style="text-align: center;  width:250px;" 
  @if(array_key_exists('other2',$other))
   value='{{$other["other2"]["description"]}}'
   @else
   value=''
   @endif
  placeholder="Description" 
{{ array_key_exists("other2",$other) ? '': 'disabled'  }}

  />
  &nbsp;
  &nbsp;
  &nbsp;
  &nbsp;
  <input 
  class="mp-text-field" 
  type="text"
  id="other2_amount"
  name="other2_amount"
  style="text-align: right" 
  onkeypress="return isNumber(event)"
  @if(array_key_exists('other2',$other))
   value='{{number_format($other["other2"]["amount"],2)}}'
   @else
   value=''
   @endif
  placeholder="0.00" 
{{ array_key_exists("other2",$other) ? '': 'disabled'  }}

  />
</span>


</div>
<br>
<div class="mp-pb4 mp-input-group" style="width:50%">
  <label class="mp-input-group__label" for="confirmPassword">
    Monthly Amortization
  </label>
  <input 
  class="mp-input-group__input mp-text-field" 
  type="text"
  style="text-align: center" 
  name="monthly_amort"
  onkeypress="return isNumber(event)"
  value="{{number_format($loan->monthly_amort,2)}}"
  placeholder="0.00" 
  required

  />
</div>
<br>
<div class="mp-pb4 mp-input-group" style="width:50%">
  <label class="mp-input-group__label" for="confirmPassword">
    Net Proceeds
  </label>
  <input 
  class="mp-input-group__input mp-text-field" 
  type="text"
  style="text-align: center" 
  name="net_proceeds"
  onkeypress="return isNumber(event)"
  value="{{number_format($loan->net_proceeds,2)}}"
  placeholder="0.00" 
  readonly

  />
</div>
<input type="hidden" value="{{$loan->id}}" name="loan_app_id">
<br>

<div class="mp-pb4 mp-input-group" style="width:50%">
  <label class="mp-input-group__label" >
    Collection Period
  </label>
  <br>

  <input autocomplete="off"
  class="mp-text-field" 
  type="text" 
  id="colfrom"
  name="colfrom"
  style="text-align: center"
  placeholder="MM//DD/YYYY"
  value="{{date('m/d/Y', strtotime($loan->collect_from))}}"
  required 

  />
  &nbsp;
  &nbsp;
  &nbsp;
  TO
  &nbsp;
  &nbsp;
  &nbsp;


  <input autocomplete="off"
  class="mp-text-field" 
  type="text" 
  id="colto"
  name="colto"
  style="text-align: center"
  placeholder="MM//DD/YYYY" 
  value="{{date('m/d/Y', strtotime($loan->collect_to))}}"
  required 

  />
</div>
<br>
<div class="mp-pb4 mp-input-group" style="width:50%">
  <label class="mp-input-group__label" >
    Expected Crediting Day
  </label>

  <input autocomplete="off"
  class="mp-input-group__input mp-text-field" 
  type="text" 
  id="ecd"
  name="ecd"
  style="text-align: center"
  placeholder="MM//DD/YYYY"
  value="{{date('m/d/Y', strtotime($loan->crediting_date))}}"
  required 

  />
</div>

<br>

<div class="mp-text-fs-medium mp-text-center">
 <button type="button" class="mp-button mp-button--accent save" >Done Processing Application</button>
 <br>
 <input type="submit" id="submit_update_application" style="visibility: hidden;">
</div>

{{ Form::close() }}



</div>










<br>
<br>

</div>









</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
  function EnableDisableTextBox(input) {

    var text = document.getElementById(input.id+'_amount');
    var desc = document.getElementById(input.id+'_desc');
    text.disabled = input.checked ? false : true;
    if(input.id=='other1'||input.id=='other2')
    {
      desc.disabled = input.checked ? false : true;
    }
    if (!text.disabled) {
      if(input.id=='other1'||input.id=='other2')
      {
        desc.focus();
      }
      else
      {
        text.focus();
      }
    }


  }
  $( function() {
    $( "#ecd" ).datepicker();
  } );

  $( function() {
    $( "#colfrom" ).datepicker();
  } );

  $( function() {
    $( "#colto" ).datepicker();
  } );


  function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 45 && charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
     return false;

   return true;
 }

 $(document).ready(function(){

   $('.save').on('click',function(e){
     var confirm=true;
     var form_id = $(this).closest("form").attr('id');
     console.log(form_id);

     var approved_amount= $( "#"+form_id+" :input[name='approved_amount']" ).val();
     if(!approved_amount)
     {
       confirm=false;
       $( "#"+form_id+" :input[name='approved_amount']" ).focus();
       Swal.fire({
         type: "warning",
         title: 'Approved Loan Amount is required'      
       })
       return;
     }

     if ($("#"+form_id+" :input[id='out_pel']").is(':checked')) 
     {
       var approved_amount= $( "#"+form_id+" :input[id='out_pel_amount']" ).val();
       if(!approved_amount)
       {
         confirm=false;
         $( "#"+form_id+" :input[id='out_pel_amount']" ).focus();
         Swal.fire({
           type: "warning",
           title: 'Outstanding PEL Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='out_bl']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='out_bl_amount']" ).val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='out_bl_amount']" ).focus();
         Swal.fire({
           type: "warning",
           title: 'Outstanding BL Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='out_eml']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='out_eml_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='out_eml_amount']").focus();
         Swal.fire({
           type: "warning",
           title: 'Outstanding EML Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='out_cbl']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='out_cbl_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='out_cbl_amount']").focus();
         Swal.fire({
           type: "warning",
           title: 'Outstanding CBL Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='int_pel']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='int_pel_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='int_pel_amount']").focus();
         Swal.fire({
           type: "warning",
           title: 'Interest PEL Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='int_bl']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='int_bl_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='int_bl_amount']").focus();
         Swal.fire({
           type: "warning",
           title: 'Interest BL Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='int_eml']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='int_eml_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='int_eml_amount']").focus();
         Swal.fire({
           type: "warning",
           title: 'Interest EML Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='int_cbl']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='int_cbl_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id='int_cbl_amount']").focus();
         Swal.fire({
           type: "warning",
           title: 'Interest CBL Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='surge']").is(':checked')) 
     {
       var approved_amount= $("#"+form_id+" :input[id='surge_amount']").val();
       if(!approved_amount)
       {
         confirm=false;
         $("#"+form_id+" :input[id=surge_amount]").focus();
         Swal.fire({
           type: "warning",
           title: 'Surcharge Amount is required'      
         })
         return;
       }
     }

     if ($("#"+form_id+" :input[id='other1']").is(':checked')) 
     {
      var other_desc=$("#"+form_id+" :input[id='other1_desc']").val();
      var approved_amount= $("#"+form_id+" :input[id='other1_amount']").val();

      if(!other_desc)
      {
       confirm=false;
       $("#"+form_id+" :input[id='other1_desc']").focus();
       Swal.fire({
         type: "warning",
         title: 'Description is required'      
       })
       return;
     }

     if(!approved_amount)
     {
       confirm=false;
       $("#"+form_id+" :input[id='other1_amount']").focus();
       Swal.fire({
         type: "warning",
         title: 'Other Amount is required'      
       })
       return;
     }
   }

   if ($("#"+form_id+" :input[id='other2']").is(':checked')) 
   {
    var other_desc=$("#"+form_id+" :input[id='other2_desc']").val();
    var approved_amount= $("#"+form_id+" :input[id='other2_amount']").val();

    if(!other_desc)
    {
     confirm=false;
     $("#"+form_id+" :input[id='other2_desc']").focus();
     Swal.fire({
       type: "warning",
       title: 'Description is required'      
     })
     return;
   }

   if(!approved_amount)
   {
     confirm=false;
     $("#"+form_id+" :input[id='other2_amount']").focus();
     Swal.fire({
       type: "warning",
       title: 'Other Amount is required'      
     })
     return;
   }
 }

 var approved_amount= $( "#"+form_id+" :input[name='monthly_amort']" ).val();
 if(!approved_amount)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='monthly_amort']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Monthly Amortization is required'      
   })
   return;
 }

 var approved_amount= $( "#"+form_id+" :input[name='net_proceeds']" ).val();
 if(!approved_amount)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='net_proceeds']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Net Proceeds is required'      
   })
   return;
 }

 var ecd= $( "#"+form_id+" :input[name='colfrom']" ).val();
 if(!ecd)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='colfrom']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Collecting Date "From" is required'      
   })
   return;
 }

 var ecd= $( "#"+form_id+" :input[name='colto']" ).val();
 if(!ecd)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='colto']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Collecting Date "To" is required'      
   })
   return;
 }


 var ecd= $( "#"+form_id+" :input[name='ecd']" ).val();
 if(!ecd)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='ecd']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Expected Crediting Day is required'      
   })
   return;
 }

 if(confirm)
 {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to submit this form?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit'
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#submit_'+form_id).trigger('click');

      }
    })
  }
})

$('.cancel').on('click',function(e){
  var confirm=true;
  var form_id = $(this).closest("form").attr('id');

  console.log(form_id);

  var reason= $( "#"+form_id+" :input[name='reason']" ).val();
  console.log(reason);
  if(!reason)
  {
   confirm=false;
   $( "#"+form_id+" :input[name='reason']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Reason for Cancellation is required'      
   })
   return;
 }

 if(confirm)
 {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to cancel the application?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Cancel Application',
      cancelButtonText: 'Go Back',
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#submit_'+form_id).trigger('click');

      }
    })
  }

})


// auto compute net proceeds

$( "input[name='approved_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});

$( "input[name='out_pel_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='out_eml_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='out_cbl_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='out_bl_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});


$( "input[name='int_pel_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='int_eml_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='int_cbl_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='int_bl_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});



$( "input[name='surge_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='other1_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});
$( "input[name='other2_amount']").change(function() {
 var form_id = $(this).closest("form").attr('id');
 compute_net(form_id);
});


function compute_net(form_id) {

  if($( "#"+form_id+" :input[name='approved_amount']" ).val())
  {
   var approved_amount= $( "#"+form_id+" :input[name='approved_amount']" ).val().replace(/,/g, '');
 }
 else
 {
   var approved_amount= 0;
 }

 var servicefee_amount= $( "#"+form_id+" :input[name='servicefee_amount']" ).val().replace(/,/g, '');

 if($( "#"+form_id+" :input[name='out_pel_amount']" ).val())
 {
   var out_pel_amount= $( "#"+form_id+" :input[name='out_pel_amount']" ).val().replace(/,/g, '');
 }
 else
 {
   var out_pel_amount= 0;
 }

 if($( "#"+form_id+" :input[name='out_eml_amount']" ).val())
 {
   var out_eml_amount= $( "#"+form_id+" :input[name='out_eml_amount']" ).val().replace(/,/g, '');
 }
 else
 {
   var out_eml_amount= 0;
 }

 if($( "#"+form_id+" :input[name='out_bl_amount']" ).val())
 {
   var out_bl_amount= $( "#"+form_id+" :input[name='out_bl_amount']" ).val().replace(/,/g, '');
 }
 else
 {
   var out_bl_amount= 0;
 }

 if($( "#"+form_id+" :input[name='out_cbl_amount']" ).val())
 {
   var out_cbl_amount= $( "#"+form_id+" :input[name='out_cbl_amount']" ).val().replace(/,/g, '');
 }
 else
 {
   var out_cbl_amount= 0;
 }
//

if($( "#"+form_id+" :input[name='int_pel_amount']" ).val())
{
 var int_pel_amount= $( "#"+form_id+" :input[name='int_pel_amount']" ).val().replace(/,/g, '');
}
else
{
 var int_pel_amount= 0;
}

if($( "#"+form_id+" :input[name='int_eml_amount']" ).val())
{
 var int_eml_amount= $( "#"+form_id+" :input[name='int_eml_amount']" ).val().replace(/,/g, '');
}
else
{
 var int_eml_amount= 0;
}

if($( "#"+form_id+" :input[name='int_bl_amount']" ).val())
{
 var int_bl_amount= $( "#"+form_id+" :input[name='int_bl_amount']" ).val().replace(/,/g, '');
}
else
{
 var int_bl_amount= 0;
}

if($( "#"+form_id+" :input[name='int_cbl_amount']" ).val())
{
 var int_cbl_amount= $( "#"+form_id+" :input[name='int_cbl_amount']" ).val().replace(/,/g, '');
}
else
{
 var int_cbl_amount= 0;
}

if($( "#"+form_id+" :input[name='other1_amount']" ).val())
{
 var other1_amount= $( "#"+form_id+" :input[name='other1_amount']" ).val().replace(/,/g, '');
}
else
{
 var other1_amount= 0;
}

if($( "#"+form_id+" :input[name='other2_amount']" ).val())
{
 var other2_amount= $( "#"+form_id+" :input[name='other2_amount']" ).val().replace(/,/g, '');
}
else
{
 var other2_amount= 0;
}

if($( "#"+form_id+" :input[name='surge_amount']" ).val())
{
 var surge_amount= $( "#"+form_id+" :input[name='surge_amount']" ).val().replace(/,/g, '');
}
else
{
 var surge_amount= 0;
}



var total_de=parseFloat(out_pel_amount) + parseFloat(out_bl_amount) + parseFloat(servicefee_amount) + parseFloat(out_eml_amount) + parseFloat(out_cbl_amount) + parseFloat(int_cbl_amount) + parseFloat(int_bl_amount) + parseFloat(int_eml_amount) + parseFloat(int_pel_amount) + parseFloat(other1_amount) + parseFloat(other2_amount) + parseFloat(surge_amount);

$( "#"+form_id+" :input[name='net_proceeds']" ).val(approved_amount-total_de);
}

});


</script>