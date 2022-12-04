@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-10 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">
        Partial Return and Patronage Refund
      </div>
    </div>
  </div>
  <div class="row no-gutters mp-mb4 justify-content-center">
    <div class="col-12 col-lg-10 mp-ph2 mp-pv2">
      <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
        <div class="mp-text-fs-small {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}">
          @if(Session::has('error'))
          <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
          @endif
          @if(Session::has('success'))
          <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
          @endif
        </div>


        <div class="col" align="center">
          @if(count($existing)!=0)

          @if($existing->option_selected=="A")
          <div align="justify">

            <p style="color:red"><strong>IMPORTANT: If you will use another person’s bank account, please DOWNLOAD, PRINT, and SIGN the form. You may also just attach an E-SIGNATURE. Please email (1) the completed form; (2) a copy of your ID; and (3) the ID of the person owning the bank account. Send to your respective campus official UPPFI email address dilimansystembaguio@upprovidentfund.com<br/>losbanosopenu@upprovidentfund.com<br/>manilapgh@upprovidentfund.com<br/> visayasmindanao@upprovidentfund.com<br/> or to our Facebook page (via Facebook Messenger).  Deadline to submit:  February 13, 2022.
<br/>
<br/>
            Failure to submit the three (3) requirements means your withdrawal will not be processed. If you will use your own bank account and will not use another person’s account, no need to submit anything.</strong></p>
          </div>
          <br>
          <a href="{{url('generate/prme_pr/'.getUserdetails()->user_id)}}" target="_blank" class="mp-link mp-link--primary">
            Click here to download the form ONLY if you will use another person’s bank account
          </a>
          @else
          <div align="center">

            <p style="color:green"><strong>Thank you.  We have received your application.</strong></p>
          </div>
          @endif

          <br> 
          <br>
          @else
          <div align="justify">
            <p><strong>Good News! You are entitled to receive your share in the Annual Transfer of UP Provident Fund Inc. (UPPFI)'s Earnings for {{  prme_pr() ? prme_pr()->year : '' }}. Please choose one from the three options below regarding your decision on said share in earnings. If you will not choose any option, Option C (Reinvestment of Earnings) will be automatically applied.</strong></p>
            <br>
          </div>



          <table style="width:60%">
            <tr>
              <th></th>
              <th style="text-align: center;">GROSS AMOUNT</th>
              <th style="text-align: center;">10% TAX</th>
              <th style="text-align: center;">NET AMOUNT</th>
            </tr>
            <tr>
              <td>25% of {{  prme_pr() ? prme_pr()->year : '' }} Share in Earnings</td>
              <td style="text-align: right">{{number_format($prme->total,2)}}</td>
              <td style="text-align: right">{{number_format($prme->tax,2)}}</td>
              <td style="text-align: right">{{number_format($prme->net_total,2)}}</td>
            </tr>
            @if($pr)
            <tr>
              <td>Patronage Refund</td>
              <td style="text-align: right">{{number_format($pr->amount,2)}}</td>
              <td style="text-align: right"></td>
              <td style="text-align: right">{{number_format($pr->amount,2)}}</td>
            </tr>
            @endif
            <tr>
              <td></td>
              <td style="text-align: right"></td>
              <td style="text-align: right"></td>
              @if($pr)
              <td style="text-align: right; border-top: 1px solid black ">{{number_format($pr->amount+$prme->net_total,2)}}</td>
              @else
              <td style="text-align: right; border-top: 1px solid black ">{{number_format($prme->net_total,2)}}</td>
              @endif
            </tr>
          </table>
        </div>

        <br>
        {{ Form::open(array('url' => 'member/prme_pr/apply_refund/'.getUserdetails()->user_id, 'method' => 'post', 'id'=>'refund',)) }}

        <div class="radio">
          <label><input type="radio" name="optradio" required value="A" >&nbsp;Option A - Withdraw and deposit to bank account </label>
          <p>I would like to claim the 25% of the amount transferred to my member's equity, net of 10% final tax (per BIR rules) and patronage refund. Please deposit the amount to my account. (Please select your prefered bank and provide your account number and name.)</p>

          <div id="bank_det" align="center">
            <label class="radio-inline"><input type="radio" name="bank"  value="LB" disabled>Land Bank</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="radio-inline"><input type="radio" name="bank" value="PNB" disabled >PNB</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <label class="radio-inline"><input type="radio" name="bank" value="DBP" disabled >DBP</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <label class="radio-inline"><input type="radio" name="bank" value="Veterans" disabled >Phil. Veterans Bank</label>
            <br>

            <label for="fname">Account Number:</label>
            <input type="text" id="acc_num" name="acc_num" style="width:30%;" disabled required onkeypress="return isNumber(event)">&nbsp;&nbsp;
            <label for="lname">Account Name:</label>
            <input type="text" id="acc_name" name="acc_name" style="width:30%;" disabled required><br><br>
          </div>
        </div>
        <br>
        <div class="radio">
          <label><input type="radio" name="optradio" required value="B" >&nbsp;Option B - Payment for outstanding loan</label>
          <p>I would like to apply the 25% of the amount transferred to my member's equity, net of 10% final tax (per BIR rules) and patronage refund as payment for my outstanding loan with UPPFI</p>
        </div>
        <br>
        <div class="radio">
          <label><input type="radio" name="optradio" required value="C" >&nbsp;Option C - Re-invest</label>
          <p>I would like to to reinvest the 25% of the amount and patronage refund to my member's equity</p>
        </div>

        <br>

        <div class="col-sm-12" align="center">
       <!--  <button type="button" id="cast" name="cast" class="mp-button mp-button--primary">CLAIM</button>
        <br> -->

        <button type="submit" id="sub" name="sub"  class="mp-button mp-button--primary">SUBMIT</button>


       </div>
       {{ Form::close() }}

       @endif




   </div>
</div>
@endsection
@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
    $('input[name="optradio"]').change(function()
    {
      console.log(this.value);
      if (this.value=='A') {
        $('input[name="bank"]').removeAttr("disabled");
        $('#acc_name').removeAttr("disabled");
        $('#acc_num').removeAttr("disabled");
        $('input[name="bank"]').attr('required', 'true');
        $('#acc_name').attr('required', 'true');
        $('#acc_num').attr('required', 'true');
      }
      else
      {
        $('input[name="bank"]').attr('disabled', 'disabled');
        $('#acc_name').attr('disabled', 'disabled');
        $('#acc_num').attr('disabled', 'disabled');
      }

    });


  });

  $('#cast').click(function () {

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
        $("#sub").click();

      }
    })
})

  function isNumber(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
      return false;

    return true;
  }

</script>
@endsection
