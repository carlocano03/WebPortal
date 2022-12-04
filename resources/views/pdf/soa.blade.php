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
    <div style="padding: 30px;">
      <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
        Statement Date: {{ date("m/d/Y") }}
      </div>

      <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
        <div>
          Name: {{$member->first_name}} {{$member->last_name}}
        </div>
        <div>
          Member ID: {{ $member->member_no }}
        </div>
      </div>
    </div>

      <div align="center" class="">
        <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 20px;">
          Statement of Account
        </div>
        <table width="100%" class="" cellspacing="1000" style="padding: 30px; padding-bottom: 0px!important;">
          <tr>
            <th class="">Your Member's Equity</th>
            <th></th>
          </tr>
          <tr>
            <td class="">
              Total Member's Contribution
            </td>
            <td class="" style="text-align: right;">
               PHP {{ number_format($membercontribution,2) }} 
            </td>
          </tr>
          <tr>
            <td class="">Total UP Contribution</td>
            <td class="" style="text-align: right;">PHP {{ number_format($upcontribution,2) }} </td>
          </tr>
          <tr>
            <td class="">Earnings from Membership Contribution</td>
            <td class="" style="text-align: right;">PHP {{ number_format($emcontribution,2) }}</td>
          </tr>
          <tr>
            <td class="">Earnings from UP Contribution</td>
            <td class="" style="text-align: right;">PHP {{ number_format($eupcontribution,2) }}</td>
          </tr>
          <tr>
            <td>
              <div class=""></div>
            </td>
            <td>
              <div class=""></div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <hr>
            </td>
          </tr>
          <tr class="">
            <th>Total Equity Balance</th>
            <th class="" style="text-align: right;">PHP {{ number_format($totalcontributions,2) }}</th>
          </tr>
        </table>
        @if(!empty($outstandingloans))
        <br>
        
          <table width="100%" class="" cellspacing="1000" style="padding: 30px">
            <tr>
              <th class="">Your Outstanding Loans</th>
              <th></th>
            </tr>
          @foreach($outstandingloans as $loans)
              <tr>
                <td class="">{{ $loans->type }}</td>
                <td class="" style="text-align: right;">PHP {{ number_format($loans->balance,2) }}</td>
              </tr>
           @endforeach
            <tr>
              <td>
                <div class=""></div>
              </td>
              <td>
                <div class=""></div>
              </td>
            </tr>
            <tr>
            <td colspan="2">
              <hr>
            </td>
          </tr>
            <tr class="">
              <th>Total Outstanding Loan Balance</th>
              <th class="" style="text-align: right;">PHP {{ number_format($totalloanbalance,2) }}</th>
            </tr>
          </table>
        
       @endif
         <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="color:red!important; font-size:12px!important">Note: This is a computer generated document.<br>No signature required. For questions or clarifications, please contact us at www.upprovidentfund.com</p>
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
