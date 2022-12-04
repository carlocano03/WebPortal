@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-10 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-accent">
        <a href="{{url('/admin/prme_pr')}}" class="mp-link mp-link">
          <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
          <span class="mp-text-fs-small">Back to Partial Return & Patronage Refund </span>
        </a>
        <br>
        Partial Return & Patronage Refund Details
      </div>
       <div class="row no-gutters mp-mb4">
      <div class="col-md-4 col-lg-4 mp-ph2 mp-pv2">
        <div class="mp-card mp-ph3 mp-pv3">
          <div class="mp-text-c-gray mp-text-fs-small">
            FOR YEAR
          </div>
          <div class="mp-card__body mp-text-fs-xlarge">
           {{$prme_pr->year}}
         </div>
       </div>
     </div>
     <div class="col-md-4 col-lg-4 mp-ph2 mp-pv2">
        <div class="mp-card mp-ph3 mp-pv3">
          <div class="mp-text-c-gray mp-text-fs-small">
            STATUS
          </div>
          <div class="mp-card__body mp-text-fs-xlarge">
           @if($prme_pr->status==1)
           <span style="color:green;">ACTIVE</span>
           @else
            <span style="color:red;">CLOSED</span>
           @endif
         </div>
       </div>
     </div>
      <div class="col-md-4 col-lg-4 mp-ph2 mp-pv2">
        <div class="mp-card mp-ph3 mp-pv3">
          <div class="mp-text-c-gray mp-text-fs-small">
            RESPONSES
          </div>
          <div class="mp-card__body mp-text-fs-xlarge">
          {{$prmepr_count}}
         </div>
       </div>
     </div>
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



      <div class="row no-gutters">
        <div class="col">
           <div class="mp-pb4 mp-input-group">
            <div align="center">
               {{ Form::open(array('url' => '/admin/prmepr_generate', 'method' => 'post', 'autocomplete'=>'off')) }}
            <strong>GENERATE REPORT</strong>
            </div>
            <br>
            <label class="mp-input-group__label" for="password">
            CAMPUS
            </label>

            <select class="mp-input-group__input mp-text-field" name="camp_id">
             @foreach($campus as $camp)
            
             <option value="{{$camp->id}}">{{$camp->name}}</option>
      
             @endforeach
           </select>
           <div align="center">
            <br>
            <input type="hidden" id=prmepr_id name="prmepr_id" value="{{$prme_pr->id}}">
            <input type="submit" id="gen_rep" name="gen_rep" value="GENERATE" class="mp-button mp-button--primary">
            </div>
            {{ Form::close() }}

           <br>
           <br>
           <br>
           <div class="mp-text-fs-small mp-text-right">
                 <a class="mp-button mp-button--accent" href="{{url('/admin/beneficiary-encoder')}}">CLOSE {{$prme_pr->year}} PARTIAL RETURN AND PATRONAGE REFUND</a>

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

<script>
  $( function() {
    $( "#birth_date" ).datepicker();
  } );

  $('.remove').click(function () {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to remove this Beneficiary?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
      if(result.value)
      {
        var bene_id=$(this).closest("tr").find('input[name="bene_id"]').val();
        var deleteurl=$('#deleteurl').attr('url');
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:deleteurl,
          dataType: "json",
          data: { 
            'bene_id': bene_id
          },
          success:function(data) {
          // alert(html);
          // Swal.fire(
          //   'Your vote has been recorded. Thank you'
          //   ).then(function() {
          //       location.href = redirecturl;
          //   });

          Swal.fire(
            'Removed',
            'Your beneficiary has been removed.',
            'success'
            ).then(function() {
              location.reload();
            });

          }
        });
      // if (result.value) {
      //   Swal.fire(
      //     'Removed',
      //     'Your beneficiary has been removed.',
      //     'success'
      //     ).then(function() {
      //           location.href = redirecturl;
      //       });
      // }
    }
    else
    {

    }
  })
  })

</script>
@endsection
