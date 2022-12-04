@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<style>
.active {
  background-color: #1a8981;
}
</style>
<div class="container mp-container">

  <div class="row no-gutters mp-mt5">
    <a href="{{url('/member/dashboard')}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Dashboard</span>
      </a>
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Election 
    </div>
  </div>

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <input type="hidden" id="saveurl" url="{{url('member/savevote')}}" />
      <input type="hidden" id="abstainurl" url="{{url('member/abstainvote')}}" />
      <input type="hidden" id="redirecturl" url="{{url('member/election/'.$election->id)}}" />
      <input type="hidden" id="election_id" value="{{$election->id}}" />
      <input type="hidden" id="sg" value="{{getUserdetails()->salary_grade}}" />
      <div class="row no-gutters">

        <div class="col">
@if(!$voted)
          <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed" align="left">
            <br>
            <br>

            <div align="center" class="mp-text-c-gray mp-text-fs-medium">Candidates for BOT Representative</div>


            <div align="center" class="mp-text-c-gray mp-text-fs-medium">({{getUserdetails()->salary_grade}})</div>

            <div class="row"style="padding:20px;">
              @foreach($candidates as $cand)
              <div class="col-sm-4 content" align="center" style="padding:20px"><img src="{{ asset('storage/app/election/photo/'.$cand->candidate_photo) }}" width="160px" height="200px"alt="">
                <br><strong>{{$cand->first_name}} {{$cand->last_name}}</strong>
                <br>{{$cand->position_id}}
                <br>{{$cand->campus_name}}
                <br><a href="{{ asset('storage/app/election/attachments/'.$cand->file_credentials) }}">Download Nominee's Credentials</a>
                <br><input type="radio" name="vote" value="{{$cand->candidate_id}}">
                <input type="hidden" name="vote-name" value="{{$cand->first_name}} {{$cand->last_name}}"></div>
                @endforeach
                <div class="col-sm-4 content" align="center"
                style="padding:20px"><img src="{{ asset('storage/app/election/person.png') }}" width="160px" height="200px"alt="">
                <br><strong>ABSTAIN</strong>
                <br>
                <br>
                <br>  
                <br><input type="radio" name="vote" value="ABSTAIN">
                <input type="hidden" name="vote-name" value="ABSTAIN"></div>

              </div>
              <div class="col-sm-12" align="center">
                <button type="button" id="cast" name="cast" class="mp-button mp-button--primary">Cast Vote</button>
                <!--  <button type="button" id="abstain" name="abstain" class="mp-button mp-button" style="background-color: #555555; color: white;">Abstain</button> -->
              </div>
            </div>
@else
            <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed" align="left">
              <div align="center" class="mp-text-c-gray mp-text-fs-large" style="padding-top: 40px;">You have already voted.</div>
              <div align="center" class="mp-text-c-gray mp-text-fs-large">Thank You.</div>
            </div>
@endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.content').click(function () {    
   // var val =  $(this).find('input:radio').prop('checked')?false:true;
   var val = true;

   $(this).closest("div").addClass("active").
   siblings("div.active").removeClass("active");
   $(this).find('input:radio').prop('checked', val);
 });

  $(":radio").click(function() {
    $(this).closest("div").addClass("active").
    siblings("div.active").removeClass("active");
  });

  $('#cast').click(function () {
    var radioValue = $("input[name='vote']:checked").val();  
    var radioName = $("input[name='vote']:checked").closest("div").find("input[name='vote-name']").val();
    if(radioValue == null)
    {
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'No Candidate Selected'
      })
    }
    else
    {
      Swal.fire({
        title: 'You are voting for',
        text: radioName,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1a8981',
        cancelButtonColor: '#555555',
        confirmButtonText: 'Cast Vote'
      }).then((result) => {
      // console.log(result[]);
      if(result['value'])
      {
        var saveurl = $('#saveurl').attr('url');
        var redirecturl = $('#redirecturl').attr('url');
        var sg = $('#sg').val();
        var election_id = $('#election_id').val();
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:saveurl,
          dataType: "json",
          data: { 
            'vote': radioValue,
            'sg': sg,
            'election_id':election_id
          },
          success:function(html) {
          // alert(html);
          Swal.fire(
            'Your vote has been recorded. Thank you',
            html
            ).then(function() {
              location.href = redirecturl;
            });

          }
        });
    // if (result.value) {
      // Swal.fire(
      //   'Voted Successfully',
      //   'success'
      //   )

    // }
  }
  else
  {
    Swal.fire('Vote Cancelled', 'Please vote again')
  }
})
    }
  });

  $('#abstain').click(function () {

    Swal.fire({
      title: 'You are voting for',
      text: 'Abstain',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#1a8981',
      cancelButtonColor: '#555555',
      confirmButtonText: 'Cast Vote'
    }).then((result) => {
      var abstainurl = $('#abstainurl').attr('url');
      var redirecturl = $('#redirecturl').attr('url');
      var sg = $('#sg').val();
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:abstainurl,
        dataType: "json",
        data: { 
          'vote': 'abstain',
          'sg': sg
        },
        success:function(data) {
          Swal.fire(
            'Voted Successfully',
            'success'
            ).then(function() {
              location.href = redirecturl;
            });

          }
        });
    // if (result.value) {
      // Swal.fire(
      //   'Voted Successfully',
      //   'success'
      //   )

    // }
  })

  });

</script>
@endsection