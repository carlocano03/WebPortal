@extends('layouts/main')
@section('content_body')
<style type="text/css">
  ul.pagination {
list-style-type:none;
margin:0;
padding:0;
text-align:center;
}

ul.pagination li {
display:inline;
padding:2px 5px 0;
text-align:center;
}

ul.pagination li a {
padding:2px;
}
</style>
  <div class="container mp-container">
    <div class="row no-gutters mp-mt5">
      <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
        <a class="mp-link mp-link--accent" href="{{url('/admin/loans')}}">
          <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
          Back to Active Loan Masterlist
        </a>
      </div>
    </div>

    <div class="row no-gutters mp-mb4">
      <div class="col-12 mp-ph2 mp-pv2">
        <div class="row no-gutters">
          <div class="col">
            <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
              <div class="mp-mb4">
                <div>
                  <span class="mp-text-fw-heavy">
                    {{ $member->last_name. ', '.$member->first_name.' '.$member->middle_name }}
                  </span>
                </div>
                <div>
                  Member ID: {{ $member->member_no }}
                </div>
              </div>

            

              <div class="mp-overflow-x">
                <table class="mp-table mp-text-fs-small">
                  <thead>
                    <tr>
                      <th>
                        Date
                      </th>
                      <th>Transaction</th>
                      <th class="mp-text-center">Account</th>
                      <th class="mp-text-center">Monthly Amortization</th>
                      <th class="mp-text-center">Interest</th>
                      <th class="mp-text-center">Amount</th>
                      <th class="mp-text-center">Principal Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $date=""; ?>
                    @foreach($loans as $loan)
                     <?php
                   $samedate=true;
                   if($date == date("m/d/Y", strtotime($loan->date)) )
                   {
                    $samedate=false;
                   }
                   else
                   {
                    $samedate=true;
                   }
                   $date=date("m/d/Y", strtotime($loan->date))
                   ?>
                      <tr>
                        <td>
                          {{ date("m/d/Y", strtotime($loan->date)) }}
                        </td>
                        <td>
                          {{ $loan->reference_no }}
                        </td>
                        <td class="mp-text-center">
                          {{ $loan->name}}
                        </td>
                        <td class="mp-text-right">
                         {{ $loan->amortization == 0 ? '' : 'PHP '.number_format($loan->amortization,2) }}
                        </td>
                        <td class="mp-text-right">
                          {{ $loan->interest == 0 ? '' : 'PHP '.number_format($loan->interest,2) }}
                        </td>
                        <td class="mp-text-right">
                          {{ 'PHP '.number_format($loan->amount,2) }}
                        </td>
                        <td class="mp-text-right">
                         {{ !$samedate ? '' :'PHP '.number_format($loan->balance,2) }}
                        </td>
                      </tr>
                   @endforeach
                  </tbody>
                </table>
              </div>
              <div class="mp-card__footer__pair">
                <div class="mp-card__footer__split mp-text-left">
                  <a href="{{url('/admin/generate/loanspertype/'.$loan->loan_id)}}" target="_blank" class="mp-link mp-link--accent">
                    Download PDF
                  </a>
                </div>
                <div>
                 {{$loans->links('pagination.default')}}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
