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
      Active Loan Masterlist
    </div>
  </div>
  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card">
            <div class="mp-overflow-x">
              <table class="mp-table mp-text-fs-small">
                <thead>
                  <tr>
                    <th>Loan Type</th>
                    <th>Member ID</th>
                    <th>Member Name</th>
                    <th class="mp-text-center">Last Transaction Date</th>
                    <th class="mp-text-center">Balance</th>
                    <th class="mp-text-center">Start Amort Date</th>
                    <th class="mp-text-center">End Amort Date</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($loans as $loan)
                  <tr>
                    <td>
                      {{ $loan->type }}
                    </td>
                    <td>
                      {{ $loan->memberNo }}
                    </td>
                    <td class="mp-text-fw-heavy">
                      {{ $loan->lastname.', '.$loan->firstname.' '.$loan->middlename }}
                    </td>
                    <td class="mp-text-center">
                      {{ $loan->lastTransactionDate == null ? '' : date("m/d/Y", strtotime($loan->lastTransactionDate)) }}
                    </td>
                    <td class="mp-text-center">
                      {{ 'PHP '.number_format($loan->balance,2) }}
                    </td>
                    <td class="mp-text-center">
                      {{ $loan->startAmortDate == null ? '' : date("m/d/Y", strtotime($loan->startAmortDate)) }}
                    </td>
                    <td class="mp-text-center">
                      {{ $loan->endAmortDate == null ? '' : date("m/d/Y", strtotime($loan->endAmortDate)) }}
                    </td>
                    <td class="mp-text-right">
                      <a data-md-tooltip="View Loans History" href="{{url('/admin/loan-details/'.$loan->id)}}">
                        <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
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
@endsection
@section('scripts')
<script src="{{ asset('dist/adminActiveLoans.js') }}"></script>
@endsection
