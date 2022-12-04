@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
 <div class="row no-gutters mp-mt5" >
  <div class="col-12 mp-ph2 mp-pv2">
    <a href="{{url('/admin/member_soa/'.$member->user_id)}}" class="mp-link mp-link--accent">
      <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
      <span class="mp-text-fs-large">Back to Member Details</span>
    </a>
  </div>
</div>

<div class="row no-gutters mp-mh4" style="margin-top: 0px!important;">
  <div class="col-lg-6">
    <div class="row no-gutters">
      <div class="col-12 mp-ph2 mp-pv2">
        <div class="mp-ph4 mp-pv4 mp-card mp-card--plain">
          <div class="mp-text-no-lh">
            <div class="mp-mb1 mp-text-c-light-gray mp-text-fs-small">Member ID</div>
            <div class="mp-text-fs-large mp-text-fw-heavy">
              {{ $member->member_no }}
            </div>
          </div>
          <div class="mp-mh2 mp-text-no-lh mp-text-word-wrap mp-dashboard__title">
            {{ $member->last_name }}, {{ $member->first_name}}
          </div>
          <div class="mp-text-no-lh">
            <div class="mp-mb2 mp-text-fs-large">{{ $member->name }}</div>
            <div class="mp-text-fs-large">{{ $member->position_id }}</div>
          </div>

          <br/>
          <div class="mp-text-fs-large mp-text-fw-heavy" align="center">
            CURRENT MEMBERSHIP STATUS: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            @if($member->membership_status=='ACTIVE')
            <span style="color: green">{{ $member->membership_status }}</span>
            @else
            <span style="color: red">{{ $member->membership_status }}</span>
            @endif
          </div>
          <br/>
          <br/>
          <div class="mp-pb4 mp-input-group">
            <label class="mp-input-group__label" for="password">
              Membership Status
            </label>

            <select class="mp-input-group__input mp-text-field" id="status">
             @foreach($status as $stat)
             <option value="{{$stat->description}}" {{ $stat->description==$member->membership_status ? 'selected': ' '  }}>{{$stat->description}}</option>
             @endforeach
           </select>
           <input type="hidden" value="{{$member->member_id}}" id="member_id">
         </div>
         <div class="mp-pt3 row justify-content-end align-items-center">
          <div class="col col-auto">
           <button type="button" id="update_status" name="update_status" class="mp-button mp-button--accent">Update Status</button>
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
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
 $('#update_status').click(function () {
   Swal.fire({
    type: 'warning',
    title: 'Are you sure you want to update membership status?',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, proceed'
  }).then((result) => {
    if (result.value) {
      var member_id=$('#member_id').val();
      var status=$('#status').val();
      $.ajax({
       type:'POST',
       headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url:'{{url("/admin/change_status/update")}}',
      dataType:'json',
      data: { 
        'member_id': member_id,
        'status': status
      },
      success:function(data) {
        Swal.fire(
          'Membership Status Updated',
          ).then(function() {
            location.href = '{{url("/admin/member_soa/".$member->user_id)}}';
          });

        }
      });
    }
  })
})


</script>

@endsection