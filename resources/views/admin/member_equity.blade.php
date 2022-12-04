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
 
  <div class="container mp-container">
   <div class="row no-gutters mp-mt5" >
    <div class="col-12 mp-ph2 mp-pv2">
      <a href="{{url('/admin/member_soa/'.$member->user_id)}}" class="mp-link mp-link--accent">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Member Profile</span>
      </a>
    </div>
  </div>
  

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
       
        <div class="col-6 col-lg-3">
          <div class="mp-tab mp-tab--active">
            <a class="mp-tab__link" href="{{ url('/admin/member_equity/'.$member->user_id) }}">
              Member's Equity History
            </a>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="mp-tab mp-tab--accent">
            <a class="mp-tab__link" href="{{ url('/admin/member_loans/'.$member->user_id) }}">
              Loan Transactions
            </a>
          </div>
        </div>
        
      </div>
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--tabbed">

            <div class="mp-overflow-x">
              <table class="mp-table mp-text-fs-small">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Transaction</th>
                    <th>Account</th>
                    <th class="mp-text-center">Debit</th>
                    <th class="mp-text-center">Credit</th>
                    <th class="mp-text-center">Balance</th>
                  </tr>
                </thead>
                <tbody>
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
                </tbody>
              </table>
            </div>
            
            <div class="mp-card__footer__pair">
              <div class="mp-card__footer__split mp-text-left">
                <a href="{{url('/admin/generate/equity/'.$member->user_id)}}" target="_blank" class="mp-link mp-link--primary">
                  Download PDF
                </a>
              </div>
              <div>
                
                {{$equity->links('pagination.default')}}
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/dist/dashboard.js') }}"></script>   
@endsection
