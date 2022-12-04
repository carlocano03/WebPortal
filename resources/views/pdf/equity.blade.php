<link href="//cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" rel="stylesheet">
 <style type="text/css">
   table {
    border-collapse: collapse;
}
th {
color: #414042!important;
font-family: Fira Sans,sans-serif;
font-size: 15px;
padding: 3px;
text-align: center;
}
tr {
color: #636569!important;
font-family: Fira Sans,sans-serif;
font-size: 14px;
padding:5px;
}
td
{
  padding: 3px;
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

      <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
        Transaction Period: 01/01/2017 - {{ date("m/d/Y") }}
      </div>

      <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 15px;">
        <div>
           Name: {{$member->first_name}} {{$member->last_name}}
        </div>
        <div>
            Member ID: {{ $member->member_no }}
        </div>
      </div>
     
     <div align="center" class="">
        <div class="" style="color: #414042!important; font-family: Fira Sans,sans-serif; font-size: 20px;">
          Account History: Equity Transactions
        </div>
      
        <table class="" width="100%" style="padding-top:30px">
          <tr>
            <th class="">Date</th>
            <th class="">Transaction</th>
            <th class="">Account</th>
            <th class="">Debit</th>
            <th class="">Credit</th>
            <th class="">Balance</th>
          </tr>
          <tr>
            <td colspan="6"><hr></td>
          </tr>
         
                  <?php
                 $curdate=''; ?>
                 @foreach($equity as $contri)
                 
                 <tr>
                  <td>{{ date("m/d/Y", strtotime($contri->date)) }}</td>
                  <td>{{ $contri->reference_no }}</td>
                  <td>{{ $contri->name }}</td>
                  <td class="mp-text-right">
                    {{ $contri->amount < 0 ? 'PHP '.number_format(abs($contri->amount),2) : '' }}
                  </td>
                  <td class="mp-text-right">
                    {{ $contri->amount >= 0 ? 'PHP '.number_format($contri->amount,2) : '' }}
                  </td>
                  @if($curdate==$contri->date)
                  <td class="mp-text-right"></td>
                   
                    @else
                    <td class="mp-text-right">{{ 'PHP '.number_format($contri->balance,2) }}</td>
                    <?php
                    $curdate=$contri->date;
                    ?>
                    @endif
                  </tr>
                  
                  @endforeach
        </table>
          <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <p style="color:red!important; font-size:12px!important">Note: This is a computer generated document.<br>No signature required. For questions or clarifications, please contact us at www.upprovidentfund.com</p>
      </div>
    </div>
  