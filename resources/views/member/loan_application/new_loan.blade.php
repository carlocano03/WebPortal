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
      <a href="{{url('/member/loan-app')}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Loan Application</span>
      </a>
    </div>
    <div class="col-12  mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">
        Loan Application
      </div>
    </div>
  </div>
  <div class="row no-gutters mp-mb4 justify-content-center">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
        <input type="hidden" id="PEL_count" value="{{$pel_count}}">
        <input type="hidden" id="BL_count" value="{{$bl_count}}">
        <input type="hidden" id="EML_count" value="{{$eml_count}}">
        <input type="hidden" id="CBL_count" value="{{$cbl_count}}">
        <input type="hidden" id="BTL_count" value="{{$btl_count}}">
        <div align="center">
          <div class="mp-mb3 mp-text-fw-heavy">Total Member's Equity: &nbsp;&nbsp;&nbsp;&nbsp; PHP {{ number_format($equity->total,2) }}</div>
          <div class="col-6 mp-pb4 mp-input-group">
            <label class="mp-input-group__label" for="Loan Type">
              Loan Type
            </label>

            <select class="mp-input-group__input mp-text-field divselect" id="selecttype">
              <option value="" disabled selected>SELECT LOAN TYPE</option>
              <option value="PEL">Personal Equity Loan (PEL)</option>
              <option value="EML">Emergency Loan (EML)</option>
              <option value="BL">Bridge Loan (BL)</option>
              <option value="BTL">Balance Transfer Loan (BTL)</option>
              <option value="CBL">Co-Borrower Loan (CBL)</option>
            </select>
          </div>
          <input type="hidden" value="{!! asset('assets/images/') !!}" id="path">
          <span id="link">
           Please click here to know the different types of UP Provident Fund's <a class="mp-link mp-link--primary" target="_blank" href="https://www.upprovidentfund.com/loans/">Loan Products</a>.
         </span>

       </div>
       <div class="PEL DIV">

         <div id="bank_det" align="center">
          <div class="col-6 mp-pb4 mp-input-group">


            <label class="mp-input-group__label" for="Loan Type">
              Type
            </label>

            <select class="mp-input-group__input mp-text-field pelselect" name="type" placeholder="" required>
             <option value="" disabled selected>NEW LOAN OR LOAN RENEWAL</option>
             <option value="NEW">New Loan</option>
             <option value="RENEWAL">Loan Renewal (Re-Loan)</option>
           </select>
           <br>
           <?php
           $years=intval($years);
           if($years<4)
           {

             $max=(75/100) * $equity->total;
           }
           elseif($years>=15)
           {

            $max=$equity->total;
          }
          else
          {

            $max= (85/100) * $equity->total;
          }

          $max=round($max,2);

          ?>
          <div class="mp-mb3 mp-text-fw-heavy">Max PEL Loanable Amount: &nbsp;&nbsp;&nbsp;&nbsp; PHP {{ number_format($max,2) }}</div>
        </div>
        {{ Form::open(array('url' => '/member/pel-loan-new', 'method' => 'post', 'id'=>'save_pel', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
        <div class="NEW PELDIV">
          <input type="hidden" value="{{$max}}" name="max">
          <strong style="">Step 1. Please input your desired loan amount. <span data-md-tooltip="The final approved loan amount will depend on your ability to pay the monthly amortization depending on your Net Pay."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
          <label for="lname">Amount Requested:</label>
          <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="amount" name="amount" style="width:30%;"  max="{{$max}}" required onkeypress="return isNumber(event)">
          <br>
          <br>
          <strong style="">Step 2. Please choose the bank where you want your loan proceeds deposited.</strong><br>
          <label class="radio-inline"><input type="radio" name="bank"  id="bank"  value="LB" required>Land Bank of the Philippines (LBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label class="radio-inline"><input type="radio" name="bank"  id="bank" value="PNB"  >Philippine National Bank (PNB)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label class="radio-inline"><input type="radio" name="bank" id="bank"  value="DBP"  >Development Bank of the Philippines (DBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label class="radio-inline"><input type="radio" name="bank"  id="bank" value="Veterans"  >Philippine Veterans Bank (PVB)</label>
          <br>
          <br>
          <strong >Step 3. Input the Account Number and Account Name. <span data-md-tooltip="Incorrect account number/account name will be charged P200.00 for re-processing of loan. If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
          <label for="fname">Account Number:</label>
          <input type="text" id="acc_num" name="acc_num" onpaste="return false" style="width:30%;"  required onkeypress="return isNumber(event)">&nbsp;&nbsp;
          <label data-md-tooltip="If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund" for="lname">Account Name:</label>
          <input type="text" id="acc_name" name="acc_name" onpaste="return false" onpaste="return false" onpaste="return false" style="width:30%;"  required><br><br>


          <div class="form-group col-12">

           <strong style="">Step 4. Please attach a soft copy (photo or scanned document) of the following required documents.</strong>     <br>
           <br>
           <label class="col-6" for="album_cover">I. UP Employee ID or any valid government-issued ID (driver's license, passport, GSIS UMID, Philhealth, etc.)
           </label>
           <br>


           <input type="file" required class="form-control" onchange="readURL(this);" id="identification" name="identification" style="width:40%">


           <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


         </div>
         <br>
         <div class="form-group col-12">
          <label class="col-6" for="album_cover">II. Last 2 months latest payslip
          </label>
          <label class="col-6" for="album_cover">Payslip 1:
          </label>
          <br>


          <input type="file" required class="form-control" onchange="readURL(this);" id="payslip1" name="payslip1" style="width:40%">


          <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


        </div>
        <br>
        <div class="form-group col-12">
          <label class="col-6" for="album_cover">Payslip 2:
          </label>
          <br>


          <input type="file" required class="form-control" onchange="readURL(this);" id="payslip2" name="payslip2" style="width:40%">


          <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


        </div>
        <br>
        <br>
        <div class="form-group col-12">
          <label class="col-6" for="album_cover">III. Passbook / ATM / any document or proof showing bank Account Number where loan proceeds will be deposited.

          </label>
          <br>


          <input type="file" required class="form-control" onchange="readURL(this);" id="passbook" name="passbook" style="width:40%">


          <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


        </div>
        <br>
        <br>
        <strong style="">Step 5. Please input your active email and contact number. <span data-md-tooltip="Our Account Analyst will contact you through this platforms."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
        <br>
        <label for="lname">Active Email:</label>
        <input type="email" id="email" name="email" style="width:30%;"  value='{{getUserdetails()->email}}' required >
        <label for="lname">Active Mobile Number: +63</label>
        <input type="text" value='{{getUserdetails()->contact_no}}' onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" id="c_number" name="c_number" style="width:30%;"  required onkeypress="return isNumber(event)">
        <br>
        <input type="checkbox" id="update_profile" name="update_profile">
        <label for="male">Check this box if you want to replace your existing contact details in the Profile page with this new active email or mobile number.</label><br>


        <div class="mp-pt3 " align="center">
          <div class="col col-auto">
            <button type="button" id="form_submit" value="Submit" class="mp-button mp-button--accent save">Submit</button>
            <input type="submit" id="sumbit_save_pel" style="visibility: hidden;">
          </div>
        </div>
        {{ Form::close() }}

      </div>
      {{ Form::open(array('url' => '/member/pel-loan-renew', 'method' => 'post', 'id'=>'save_pel_renew', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
      <div class="RENEWAL PELDIV">
        <strong style="">Step 1. Please choose if you want your re-loan amount to be "Full Equity" or "Same Deduction". </strong>     <br>
        <label class="radio-inline"><input  type="radio" name="renewal_option"  value="FULL EQUITY" required>FULL EQUITY <span data-md-tooltip="Re-loan amount may be higher depending on the updated amount of your Member's Equity and net pay
          "><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label class="radio-inline"><input type="radio" name="renewal_option" value="SAME DEDUCTION"  >SAME DEDUCTION <span data-md-tooltip="Re-loan amount will be the same as your current loan or higher if loan period is extended"><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <br>
          <br>
          <strong style="">Step 2. Please choose the bank where you want your loan proceeds deposited.</strong><br>
          <label class="radio-inline"><input type="radio" name="bank" id="bank" value="LB" required>Land Bank of the Philippines (LBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label class="radio-inline"><input type="radio" name="bank" id="bank" value="PNB"  >Philippine National Bank (PNB)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

          <label class="radio-inline"><input type="radio" name="bank" id="bank" value="DBP"  >Development Bank of the Philippines (DBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label class="radio-inline"><input type="radio" name="bank" id="bank" value="Veterans"  >Philippine Veterans Bank (PVB)</label>
          <br>
          <br>
          <strong >Step 3. Input the Account Number and Account Name. <span data-md-tooltip="Incorrect account number/account name will be charged P200.00 for re-processing of loan. If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
          <label  for="fname">Account Number:</label>
          <input type="text" id="acc_num" name="acc_num" onpaste="return false" onpaste="return false" style="width:30%;"  required onkeypress="return isNumber(event)">&nbsp;&nbsp;
          <label data-md-tooltip="If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund" for="lname">Account Name:</label>
          <input type="text" id="acc_name" name="acc_name" onpaste="return false" onpaste="return false" style="width:30%;"  required><br><br>


          <div class="form-group col-12">

           <strong style="">Step 4. Please attach a soft copy (photo or scanned document) of the following required documents.</strong>     <br>
           <br>
           <label class="col-6" for="album_cover">I. UP Employee ID or any valid government-issued ID (driver's license, passport, GSIS UMID, Philhealth, etc.)
           </label>
           <br>


           <input type="file" required class="form-control" onchange="readURL(this);" id="identification" name="identification" style="width:40%">


           <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


         </div>
         <br>
         <div class="form-group col-12">
          <label class="col-6" for="album_cover">II. Last 2 months latest payslip
          </label>
          <label class="col-6" for="album_cover">Payslip 1:
          </label>
          <br>


          <input type="file" required class="form-control" onchange="readURL(this);" id="payslip1" name="payslip1" style="width:40%">


          <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


        </div>
        <br>
        <div class="form-group col-12">
          <label class="col-6" for="album_cover">Payslip 2:
          </label>
          <br>


          <input type="file" required class="form-control" onchange="readURL(this);" id="payslip2" name="payslip2" style="width:40%">


          <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


        </div>
        <br>
        <br>
        <div class="form-group col-12">
          <label class="col-6" for="album_cover">III. Passbook / ATM / any document or proof showing bank Account Number where loan proceeds will be deposited. <span data-md-tooltip="Incorrect account number/account name will be charged P200.00 for re-processing of loan. If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span>

          </label>
          <br>


          <input type="file" required class="form-control" onchange="readURL(this);" id="passbook" name="passbook" style="width:40%">


          <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


        </div>

        <br>
        <br>
        <strong style="">Step 5. Please input your active email and contact number. <span data-md-tooltip="Our Account Analyst will contact you through this platforms."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
        <br>
        <label for="lname">Active Email:</label>
        <input type="email" id="email" name="email" value='{{getUserdetails()->email}}' style="width:30%;"  required >
        <label for="lname">Active Mobile Number: +63</label>
        <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" id="c_number" name="c_number" style="width:30%;"  value='{{getUserdetails()->contact_no}}' required onkeypress="return isNumber(event)">
        <br>
        <input type="checkbox" id="update_profile" name="update_profile">
        <label for="male">Check this box if you want to replace your existing contact details in the Profile page with this new active email or mobile number.</label><br>

        <div class="mp-pt3 " align="center">
          <div class="col col-auto">
            <button type="button" id="form_submit" value="Submit" class="mp-button mp-button--accent save">Submit</button>
            <input type="submit" id="sumbit_save_pel_renew" style="visibility: hidden;">

          </div>
        </div>
        {{ Form::close() }}
      </div>



    </div>
  </div> 


    <!-- <div class="col-6 mp-pb4 mp-input-group">
      <label class="mp-input-group__label" for="Loan Type">
        Type
      </label>

      <select class="mp-input-group__input mp-text-field emlselect" name="renewal_option">
        <option value="" disabled selected>NEW LOAN OR LOAN RENEWAL</option>
        <option value="NEW">NEW LOAN</option>
        <option value="RENEWAL">LOAN RENEWAL (Re-Loan)</option>
      </select>
    </div> -->
    
    <div class="EML DIV">
      {{ Form::open(array('url' => '/member/eml-loan-new', 'method' => 'post', 'id'=>'save_eml', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
      <div id="bank_det" align="center">

        <strong style="">Step 1. Please input your desired loan amount.</strong><br>
        <strong style="">Maximum loanable amount is P10,000 <span data-md-tooltip="Your loanable amount will depend on your remaining Equity and existing loan balances."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong>
        <br>        
        <label for="lname">Amount Requested:</label>
        <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="amount" name="amount" style="width:30%;" max="10000" required onkeypress="return isNumber(event)"><br><br>
        <strong style="">Step 2. Please choose the bank where you want your loan proceeds deposited.</strong><br>
        <label class="radio-inline"><input type="radio" name="bank"  value="LB" required>Land Bank of the Philippines (LBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label class="radio-inline"><input type="radio" name="bank" value="PNB"  >Philippine National Bank (PNB)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <label class="radio-inline"><input type="radio" name="bank" value="DBP"  >Development Bank of the Philippines (DBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <label class="radio-inline"><input type="radio" name="bank" value="Veterans"  >Philippine Veterans Bank (PVB)</label>
        <br>
        <br>
        <strong >Step 3. Input the Account Number and Account Name. <span data-md-tooltip="Incorrect account number/account name will be charged P200.00 for re-processing of loan. If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
        <label for="fname">Account Number:</label>
        <input type="text" id="acc_num" name="acc_num" onpaste="return false" style="width:30%;"  required onkeypress="return isNumber(event)">&nbsp;&nbsp;
        <label for="lname">Account Name:</label>
        <input type="text" id="acc_name" name="acc_name" onpaste="return false" style="width:30%;"  required><br><br>
        

        <div class="form-group col-12">

         <strong style="">Step 4. Please attach a soft copy (photo or scanned document) of the following required documents.</strong>     <br>
         <br>
         <label class="col-6" for="album_cover">I. UP Employee ID or any valid government-issued ID (driver's license, passport, GSIS UMID, Philhealth, etc.)
         </label>
         <br>


         <input type="file" required class="form-control" onchange="readURL(this);" id="identification" name="identification" style="width:40%">


         <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


       </div>
       <br>
       <div class="form-group col-12">
        <label class="col-6" for="album_cover">II. Last 2 months latest payslip
        </label>
        <label class="col-6" for="album_cover">Payslip 1:
        </label>
        <br>


        <input type="file" required class="form-control" onchange="readURL(this);" id="payslip1" name="payslip1" style="width:40%">


        <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


      </div>
      <br>
      <div class="form-group col-12">
        <label class="col-6" for="album_cover">Payslip 2:
        </label>
        <br>


        <input type="file" required class="form-control" onchange="readURL(this);" id="payslip2" name="payslip2" style="width:40%">


        <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


      </div>
      <br>
      <br>
      <div class="form-group col-12">
        <label class="col-6" for="album_cover">III. Passbook / ATM / any document or proof showing bank Account Number where loan proceeds will be deposited.

        </label>
        <br>


        <input type="file" required class="form-control" onchange="readURL(this);" id="passbook" name="passbook" style="width:40%">


        <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


      </div>

      <br>
      <br>
      <strong style="">Step 5. Please input your active email and contact number. <span data-md-tooltip="Our Account Analyst will contact you through this platforms."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
      <br>
      <label for="lname">Active Email:</label>
      <input type="email" id="email" name="email" value='{{getUserdetails()->email}}' style="width:30%;"  required >
      <label for="lname">Active Mobile Number: +63</label>
      <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" id="c_number" name="c_number" style="width:30%;"  value='{{getUserdetails()->contact_no}}' required onkeypress="return isNumber(event)">

      <br>
      <input type="checkbox" id="update_profile" name="update_profile">
      <label for="male">Check this box if you want to replace your existing contact details in the Profile page with this new active email or mobile number.</label><br>



      <div class="mp-pt3 " align="center">
        <div class="col col-auto">
          <button type="button" id="form_submit" value="Submit" class="mp-button mp-button--accent save">Submit</button>
          <input type="submit" id="sumbit_save_eml" style="visibility: hidden;">

        </div>
      </div>
      {{ Form::close() }}
    </div>

  </div>


    <!-- 
        <div class="col-6 mp-pb4 mp-input-group">
          <label class="mp-input-group__label" for="Loan Type">
            Type
          </label>

          <select class="mp-input-group__input mp-text-field emlselect" name="gender">
            <option value="" disabled selected>NEW LOAN OR LOAN RENEWAL</option>
            <option value="NEW">NEW LOAN</option>
            <option value="RENEWAL">LOAN RENEWAL (Re-Loan)</option>
          </select>
        </div> -->
        <div class="BL DIV">
          <div id="bank_det" align="center">
            {{ Form::open(array('url' => '/member/bl-loan-new', 'method' => 'post', 'id'=>'save_bl', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
            <strong style="">Please fill-up the necessary informations and upload the required attachments</strong>     <br>
            <br>
            <strong style="">Step 1. Please input your desired loan amount.</strong><br>
            <strong style="">Maximum loanable amount is P20,000 <span data-md-tooltip="Your loanable amount will depend on your remaining Equity and existing loan balances."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong>
            <br>
            <label for="lname">Amount Requested:</label>
            <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="amount" name="amount" style="width:30%;" max="20000" required onkeypress="return isNumber(event)"><br><br>
            <strong style="">Step 2. Please choose the bank where you want your loan proceeds deposited.</strong><br>
            <label class="radio-inline"><input type="radio" name="bank"  value="LB" required>Land Bank of the Philippines (LBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="radio-inline"><input type="radio" name="bank" value="PNB"  >Philippine National Bank (PNB)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label class="radio-inline"><input type="radio" name="bank" value="DBP"  >Development Bank of the Philippines (DBP)</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="radio-inline"><input type="radio" name="bank" value="Veterans"  >Philippine Veterans Bank (PVB)</label>
            <br>
            <br>
            <strong >Step 3. Input the Account Number and Account Name. <span data-md-tooltip="Incorrect account number/account name will be charged P200.00 for re-processing of loan. If Account Name is different from your name or loan proceeds will be deposited to a bank account of another person, please submit a signed Authorization Form and copy of your ID to UP Provident Fund."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
            <label for="fname">Account Number:</label>
            <input type="text" id="acc_num" name="acc_num" onpaste="return false" style="width:30%;"  required onkeypress="return isNumber(event)">&nbsp;&nbsp;
            <label for="lname">Account Name:</label>
            <input type="text" id="acc_name" name="acc_name" onpaste="return false" style="width:30%;"  required><br><br>
            

            <div class="form-group col-12">

             <strong style="">Step 4. Please attach a soft copy (photo or scanned document) of the following required documents.</strong>     <br>
             <br>
             <label class="col-6" for="album_cover">I. UP Employee ID or any valid government-issued ID (driver's license, passport, GSIS UMID, Philhealth, etc.)
             </label>
             <br>


             <input type="file" required class="form-control" onchange="readURL(this);" id="identification" name="identification" style="width:40%">


             <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


           </div>
           <br>
           <div class="form-group col-12">
            <label class="col-6" for="album_cover">II. Last 2 months latest payslip
            </label>
            <label class="col-6" for="album_cover">Payslip 1:
            </label>
            <br>


            <input type="file" required class="form-control" onchange="readURL(this);" id="payslip1" name="payslip1" style="width:40%">


            <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


          </div>
          <br>
          <div class="form-group col-12">
            <label class="col-6" for="album_cover">Payslip 2:
            </label>
            <br>


            <input type="file" required class="form-control" onchange="readURL(this);" id="payslip2" name="payslip2" style="width:40%">


            <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


          </div>
          <br>
          <br>
          <div class="form-group col-12">
            <label class="col-6" for="album_cover">III. Passbook / ATM / any document or proof showing bank Account Number where loan proceeds will be deposited.

            </label>
            <br>


            <input type="file" required class="form-control" onchange="readURL(this);" id="passbook" name="passbook" style="width:40%">


            <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />


          </div>

          <br>
          <br>
          <strong style="">Step 5. Please input your active email and contact number. <span data-md-tooltip="Our Account Analyst will contact you through this platforms."><i class="fa fa-info-circle" aria-hidden="true"  ></i></span></strong><br>
          <br>
          <label for="lname">Active Email:</label>
          <input type="email" id="email" name="email" value='{{getUserdetails()->email}}' style="width:30%;"  required >
          <label for="lname">Active Mobile Number: +63</label>
          <input type="text" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="10" id="c_number" name="c_number" style="width:30%;"  value='{{getUserdetails()->contact_no}}' required onkeypress="return isNumber(event)">

          <br>
          <input type="checkbox" id="update_profile" name="update_profile">
          <label for="male">Check this box if you want to replace your existing contact details in the Profile page with this new active email or mobile number.</label><br>


          <div class="mp-pt3 " align="center">
            <div class="col col-auto">
             <button type="button" id="form_submit" value="Submit" class="mp-button mp-button--accent save">Submit</button>
             <input type="submit" id="sumbit_save_bl" style="visibility: hidden;">

           </div>
         </div>
         {{ Form::close() }}



       </div>

     </div>


     <div class="BTL DIV"><strong style=";">COMING SOON</strong> <br>We're working to have the online Balance Transfer Loan application available soon. If you want to avail of a Balance Transfer Loan (BTL) now, we will gladly assist you so please contact our campus cluster offices. Maraming salamat po!</div>

     <div class="CBL DIV"><strong style=";">COMING SOON</strong> <br>We're working to have the online Co-Borrower Loan application available soon. If you want to avail of a Co-Borrower Loan (CBL) now, we will gladly assist you so please contact our campus cluster offices. Maraming salamat po!</div>

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


  $(document).ready(function(){

   if($(".divselect").val()==null)
   {
    $("#link").show();
  }

  $('form#save_pel').submit(function(){
    $(this).find(':input[type=submit]').prop('disabled', true);
  });

  $('form#save_bl').submit(function(){
    $(this).find(':input[type=submit]').prop('disabled', true);
  });

  $('form#save_eml').submit(function(){
    $(this).find(':input[type=submit]').prop('disabled', true);
  });

  $(".divselect").change(function(){


    $(".PELDIV").hide();
    $(".EMLDIV").hide();
    $(".BLDIV").hide();
    $(this).find("option:selected").each(function(){
      var optionValue = $(this).attr("value");
      var count = $('#'+optionValue+'_count').val();     
      var type_desc = $( "#selecttype option:selected" ).text();
      if (optionValue=='EML')
      {
        var warningtxt = 'an '+type_desc;
      }
      else
      {
        var warningtxt = 'a '+type_desc;
      }

      if(count>0)
      {
       Swal.fire({
         type: "warning",
         title: 'Sorry, you have already submitted '+warningtxt+' that is currently being processed by UP Provident Fund. Please wait for updates regarding that application before submitting a new '+optionValue+'.'      
       })
     }
     else
     {


      if(optionValue){

       $(".DIV").not("." + optionValue).hide();
       $("." + optionValue).show();
       $("#link").hide();
     } else{
      $(".DIV").hide();
    }
  }
});
  }).change();

  $(".pelselect").change(function(){

    $(this).find("option:selected").each(function(){
      var optionValue = $(this).attr("value");
      if(optionValue){
        $(".PELDIV").not("." + optionValue).hide();
        $("." + optionValue).show();
        $("#link").hide();
      } else{
        $(".PELDIV").hide();
      }
    });
  }).change();

  $(".emlselect").change(function(){

    $(this).find("option:selected").each(function(){
      var optionValue = $(this).attr("value");

      if(optionValue){
        $(".EMLDIV").not("." + optionValue).hide();
        $("." + optionValue).show();
        $("#link").hide();
      } else{
        $(".EMLDIV").hide();
      }
    });
  }).change();

  $(".blselect").change(function(){

    $(this).find("option:selected").each(function(){
      var optionValue = $(this).attr("value");
      if(optionValue){
        $(".BLDIV").not("." + optionValue).hide();
        $("." + optionValue).show();
        $("#link").hide();
      } else{
        $(".BLDIV").hide();
      }
    });
  }).change();


  $('.save').on('click',function(e){

   var confirm=true;
   var form_id = $(this).closest("form").attr('id');

   if(form_id=='save_pel')
   {

    var amount=$( "#"+form_id+" :input[name='amount']" ).val();
    var max=$( "#"+form_id+" :input[name='max']" ).val();
    
    
    if(amount==0 || amount==" ")
    {
      confirm=false;
      $( "#"+form_id+" :input[name='amount']" ).focus();
      Swal.fire({
       type: "warning",
       title: 'Requested Amount is required',
       width: "400px",  

     })
      return;

    }
    else{
      amount=parseFloat($( "#"+form_id+" :input[name='amount']" ).val())
      if(amount>max)
      {
        confirm=false;
        $( "#"+form_id+" :input[name='amount']" ).focus();
        Swal.fire({
         type: "warning",
         title: 'Requested Amount should not be greater than Loanable Amount (P '+parseFloat(max).toLocaleString('en')+')'      
       })
        return;
      }
    }

    var bank= $( "#"+form_id+" :input[name='bank']:checked" ).val();
    if(bank==undefined)
    {
     confirm=false;
     document.forms[form_id].elements["bank"][0].focus();

     Swal.fire({
       type: "warning",
       title: 'Please choose a bank'      
     })
     return;
   }

   var acc_num= $( "#"+form_id+" :input[name='acc_num']" ).val();


   if(!acc_num)
   {
     confirm=false;
     $( "#"+form_id+" :input[name='acc_num']" ).focus();
     Swal.fire({
       type: "warning",
       title: 'Account Number is required'      
     })
     return;
   }
   else
   {
    var acc_num_length=$( "#"+form_id+" :input[name='acc_num']" ).val().length;
    if(acc_num_length<10)
    {
      confirm=false;
      $( "#"+form_id+" :input[name='acc_num']" ).focus();
      Swal.fire({
       type: "warning",
       title: 'Account Number should be atleast 10 Digits or more'      
     })
      return;
    }
  }


  var acc_name= $( "#"+form_id+" :input[name='acc_name']" ).val();


  if(!acc_name)
  {
   confirm=false;
   $( "#"+form_id+" :input[name='acc_name']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Account Name is required'      
   })
   return;
 }

 var id= $( "#"+form_id+" :input[name='identification']" ).val();

 if(!id)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='identification']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'ID is required'      
   })
   return;
 }

 var pay1= $( "#"+form_id+" :input[name='payslip1']" ).val();

 if(!pay1)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='payslip1']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Payslip 1 is required'      
   })
   return;
 }

 var pay2= $( "#"+form_id+" :input[name='payslip2']" ).val();

 if(!pay2)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='payslip2']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Payslip 2 is required'      
   })
   return;
 }

 var pass= $( "#"+form_id+" :input[name='passbook']" ).val();

 if(!pass)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='passbook']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Passbook / ATM / any document or proof showing bank Account Number is required'      
   })
   return;
 }

 var email= $( "#"+form_id+" :input[name='email']" ).val();

 if(!email)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='email']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Active email is required'      
   })
   return;
 }

 var c_number= $( "#"+form_id+" :input[name='c_number']" ).val();

 if(!c_number)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='c_number']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Active contact number is required'      
   })
   return;
 }
 else
 {
  var c_number_length=$( "#"+form_id+" :input[name='c_number']" ).val().length;
  if(c_number_length!=10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='c_number']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Active Mobile Numbers should be 10 digits'      
   })
    return;
  }
}




}

if(form_id=='save_pel_renew')
{



 var renewal_option= $( "#"+form_id+" :input[name='renewal_option']:checked" ).val();
 if(renewal_option==undefined)
 {
   confirm=false;
   document.forms[form_id].elements["renewal_option"][0].focus();

   Swal.fire({
     type: "warning",
     title: 'Renewal Option is required'      
   })
   return;
 }

 var bank= $( "#"+form_id+" :input[name='bank']:checked" ).val();
 if(bank==undefined)
 {
   confirm=false;
   document.forms[form_id].elements["bank"][0].focus();

   Swal.fire({
     type: "warning",
     title: 'Please choose a bank'      
   })
   return;
 }

 var acc_num= $( "#"+form_id+" :input[name='acc_num']" ).val();


 if(!acc_num)
 {
   confirm=false;
   $( "#"+form_id+" :input[name='acc_num']" ).focus();
   Swal.fire({
     type: "warning",
     title: 'Account Number is required'      
   })
   return;
 }
 else
 {
  var acc_num_length=$( "#"+form_id+" :input[name='acc_num']" ).val().length;
  if(acc_num_length<10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='acc_num']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Account Number should be atleast 10 Digits or more'      
   })
    return;
  }
}



var acc_name= $( "#"+form_id+" :input[name='acc_name']" ).val();


if(!acc_name)
{
 confirm=false;
 $( "#"+form_id+" :input[name='acc_name']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Account Name is required'      
 })
 return;
}

var id= $( "#"+form_id+" :input[name='identification']" ).val();

if(!id)
{
 confirm=false;
 $( "#"+form_id+" :input[name='identification']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'ID is required'      
 })
 return;
}

var pay1= $( "#"+form_id+" :input[name='payslip1']" ).val();

if(!pay1)
{
 confirm=false;
 $( "#"+form_id+" :input[name='payslip1']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Payslip 1 is required'      
 })
 return;
}

var pay2= $( "#"+form_id+" :input[name='payslip2']" ).val();

if(!pay2)
{
 confirm=false;
 $( "#"+form_id+" :input[name='payslip2']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Payslip 2 is required'      
 })
 return;
}

var pass= $( "#"+form_id+" :input[name='passbook']" ).val();

if(!pass)
{
 confirm=false;
 $( "#"+form_id+" :input[name='passbook']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Passbook / ATM / any document or proof showing bank Account Number is required'      
 })
 return;
}

var email= $( "#"+form_id+" :input[name='email']" ).val();

if(!email)
{
 confirm=false;
 $( "#"+form_id+" :input[name='email']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Active email is required'      
 })
 return;
}

var c_number= $( "#"+form_id+" :input[name='c_number']" ).val();

if(!c_number)
{
 confirm=false;
 $( "#"+form_id+" :input[name='c_number']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Active contact number is required'      
 })
 return;
}
else
{
  var c_number_length=$( "#"+form_id+" :input[name='c_number']" ).val().length;
  if(c_number_length!=10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='c_number']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Active Mobile Numbers should be 10 digits'      
   })
    return;
  }
}



}

if(form_id=='save_eml')
{
 var amount=$( "#"+form_id+" :input[name='amount']" ).val();
 var max=10000;


 if(amount==0 || amount==" ")
 {
  confirm=false;
  $( "#"+form_id+" :input[name='amount']" ).focus();
  Swal.fire({
   type: "warning",
   title: 'Requested Amount is required',
   width: "400px",  

 })
  return;

}
else{
  amount=parseFloat($( "#"+form_id+" :input[name='amount']" ).val())
  if(amount>max)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='amount']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Requested Amount should not be greater than Loanable Amount (P '+parseFloat(max).toLocaleString('en')+')'      
   })
    return;
  }
}


var bank= $( "#"+form_id+" :input[name='bank']:checked" ).val();
if(bank==undefined)
{
 confirm=false;
 document.forms[form_id].elements["bank"][0].focus();

 Swal.fire({
   type: "warning",
   title: 'Please choose a bank'      
 })
 return;
}

var acc_num= $( "#"+form_id+" :input[name='acc_num']" ).val();


if(!acc_num)
{
 confirm=false;
 $( "#"+form_id+" :input[name='acc_num']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Account Number is required'      
 })
 return;
}
else
{
  var acc_num_length=$( "#"+form_id+" :input[name='acc_num']" ).val().length;
  if(acc_num_length<10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='acc_num']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Account Number should be atleast 10 Digits or more'      
   })
    return;
  }
}


var acc_name= $( "#"+form_id+" :input[name='acc_name']" ).val();


if(!acc_name)
{
 confirm=false;
 $( "#"+form_id+" :input[name='acc_name']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Account Name is required'      
 })
 return;
}

var id= $( "#"+form_id+" :input[name='identification']" ).val();

if(!id)
{
 confirm=false;
 $( "#"+form_id+" :input[name='identification']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'ID is required'      
 })
 return;
}

var pay1= $( "#"+form_id+" :input[name='payslip1']" ).val();

if(!pay1)
{
 confirm=false;
 $( "#"+form_id+" :input[name='payslip1']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Payslip 1 is required'      
 })
 return;
}

var pay2= $( "#"+form_id+" :input[name='payslip2']" ).val();

if(!pay2)
{
 confirm=false;
 $( "#"+form_id+" :input[name='payslip2']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Payslip 2 is required'      
 })
 return;
}

var pass= $( "#"+form_id+" :input[name='passbook']" ).val();

if(!pass)
{
 confirm=false;
 $( "#"+form_id+" :input[name='passbook']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Passbook / ATM / any document or proof showing bank Account Number is required'      
 })
 return;
}

var email= $( "#"+form_id+" :input[name='email']" ).val();

if(!email)
{
 confirm=false;
 $( "#"+form_id+" :input[name='email']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Active email is required'      
 })
 return;
}

var c_number= $( "#"+form_id+" :input[name='c_number']" ).val();

if(!c_number)
{
 confirm=false;
 $( "#"+form_id+" :input[name='c_number']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Active contact number is required'      
 })
 return;
}
else
{
  var c_number_length=$( "#"+form_id+" :input[name='c_number']" ).val().length;
  if(c_number_length!=10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='c_number']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Active Mobile Numbers should be 10 digits'      
   })
    return;
  }
}




}

if(form_id=='save_bl')
{
 var amount=$( "#"+form_id+" :input[name='amount']" ).val();
 var max=20000;


 if(amount==0 || amount==" ")
 {
  confirm=false;
  $( "#"+form_id+" :input[name='amount']" ).focus();
  Swal.fire({
   type: "warning",
   title: 'Requested Amount is required',
   width: "400px",  

 })
  return;

}
else{
  amount=parseFloat($( "#"+form_id+" :input[name='amount']" ).val())
  if(amount>max)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='amount']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Requested Amount should not be greater than Loanable Amount (P '+parseFloat(max).toLocaleString('en')+')'      
   })
    return;
  }
}


var bank= $( "#"+form_id+" :input[name='bank']:checked" ).val();
if(bank==undefined)
{
 confirm=false;
 document.forms[form_id].elements["bank"][0].focus();

 Swal.fire({
   type: "warning",
   title: 'Please choose a bank'      
 })
 return;
}

var acc_num= $( "#"+form_id+" :input[name='acc_num']" ).val();


if(!acc_num)
{
 confirm=false;
 $( "#"+form_id+" :input[name='acc_num']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Account Number is required'      
 })
 return;
}
else
{
  var acc_num_length=$( "#"+form_id+" :input[name='acc_num']" ).val().length;
  if(acc_num_length<10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='acc_num']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Account Number should be atleast 10 Digits or more'      
   })
    return;
  }
}


var acc_name= $( "#"+form_id+" :input[name='acc_name']" ).val();


if(!acc_name)
{
 confirm=false;
 $( "#"+form_id+" :input[name='acc_name']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Account Name is required'      
 })
 return;
}

var id= $( "#"+form_id+" :input[name='identification']" ).val();

if(!id)
{
 confirm=false;
 $( "#"+form_id+" :input[name='identification']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'ID is required'      
 })
 return;
}

var pay1= $( "#"+form_id+" :input[name='payslip1']" ).val();

if(!pay1)
{
 confirm=false;
 $( "#"+form_id+" :input[name='payslip1']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Payslip 1 is required'      
 })
 return;
}

var pay2= $( "#"+form_id+" :input[name='payslip2']" ).val();

if(!pay2)
{
 confirm=false;
 $( "#"+form_id+" :input[name='payslip2']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Payslip 2 is required'      
 })
 return;
}

var pass= $( "#"+form_id+" :input[name='passbook']" ).val();

if(!pass)
{
 confirm=false;
 $( "#"+form_id+" :input[name='passbook']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Passbook / ATM / any document or proof showing bank Account Number is required'      
 })
 return;
}

var email= $( "#"+form_id+" :input[name='email']" ).val();

if(!email)
{
 confirm=false;
 $( "#"+form_id+" :input[name='email']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Active email is required'      
 })
 return;
}

var c_number= $( "#"+form_id+" :input[name='c_number']" ).val();

if(!c_number)
{
 confirm=false;
 $( "#"+form_id+" :input[name='c_number']" ).focus();
 Swal.fire({
   type: "warning",
   title: 'Active contact number is required'      
 })
 return;
}
else
{
  var c_number_length=$( "#"+form_id+" :input[name='c_number']" ).val().length;
  if(c_number_length!=10)
  {
    confirm=false;
    $( "#"+form_id+" :input[name='c_number']" ).focus();
    Swal.fire({
     type: "warning",
     title: 'Active Mobile Numbers should be 10 digits'      
   })
    return;
  }
}

}

console.log(confirm);

if(confirm)
{
  Swal.fire({
    title:"Do you want to continue submitting this loan application?",
    text: "You cannot change the details anymore and it will be sent to UP Provident Fund for processing.",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    cancelButtonText: 'Go Back',
    confirmButtonText: 'Submit'
  }).then((result) => {
    if (result.value) {
      $('#sumbit_'+form_id).trigger('click');
      $("#"+form_id+" :button[id='form_submit']").prop('disabled', true);
      Swal.fire ({
       title: 'Submitting Application',
       text:'Please stay on the page and wait',
       allowOutsideClick: false,
       onBeforeOpen: () => {
         Swal.showLoading ()
       }
     })
    }
  })
}

})


});

function readURL(input) {
  console.log(input.id);

  var path=$('#path').val();

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var allowed  = ["image/jpeg", "image/png", "application/pdf"];
    var res=false;
    if(allowed.includes(input.files[0].type))
    {
      console.log(input.files[0].type);


      reader.onload = function(e) {
       if(input.files[0].type=="application/pdf")
       {
        $(input).next().attr('src', path+'/pdfimage.png');
      }
      else
      {
        $(input).next().attr('src', e.target.result);
      }
    }

    reader.readAsDataURL(input.files[0]);
  }
  else
  {
    alert('Invalid File Type (allowed file types jpeg, png , pdf)');
    $(input).val('');
  }

}
}

function isNumber(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
  if (charCode != 46 && charCode > 31 
    && (charCode < 48 || charCode > 57))
   return false;

 return true;
}




</script>



</script>