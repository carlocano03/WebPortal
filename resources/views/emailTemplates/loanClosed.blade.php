<!DOCTYPE html>
<html>
<head>
  <title>Admin Account - UP Provident Fund Inc.</title>
</head>
<body>
  Dear <strong>{{ $firstName }}</strong>,
  <br><br>
  Congratulations! Your loan application with UP Provident Fund has been approved. Please login to Members Portal to confirm the approved loan. 
  <br>
  Members portal: <a href='https://member.upprovidentfund.com'>https://member.upprovidentfund.com</a>
  <br>
  <br>
  Please see attachment for your copy of approved loan information slip.
  <br>
  Loan Type: <strong>{{$loandesc}}</strong>
  <br>
  Loan Application No.: <strong>{{$loancontrol}}</strong>
  <br>
  Approved Loan Amount: <strong>PHP  {{ number_format($loanamt,2) }}</strong>
  <br>
  Monthly Amortization: <strong>PHP  {{ number_format($loanamort,2) }}</strong>
  <br>
  Net Proceeds: <strong>PHP  {{ number_format($loanproceeds,2) }}</strong>
  <br>
  Expected Day of Crediting: <strong>{{date("m/d/Y", strtotime($loancd))}}</strong>
  @if($loanbank=='LB')
  To be Credited to Bank Account in: <strong>LANDBANK</strong>
  @endif
  @if($loanbank=='PNB')
  To be Credited to Bank Account in: <strong>PHILIPPINE NATIONAL BANK</strong>
  @endif

  @if($loanbank=='DBP')
  To be Credited to Bank Account in: <strong>DEVELOPMENT BANK OF THE PHILIPPINES</strong>
  @endif

  @if($loanbank=='Veterans')
  To be Credited to Bank Account in: <strong>PHILIPPINE VETERANS BANK</strong>
  @endif
  <br>
  Bank Account Name: <strong>{{$loanname}}</strong>
  <br>
  Bank Account Number: <strong>{{$loannum}}</strong>
  <br><br> 
  If you have any questions or clarifications, please contact us via our contact details below.
  <br><br>
  Facebook page: <a href='https://www.facebook.com/upprovidentfund'>https://www.facebook.com/upprovidentfund</a>
  <br><br>
  Campus Cluster: UP Diliman / Baguio / System Administration
  <br>
  Telephone Number: (02) 8929-3865 / (02) 8981-8500 loc. 4587
  <br>
  Email Address: dilimansystembaguio@upprovidentfund.com
  <br>
  <br>

  Campus Cluster: UP Manila / PGH
  <br>
  Email Address: manilapgh@upprovidentfund.com
  <br>
  <br>

  Campus Cluster: UP Los Banos / Open University
  <br>
  Telephone Number: (049) 536-7148
  <br>
  Email Address: losbanosopenu@upprovidentfund.com
  <br><br>
  Campus Cluster: UP Visayas / Cebu / Mindanao
  <br>
  Telephone Number: (033) 315-9928
  <br>
  Email Address: visayasmindanao@upprovidentfund.com
  <br><br>
  Thank you very much.
  <br><br>
  Regards,
  <br>
  UP Provident Fund
   <br>
  <br>
  This is a system generated message. Please do not reply.
</body>
</html>
