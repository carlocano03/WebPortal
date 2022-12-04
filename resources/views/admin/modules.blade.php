@extends('layouts/main')
@section('content_body')
<style type="text/css">


.mp-nav__icon:hover .mp-icon--svg >g {
  fill: #1a8981;
  fill: var(--c-primary)
}
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
      Modules
    </div>
  </div>
  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card">
           <div class="row">
              <div class="col-sm mp-nav_item">
               <a class="mp-nav__link" href="{{url('/admin/election')}}" >
                <span class="mp-nav__icon">
                 @include('layouts.icons.i-vote')
               </span>
               <span class="mp-nav__label">
                 Election
               </span>
             </a>
           </div>
           @if(getUserdetails()->role=='SUPER_ADMIN')
           <div class="col-sm">
            <a class="mp-nav__link mp-nav_item" href="{{url('/admin/prme_pr')}}" >
              <span class="mp-nav__icon">
               @include('layouts.icons.i-return')
             </span>
             <span class="mp-nav__label">
               Partial Return & Patronage Refund
             </span>
           </a>
         </div>
         @endif
         <div class="col-sm">

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
<script type="text/javascript">

  $('#search_btn_albums').click(function(){
    keyword = $('#search').val();        
    location.href = "members?q="+keyword;
  });
</script>
@endsection
