@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
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
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary">
      Loan Application
      <span style="position: relative; float: right;">
       <a href="{{url('/member/new-loan')}}"  class="mp-button mp-button--primary">
        Apply for Loan
      </a>
    </span>
  </div>
  
</div>


<div class="row no-gutters mp-mb4">
  <div class="col-12 mp-ph2 mp-pv2">
    <div class="row no-gutters">
     
      <div class="col-6 col-lg-3">
        <div class="mp-tab mp-tab--active">
          <a class="mp-tab__link" href="{{ url('/member/loan-app') }}">
            Loan Application
          </a>
        </div>
      </div>

     <!--    <div class="col-6 col-lg-3">
          <div class="mp-tab ">
            <a class="mp-tab__link" href="{{ url('/member/coborrower') }}">
              Co-Borrower Loan
            </a>
          </div>
        </div> -->
        
      </div>
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--tabbed">

            <div class="mp-text-fs-medium {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}" align="center">
              @if(Session::has('error'))
              <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
              @endif
              @if(Session::has('success'))
              <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
              @endif
            </div>

            
            <br>
            
            <div class="mp-overflow-x">
              <table class="mp-table mp-text-fs-small">
                <thead>
                  <tr>
                    <th class="mp-text-center">Date Applied</th>
                    <th class="mp-text-center">Loan Application Number</th>
                    <th class="mp-text-center">Loan Type</th>
                    <th class="mp-text-center">Loan Status</th>
                    <th class="mp-text-center"></th>
                    
                  </tr>
                </thead>
                <tbody>
                 
                 @foreach($loans as $loan)
                 <tr>
                  <td class="mp-text-center">{{date("m/d/Y h:i A", strtotime($loan->date_created))}}</td>
                  <td class="mp-text-center">{{$loan->control_number}}</td>
                  <td >{{$loan->description.' ('.$loan->name.')'}}</td>
                  @if($loan->status=="SUBMITTED")
                  <td class="mp-text-center" style="color:#feb236;"><strong>{{$loan->status}}</strong></td>
                  @endif
                  @if($loan->status=="PROCESSING")
                  <td class="mp-text-center" style="color:#82b74b;"><strong>{{$loan->status}}</strong></td>
                  @endif

                  @if($loan->status=="DONE")
                  <td class="mp-text-center" style="color:#034f84;"><strong>FOR MEMBER CONFIRMATION</strong></td>
                  @endif

                  @if($loan->status=="CANCELLED")
                  <td class="mp-text-center" style="color:#d64161;"><strong>{{$loan->status}}</strong></td>
                  @endif
                  @if($loan->status=="CONFIRMED")
                  <td class="mp-text-center" style="color:#894168"><strong>{{$loan->status}}</strong></td>
                  @endif
                  <td class="mp-text-center">
                    <a data-md-tooltip="View Details" href="{{url('/member/loan-details').'/'.$loan->id}}">
                      <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                    </a>
                    
                  </td>
                  @endforeach
                  
                  
                  
                </tr>
                
              </tbody>
            </table>

          </div>
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
@section('scripts')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
 
</script>
@endsection
