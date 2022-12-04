@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<style>
.active {
  background-color: #1a8981;
}
</style>
<div class="container mp-container">
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Election Dashboard
    </div>
  </div>

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <input type="hidden" id="saveurl" url="{{url('member/savevote')}}" />
       <input type="hidden" id="abstainurl" url="{{url('member/abstainvote')}}" />
      <input type="hidden" id="redirecturl" url="{{url('member/election')}}" />
      <input type="hidden" id="sg" value="{{$sg}}" />
      <div class="row no-gutters">

        <div class="col">
          @if(voting()==true)
          @if($voted==false)
          <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed" align="left">
            <div align="center" class="mp-text-c-gray mp-text-fs-medium">Candidates for BOT Representative</div>
          
            @if($sg<=15)
            <div align="center" class="mp-text-c-gray mp-text-fs-medium">(SG 1-15)</div>
            @else
            <div align="center" class="mp-text-c-gray mp-text-fs-medium">(SG 16-Above)</div>
            @endif
            <div class="row"style="padding:20px;">
              @if($sg<=15)
              <div class="col-sm-4 content" align="center" style="padding:20px"><img src="{{ asset('storage/app/election/1-15/gongora.png') }}" width="250px" height="300px"alt="">
               <!--  <br><strong>LEOVEN GONGORA</strong>
                <br>Central Point of Contact
                <br>UP Manila -->
             <!--    <br><a href="{{ asset('storage/app/election/1-15/ElenaPasuquin.pdf') }}">Download Nominee's Credentials</a> -->
                <br><input type="radio" name="vote" value="LEOVEN GONGORA"></div>
                <div class="col-sm-4 content" align="center"
                style="padding:20px"><img src="{{ asset('storage/app/election/1-15/perdido.png') }}" width="250px" height="300px"alt="">
            <!--     <br><strong>MARIA EDEN PERDIDO</strong>
               <br>Accounting Office
                <br>UP Manila -->
            <!--     <br><a href="{{ asset('storage/app/election/1-15/perdido.p') }}" target="_blank">Download Nominee's Credentials</a> -->
                <br><input type="radio" name="vote" value="MARIA EDEN PERDIDO"></div>
                 <div class="col-sm-4 content" align="center"
                style="padding:20px"><img src="{{ asset('storage/app/election/person.jpg') }}" width="250px" height="300px"alt="">
                <br><strong>ABSTAIN</strong>
               
                <br><input type="radio" name="vote" value="ABSTAIN"></div>
              @else
              <div class="col-sm-4 content" align="center" style="padding:20px"><img src="{{ asset('storage/app/election/16-above/ebesate.png') }}" width="250px" height="300px"alt="">
              <!--   <br><strong>JOSSEL EBESATE</strong>
                <br>Nursing Department
                <br>PGH -->
             <!--    <br><a href="{{ asset('storage/app/election/16-above/AlexanderBalatibat.pdf') }}" target="_blank">Download Nominee's Credentials</a> -->
                <br><input type="radio" name="vote" value="JOSSEL EBESATE"></div>

                  <div class="col-sm-4 content" align="center"
                style="padding:20px"><img src="{{ asset('storage/app/election/person.jpg') }}" width="250px" height="300px"alt="">
                <br><strong>ABSTAIN</strong>
            
                <br><input type="radio" name="vote" value="ABSTAIN"></div>
              @endif
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
            @else
             <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed" align="left">
              <div class="mp-text-fs-medium" style="color:#6c1242;padding-top: 40px;" >
      <strong>Maaari kayong bumoto sa BOT election simula Nov. 28, 7:00am hanggang Nov. 29, 3:00pm. Siguraduhing mag-login sa mga araw na iyon para makaboto.</strong>
    </div>
            <div align="center" class="mp-text-c-gray mp-text-fs-large" style="padding-top:20px" ><img src="{{ asset('storage/app/election/UPM Election 2019 -2S.jpg') }}" width="1000px" height="700px"alt=""></div>
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
      text: radioValue,
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
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:'POST',
        url:saveurl,
        dataType: "json",
        data: { 
        'vote': radioValue,
        'sg': sg
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