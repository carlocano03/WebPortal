 <link href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
 <style type="text/css">
 table {
  border-collapse: collapse;
}
th {
  color: #414042!important;
  font-family: Fira Sans,sans-serif;
  font-size: 15px;
}
tr {
  color: #636569!important;
  font-family: Fira Sans,sans-serif;
  font-size: 15px;
}
</style>

<div class="">
  <div class="">
    <div class="">
      <img src="{!! asset('assets/images/uppfi-logo-sm.png') !!}" alt="UPPFI">
      <span class="" style="vertical-align: middle; font-size: 25px; color: #414042!important;">
        University of the Philippines Provident Fund Inc.
      </span>
    </div>
  </div>
</div>
<div class="">

  <div align="center" class="">
    <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
      PARTIAL RETURN OF MEMBER'S EQUITY
    </div>
  </div>
  <div style="padding: 30px;">
    <div class="" align="right" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 12px;">
      DATE: {{ date("m/d/Y") }}
    </div>
    <br>
    <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 13px;">
      <div>
        NAME: {{$member->first_name}} {{$member->middle_name}} {{$member->last_name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CONTACT NUMBER: 0{{$member->contact_no}}
      </div>
      <br>
      <div>
        UNIT: {{ $member->unit_dept }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CAMPUS: {{ $member->name }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; EMPLOYEE NO: {{ $member->employee_no }}
      </div>
    </div>
    <hr>
  </div>

  <div style="color: #414042!important; padding-left: 100px; padding-right: 100px; font-family: Fira Sans,sans-serif; font-size: 11px;">
      <table style="width:100%">
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
  @if($prme_pr->option_selected=="A")
  <div class="" style="color: #414042!important; padding-left: 30px; padding-right: 30px; font-family: Fira Sans,sans-serif; font-size: 13px;">
  OPTION A - I would like to claim the 25% of the amount transferred to my member's equity, net of 10% final tax (per BIR rules) and patronage refund. Please deposit the amount to my account.
  <br>
  <br>
  @if($prme_pr->bank=="LB")
  <strong>Bank: Land Bank</strong>
  @endif
  @if($prme_pr->bank=="PNB")
  <strong>Bank: Phillippine National Bank</strong>
  @endif
  @if($prme_pr->bank=="DBP")
  <strong>Bank: Development Bank of the Philippines</strong>
  @endif
  @if($prme_pr->bank=="Veterans")
  <strong>Bank: Philippine Veterans Bank</strong>
  @endif
  <br>
  <br>
  <strong>Account Name: {{$prme_pr->account_name}}</strong>
  <br>
  <br>
  <strong>Account Name: {{$prme_pr->account_number}}</strong>
 </div>
  @endif

  @if($prme_pr->option_selected=="B")
  <div class="" style="color: #414042!important; padding-left: 30px; padding-right: 30px; font-family: Fira Sans,sans-serif; font-size: 13px;">
  OPTION B - I would like to apply the 25% of the amount transferred to my member's equity, net of 10% final tax (per BIR rules) and patronage refund as payment for my outstanding loan with UPPFI.
  <br>
  <br>
  
  @endif

  @if($prme_pr->option_selected=="C")
  <div class="" style="color: #414042!important; padding-left: 30px; padding-right: 30px; font-family: Fira Sans,sans-serif; font-size: 13px;">
  OPTION C - I would like to to reinvest the 25% of the amount and patronage refund to my member's equity.
  <br>
  <br>
  
  @endif
<br>
<br>
<br>
<br>
<br>
  <div style="color: #414042!important; padding-left: 30px; padding-right: 30px; font-family: Fira Sans,sans-serif;">
      <table style="width:100%">
          
          <tr>
            <td style="text-align: right; width:40%">&nbsp;</td>
            <td style="text-align: right; width:30%">&nbsp;</td>
            <td style="text-align: center; width:30%; border-top: 1px solid black; font-size: 11px; "><strong>Signature over Printed Name</strong></td>
          </tr>
        </table>
  </div>

  
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>  
    <script>
      WebFont.load({
        google: {
          families: ['Fira Sans:300,400,500,600,700']
        }
      });
    </script>
    <script src="{{ asset('/dist/vendor.js') }}"></script>
