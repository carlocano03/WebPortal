@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-10 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-accent">
        <a href="{{url('/admin/modules')}}" class="mp-link mp-link">
          <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
          <span class="mp-text-fs-small">Back to Modules</span>
        </a>
        <br>
        Partial Return & Patronage Refund
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
            <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed" align="center">
             <input type="hidden" id="deleteurl" url="{{url('admin/deletebene')}}" />
             <table style="width:100%" class="mp-table mp-text-fs-small">
              <thead class="mp-text-fs-large" >
               <tr>
                <th style="text-align:center">Year</th>
                <th style="text-align:center">Status</th>
                <th style="text-align:center"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($prme_pr as $pr)
              <tr>
                <td style="text-align:center"> {{$pr->year}}</td>
                @if($pr->status==1)
                <td style="text-align:center"><span style="color:green"><strong>ACTIVE</strong></span></td>
                @else
                <td style="text-align:center"><span style="color:red"><strong>INACTIVE</strong></span></td>
                @endif
                <td style="text-align:center;"><a href="{{url('/admin/prme_pr/'.$pr->id)}}" class="mp-link mp-link--normal">
                  <span class="mp-text-fs-small"><strong>VIEW / EDIT</strong></span>
                </a></td>

              </tr>

              @endforeach             
            </tbody>
          </table>

        </div>
      </div>
    </div>

    <br>
    <br>
    
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
