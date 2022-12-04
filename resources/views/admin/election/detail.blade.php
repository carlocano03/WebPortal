@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<style type="text/css">
hr { 
  display: block;
  margin-top: 0.5em;
  margin-bottom: 0.5em;
  margin-left: auto;
  margin-right: auto;
  border-style: inset;
  border-width: 1px;
} 

.ui-datepicker-calendar {
 display: none;
}
.ui-datepicker-month {
 display: none;
}
.ui-datepicker-prev{
 display: none;
}
.ui-datepicker-next{
 display: none;
} 
</style>
<div class="container mp-container">
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2" style="padding-bottom: 0px!important;">
      <a href="{{url('/admin/election')}}" class="mp-link mp-link">
        <i class="mp-icon icon-arrow-left mp-mr1 mp-text-fs-medium"></i>
        <span class="mp-text-fs-large">Back to Election Module</span>
      </a>
    </div>
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Election Configuration
    </div>
  </div>

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card">
            <div class="mp-mb3 mp-text-fw-heavy mp-text-fs-large" align="center">
              <div class="mp-text-fs-medium {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}" align="center">
                @if(Session::has('error'))
                <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
                @endif
                @if(Session::has('success'))
                <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
                @endif
              </div>
              Cluster: {{$elect->name}} 
              <br>
              Year: {{$elect->year}}
              <br>
              Election Date: {{date("m/d/Y", strtotime($elect->election_date))}}
              <br>
              Status: {{$elect->status}}
              <br>
              <br>
              <input type="hidden" name="election_id" id="election_id" value="{{$elect->id}}" >
              <input type="hidden" name="cand_count15" id="cand_count15" value="{{ $candidates15 ? count($candidates15) : 0 }}" >
              <input type="hidden" name="cand_count16" id="cand_count16" value="{{ $candidates16 ? count($candidates16) : 0 }}" >
              @if($elect->status=='CREATED')
              <button type="button" class="mp-button mp-button--primary" id="open_election">Open Election</button>
              @elseif($elect->status=='OPEN')
              <a href="{{url('admin/election/on-going/'.$elect->id)}}" class="mp-button mp-button--primary">View On-going Status</a>
              <button type="button" class="mp-button mp-button--accent" id="close_election">Close Election</button>
              @elseif($elect->status=='CLOSED')
                 <a href="{{url('admin/election/on-going/'.$elect->id)}}" class="mp-button mp-button--primary">View Results</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card">
            <div class="mp-mb3 mp-text-fw-heavy mp-text-fs-large" align="center">
              SALARY GRADE 1-15
            </div>
            <div class="mp-mb3 mp-text-fw-heavy mp-text-fs-medium" align="center">
              Candidates
            </div>

            <br>
            <br>
            <div class="mp-overflow-x">
              <table class="mp-table mp-text-fs-small">
                <thead>
                  <tr>
                    <th class="mp-text-center">
                      MEMBER NO
                    </th>
                    <th class="mp-text-center">
                      FULL NAME
                    </th>
                    <th class="mp-text-center">
                      CAMPUS
                    </th>
                    <th class="mp-text-center">
                      POSITION
                    </th>
                    <th class="mp-text-center">
                      PHOTO
                    </th>
                    <th class="mp-text-center">
                      ATTACHMENT
                    </th>
                    <th class="mp-text-center">

                    </th>
                    <th class="mp-text-center"></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($candidates15 as $cad15)
                  <tr>
                    <td class="mp-text-center"><strong>{{$cad15->member_no}}</strong></td>
                    <td class="mp-text-center"><strong>{{$cad15->last_name}}, {{$cad15->first_name}}</strong></td>
                    <td class="mp-text-center"><strong>{{$cad15->name}}</strong></td>
                    <td class="mp-text-center"><strong>{{$cad15->position_id}}</strong></td>
                    <td class="mp-text-center"><a href="{{ asset('storage/app/election/photo/'.$cad15->candidate_photo) }}" target="_blank"" class="mp-link mp-link">VIEW</a></td>
                    <td class="mp-text-center"><a href="{{ asset('storage/app/election/attachments/'.$cad15->file_credentials) }}" target="_blank"" class="mp-link mp-link">VIEW</a></td>
                    <td class="mp-text-center">
                      <input type="hidden" name="candidate_id" id="candidate_id" value="{{$cad15->id}}" ><button  type="button"  {{ $elect->status=='CREATED' ? '' : 'disabled' }} class="mp-button remove" value="Remove" style=" background-color: red; color: white"> <i class="mp-icon icon-trash"></i> </button>

                   </td>

                 </tr>
                 @endforeach

               </tbody>
             </table>
           </div>

           <br>
           <br>

@if($elect->status=='CREATED')
           <div class="mp-mb3 mp-text-fw-heavy" align="center">
            ADD CANDIDATE
          </div>
          {{ Form::open(array('url' => '/admin/election/add_candidate_15', 'method' => 'post', 'id'=>'add_candidate_15_form', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
          <div align="center" >
            <div class="mp-pb4 mp-input-group" style="width:35%;"  >
              <label class="mp-input-group__label" for="confirmPassword">
                Member
              </label>

              <select class="mp-input-group__input mp-text-field js-example-basic-single" name="member15_id" id="member15_id">
                @foreach($members15 as $mem15)

                <option value="{{$mem15->id}}">{{$mem15->full_name}}</option>

                @endforeach
              </select>

            </div>
            <input type="hidden" value="{{$elect->id}}" name="election_id">
            <input type="hidden" value="{!! asset('assets/images/') !!}" id="path">
            <div class="mp-pb4 mp-input-group" style="width:35%">
              <label class="mp-input-group__label" >
               Position
             </label>

             <input autocomplete="off"
             class="mp-input-group__input mp-text-field" 
             type="text" 
             id="position15"
             name="position15"
             style="text-align: center"
             value=""
             required 
             readonly

             />
           </div>
           <div class="mp-pb4 mp-input-group" style="width:35%">
            <label class="mp-input-group__label" >
             Campus
           </label>

           <input autocomplete="off"
           class="mp-input-group__input mp-text-field" 
           type="text" 
           id="campus15"
           name="campus15"
           style="text-align: center"
           value=""
           required 
           readonly

           />
         </div>

         <div class="mp-pb4 mp-input-group" style="width:35%">
          <label class="mp-input-group__label" >
           Candidate Photo
         </label>

         <input type="file" required class="form-control" onchange="readURL1(this);" id="photo15" name="photo15" >

         <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />
       </div>



       <div class="mp-pb4 mp-input-group" style="width:35%">
        <label class="mp-input-group__label" >
         Attachment
       </label>

       <input type="file" required class="form-control" onchange="readURL(this);" id="attachment15" name="attachment15" >

       <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />
     </div>

     <div class="mp-text-fs-medium mp-text-center">
       <button type="button" class="mp-button mp-button--accent add_15" {{ $elect->status=='CREATED' ? '' : 'disabled' }} >ADD CANDIDATE</button>
       <br>
       <input type="submit" id="add_candidate_15" style="visibility: hidden;">
     </div>
   </div>
   {{ Form::close() }}
   @endif
 </div>
</div>
</div>
</div>
</div>


<div class="row no-gutters mp-mb4">
  <div class="col-12 mp-ph2 mp-pv2">
    <div class="row no-gutters">
      <div class="col">
        <div class="mp-ph4 mp-pv4 mp-card">
          <div class="mp-mb3 mp-text-fw-heavy mp-text-fs-large" align="center">
            SALARY GRADE 16-ABOVE
          </div>
          <div class="mp-mb3 mp-text-fw-heavy mp-text-fs-medium" align="center">
            Candidates
          </div>

          <br>
          <br>
          <div class="mp-overflow-x">
            <table class="mp-table mp-text-fs-small">
              <thead>
                <tr>
                  <th class="mp-text-center">
                    MEMBER NO
                  </th>
                  <th class="mp-text-center">
                    FULL NAME
                  </th>
                  <th class="mp-text-center">
                    CAMPUS
                  </th>
                  <th class="mp-text-center">
                    POSITION
                  </th>
                  <th class="mp-text-center">
                    PHOTO
                  </th>
                  <th class="mp-text-center">
                    ATTACHMENT
                  </th>
                  <th class="mp-text-center">

                  </th>
                  <th class="mp-text-center"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($candidates16 as $cad16)
                <tr>
                  <td class="mp-text-center"><strong>{{$cad16->member_no}}</strong></td>
                  <td class="mp-text-center"><strong>{{$cad16->last_name}}, {{$cad16->first_name}}</strong></td>
                  <td class="mp-text-center"><strong>{{$cad16->name}}</strong></td>
                  <td class="mp-text-center"><strong>{{$cad16->position_id}}</strong></td>
                  <td class="mp-text-center"><a href="{{ asset('storage/app/election/photo/'.$cad16->candidate_photo) }}" target="_blank"" class="mp-link mp-link">VIEW</a></td>
                  <td class="mp-text-center"><a href="{{ asset('storage/app/election/attachments/'.$cad16->file_credentials) }}" target="_blank"" class="mp-link mp-link">VIEW</a></td>
                  <td class="mp-text-center">
                   <input type="hidden" name="candidate_id" id="candidate_id" value="{{$cad16->id}}" ><button  type="button"  {{ $elect->status=='CREATED' ? '' : 'disabled' }} class="mp-button remove" value="Remove" style=" background-color: red; color: white"> <i class="mp-icon icon-trash"></i> </button>

                 </td>

               </tr>
               @endforeach

             </tbody>
           </table>
         </div>

         <br>
         <br>

@if($elect->status=='CREATED')

         <div class="mp-mb3 mp-text-fw-heavy" align="center">
          ADD CANDIDATE
        </div>
        {{ Form::open(array('url' => '/admin/election/add_candidate_16', 'method' => 'post', 'id'=>'add_candidate_16_form', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
        <div align="center" >
          <div class="mp-pb4 mp-input-group" style="width:35%;"  >
            <label class="mp-input-group__label" for="confirmPassword">
              Member
            </label>

            <select class="mp-input-group__input mp-text-field js-example-basic-single" name="member16_id" id="member16_id">
              @foreach($members16 as $mem16)

              <option value="{{$mem16->id}}">{{$mem16->full_name}}</option>

              @endforeach
            </select>

          </div>
          <input type="hidden" value="{{$elect->id}}" name="election_id">
          <input type="hidden" value="{!! asset('assets/images/') !!}" id="path">
          <div class="mp-pb4 mp-input-group" style="width:35%">
            <label class="mp-input-group__label" >
             Position
           </label>

           <input autocomplete="off"
           class="mp-input-group__input mp-text-field" 
           type="text" 
           id="position16"
           name="position16"
           style="text-align: center"
           value=""
           required 
           readonly

           />
         </div>
         <div class="mp-pb4 mp-input-group" style="width:35%">
          <label class="mp-input-group__label" >
           Campus
         </label>

         <input autocomplete="off"
         class="mp-input-group__input mp-text-field" 
         type="text" 
         id="campus16"
         name="campus16"
         style="text-align: center"
         value=""
         required 
         readonly

         />
       </div>

       <div class="mp-pb4 mp-input-group" style="width:35%">
        <label class="mp-input-group__label" >
         Candidate Photo
       </label>

       <input type="file" required class="form-control" onchange="readURL1(this);" id="photo16" name="photo16" >

       <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />
     </div>



     <div class="mp-pb4 mp-input-group" style="width:35%">
      <label class="mp-input-group__label" >
       Attachment
     </label>

     <input type="file" required class="form-control" onchange="readURL(this);" id="attachment16" name="attachment16" >

     <img id="blah" src="{!! asset('assets/images/image_icon.png') !!}" style="padding-top: 10px;  max-width: 40%" alt="your image" />
   </div>

   <div class="mp-text-fs-medium mp-text-center">
     <button type="button" {{ $elect->status=='CREATED' ? '' : 'disabled' }} class="mp-button mp-button--accent add_16" >ADD CANDIDATE</button>
     <br>
     <input type="submit" id="add_candidate_16" style="visibility: hidden;">
   </div>
 </div>
 {{ Form::close() }}
 @endif
</div>
</div>
</div>
</div>
</div>



@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
  $(function() {
    $('#year').datepicker({
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'yy',
      onClose: function(dateText, inst) { 
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, 1));
      }
    });

  });

  $(document).ready(function(){
   $('#close_election').on('click',function(e){
    var election_id=$('#election_id').val();
    var count_15=$('#cand_count15').val();
    var count_16=$('#cand_count16').val();
    var confirm=true;

  
   if(confirm)
   {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to Close this Election?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.value) {
        $.ajax({
         type:'POST',
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'{{url("/admin/election/close_election")}}',
        data: { 
          'election_id': election_id
        },
        datatype:'json',
        success:function(data) {
          Swal.fire(
            'Confirmed',
            'Election is now Closed',
            'success'
            ).then(function() {
              location.reload();
            });

          }
        });

      }
    })
  }
})

   $('#open_election').on('click',function(e){
    var election_id=$('#election_id').val();
    var count_15=$('#cand_count15').val();
    var count_16=$('#cand_count16').val();
    var confirm=true;

    if(count_15<1)
    {
     confirm=false;
     Swal.fire({
       type: "warning",
       title: 'Number of candidates for SG 1-15 must be atleast 1'      
     })
     return;
   }
   if(count_16<1)
   {
     confirm=false;
     Swal.fire({
       type: "warning",
       title: 'Number of candidates for SG 16-ABOVE must be atleast 1'      
     })
     return;
   }

   if(confirm)
   {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to Open this Election?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes'
    }).then((result) => {
      if (result.value) {
        $.ajax({
         type:'POST',
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url:'{{url("/admin/election/open_election")}}',
        data: { 
          'election_id': election_id
        },
        datatype:'json',
        success:function(data) {
          Swal.fire(
            'Confirmed',
            'Election is now Open',
            'success'
            ).then(function() {
              location.reload();
            });

          }
        });

      }
    })
  }
})

   $('.remove').click(function () {
    Swal.fire({
      title: 'Are you sure you want to remove this Candidate?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
      if(result.value)
      {
        var candidate_id=$(this).closest("tr").find('input[name="candidate_id"]').val();
        var deleteurl=$('#deleteurl').attr('url');
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type:'POST',
          url:'{{url("/admin/election/remove_candidate")}}',
          dataType: "json",
          data: { 
            'candidate_id': candidate_id
          },
          success:function(data) {

            Swal.fire(
              'Removed',
              'Candidate has been removed.',
              'success'
              ).then(function() {
                location.reload();
              });

            }
          });

      }
      else
      {

      }
    })
  })

   $("#member15_id").change(function(){
    var mem=$("#member15_id").val();

    $.ajax({
     type:'POST',
     headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url:'{{url("/admin/election/get_member_details")}}',
    data:'mem_id='+mem,
    datatype:'json',
    success:function(data) {

      data = $.parseJSON(data);
      console.log(data);
      $("#position15").val(data.position_id);
      $("#campus15").val(data.name);
    }
  });
  })

//16

$("#member16_id").change(function(){
  var mem=$("#member16_id").val();

  $.ajax({
   type:'POST',
   headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  url:'{{url("/admin/election/get_member_details")}}',
  data:'mem_id='+mem,
  datatype:'json',
  success:function(data) {

    data = $.parseJSON(data);
    console.log(data);
    $("#position16").val(data.position_id);
    $("#campus16").val(data.name);
  }
});
})


$('.js-example-basic-single').select2();

$('.add_15').on('click',function(e){

  var confirm=true;

  var member15_id= $('#member15_id').val();
  if(!member15_id)
  {
   confirm=false;
   $('#member15_id').focus();
   Swal.fire({
     type: "warning",
     title: 'Please select a member'      
   })
   return;
 }

 var position15= $('#position15').val();
 if(!position15)
 {
   confirm=false;
   $('#member15_id').focus();
   Swal.fire({
     type: "warning",
     title: 'Please select a member'      
   })


   return;
 }
 var campus15= $('#campus15').val();
 if(!campus15)
 {
   confirm=false;
   $('#member15_id').focus();
   Swal.fire({
     type: "warning",
     title: 'Please select a member'      
   })


   return;
 }


 var photo15= $('#photo15').val();
 if(!photo15)
 {
   confirm=false;
   $('#photo15').focus();
   Swal.fire({
     type: "warning",
     title: 'Candidate Photo is required'      
   })
   return;
 }

 var attachment15= $('#attachment15').val();
 if(!attachment15)
 {
   confirm=false;
   $('#attachment15').focus();
   Swal.fire({
     type: "warning",
     title: 'Attachment is required'      
   })
   return;
 }

 if(confirm)
 {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to add this candidate?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit'
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#add_candidate_15').trigger('click');

      }
    })
  }
})

//16

$('.add_16').on('click',function(e){

  var confirm=true;

  var member16_id= $('#member16_id').val();
  if(!member16_id)
  {
   confirm=false;
   $('#member16_id').focus();
   Swal.fire({
     type: "warning",
     title: 'Please select a member'      
   })
   return;
 }

 var position16= $('#position16').val();
 if(!position16)
 {
   confirm=false;
   $('#member16_id').focus();
   Swal.fire({
     type: "warning",
     title: 'Please select a member'      
   })


   return;
 }
 var campus16= $('#campus16').val();
 if(!campus16)
 {
   confirm=false;
   $('#member16_id').focus();
   Swal.fire({
     type: "warning",
     title: 'Please select a member'      
   })


   return;
 }


 var photo16= $('#photo16').val();
 if(!photo16)
 {
   confirm=false;
   $('#photo16').focus();
   Swal.fire({
     type: "warning",
     title: 'Candidate Photo is required'      
   })
   return;
 }

 var attachment16= $('#attachment16').val();
 if(!attachment16)
 {
   confirm=false;
   $('#attachment16').focus();
   Swal.fire({
     type: "warning",
     title: 'Attachment is required'      
   })
   return;
 }

 if(confirm)
 {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to add this candidate?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit'
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#add_candidate_16').trigger('click');

      }
    })
  }
})


})


function readURL(input) {
  console.log(input.id);

  var path=$('#path').val();

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var allowed  = ["image/jpeg", "image/png", "application/pdf"];
    var res=false;
    if(allowed.includes(input.files[0].type))
    {
      console.log(input.files[0].type);


      reader.onload = function(e) {
       if(input.files[0].type=="application/pdf")
       {
        $(input).next().attr('src', path+'/pdfimage.png');
      }
      else
      {
        $(input).next().attr('src', e.target.result);
      }
    }

    reader.readAsDataURL(input.files[0]);
  }
  else
  {
    alert('Invalid File Type (allowed file types jpeg, png , pdf)');
    $(input).val('');
  }

}
}

function readURL1(input) {
  console.log(input.id);

  var path=$('#path').val();

  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var allowed  = ["image/jpeg", "image/png"];
    var res=false;
    if(allowed.includes(input.files[0].type))
    {
      console.log(input.files[0].type);


      reader.onload = function(e) {

        $(input).next().attr('src', e.target.result);

      }

      reader.readAsDataURL(input.files[0]);
    }
    else
    {
      alert('Invalid File Type (allowed file types jpeg, png)');
      $(input).val('');
    }

  }
}



</script>