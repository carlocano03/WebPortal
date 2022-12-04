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

.just-year .ui-datepicker-calendar {
 display: none;
}
.just-year .ui-datepicker-month {
 display: none;
}
.just-year .ui-datepicker-prev{
 display: none;
}
.just-year .ui-datepicker-next{
 display: none;
} 
</style>
<div class="container mp-container">
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Election Module
    </div>
  </div>

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card">

           <div class="mp-text-fs-medium {{ Session::has('error') or Session::has('success') ? 'mp-mb4' : '' }}" align="center">
            @if(Session::has('error'))
            <span style="color:red"><strong>{{ Session::get('error') }}</strong></span>
            @endif
            @if(Session::has('success'))
            <span style="color:green"><strong>{{ Session::get('success') }}</strong></span>
            @endif
          </div>

          <div class="mp-text-right">
             <!--     <a href="{{url('/admin/setup_election')}}"  class="mp-button mp-button--primary">
        Setup Election
      </a> <br>
    -->
  </div>

  <div class="row no-gutters mp-search-header">

    <div class="col-lg-8 col-md-4 d-sm-none d-md-block"></div>
<!--     <div class="col-lg-4 col-md-8 col-sm-12 mp-pb3 mp-input-search__container">
      <div class="mp-input-search__input_div">


        <input class="mp-input-search__input" type="text" id="search" placeholder="Search" value="{{ isset($_GET['q']) ? $_GET['q'] : '' }}"/>

      </div>
      <button class="mp-input-search__button mp-button mp-button--accent" id="search_btn_albums" type="button">  <i class="mp-icon icon-magnifier mp-text-c-white mp-text-fw-xheavy mp-text-fs-large"></i></button>

    </div> -->

  </div>
  <div class="mp-overflow-x">
    <table class="mp-table mp-text-fs-small">
      <thead>
        <tr>
          <th class="mp-text-center">
            YEAR
          </th>
          <th class="mp-text-center">
            CLUSTER
          </th>
          <th class="mp-text-center">
            ELECTION DATE
          </th>
          <th class="mp-text-center">
            TIME OPENED
          </th>
          <th class="mp-text-center">
            TIME CLOSED
          </th>
          <th class="mp-text-center">
            DATE CREATED
          </th>
          <th class="mp-text-center">
            STATUS
          </th>
          <th class="mp-text-center"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($elections as $elec)
        <tr>
          <td class="mp-text-center"><strong>{{$elec->year}}</strong></td>
          <td class="mp-text-center"><strong>{{$elec->acronym}}</strong></td>
          <td class="mp-text-center"><strong>{{date("m/d/Y", strtotime($elec->election_date))}}</strong></td>
          <td class="mp-text-center"><strong>{{$elec->time_open}}</strong></td>
          <td class="mp-text-center"><strong>{{$elec->time_closed}}</strong></td>
          <td class="mp-text-center">{{date("m/d/Y h:i A", strtotime($elec->created_at))}}</td>
          @if($elec->status=="CREATED")
          <td class="mp-text-center" style="color:#feb236;"><strong>{{$elec->status}}</strong></td>
          @endif
          @if($elec->status=="CLOSED")
          <td class="mp-text-center" style="color:#d64161;"><strong>{{$elec->status}}</strong></td>
          @endif
          @if($elec->status=="OPEN")
          <td class="mp-text-center" style="color:#034f84;"><strong>{{$elec->status}}</strong></td>
          @endif

          <td class="mp-text-center">
            <a data-md-tooltip="View" href="{{url('/admin/election/detail').'/'.$elec->id}}">
              <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
            </a>

          </td>




        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  
  @if(isset($_GET['q']))
  {!! $elections->appends(['q' => $_GET['q']])->links('pagination.default') !!} 
  @else
  {!! $elections->links('pagination.default') !!}
  @endif


  <br>
  <br>
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

          <div class="mp-mb3 mp-text-fw-heavy" align="center">
            SETUP NEW ELECTION
          </div>
          {{ Form::open(array('url' => '/admin/election/create', 'method' => 'post', 'id'=>'create_election_form', 'enctype' => 'multipart/form-data', 'autocomplete'=>'off')) }}
          <div align="center" >
            <div class="mp-pb4 mp-input-group" style="width:35%;"  >
              <label class="mp-input-group__label" for="confirmPassword">
                CLUSTER
              </label>
              @if(getUserdetails()->role=='SUPER_ADMIN')
              <select class="mp-input-group__input mp-text-field" name="cluster_id" id="cluster_id">
                @foreach($clusters as $cluster)
                @if($cluster->id<>1)
                <option value="{{$cluster->id}}">{{$cluster->acronym}}</option>
                @endif
                @endforeach
              </select>
              @else        
              <input 
              class="mp-input-group__input mp-text-field" 
              type="text"
              name="cluster_id"
              id="cluster_id"
              onkeypress=""
              style="text-align: center" 
              value="{{getUserdetails()->name}}"
              readonly
              />
              @endif
            </div>
            <div class="mp-pb4 mp-input-group" style="width:35%">
              <label class="mp-input-group__label" >
               Year
             </label>

             <input autocomplete="off"
             class="mp-input-group__input mp-text-field" 
             type="text" 
             id="year"
             name="year"
             style="text-align: center"
             value="{{date('Y')}}"
             required 
             readonly

             />
           </div>

           <div class="mp-pb4 mp-input-group" style="width:35%">
            <label class="mp-input-group__label" >
             Election Date
           </label>
           <input autocomplete="off"
           class="mp-input-group__input mp-text-field" 
           type="text" 
           id="election_date"
           name="election_date"
           style="text-align: center"
           value=""
           placeholder="mm/dd/yyyy" 
           required 
           readonly

           />
         </div>

         <div class="mp-text-fs-medium mp-text-center">
           <button type="button" class="mp-button mp-button--accent create" >Create</button>
           <br>
           <input type="submit" id="create_election" style="visibility: hidden;">
         </div>
       </div>
       {{ Form::close() }}

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
      beforeShow: function( input, inst){
        $(inst.dpDiv).addClass('just-year');
      },
      onClose: function(dateText, inst) { 
        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
        $(this).datepicker('setDate', new Date(year, 1));
        $(inst.dpDiv).removeClass('just-year');
      }
    });

  });

  $( function() {
    $( "#election_date" ).datepicker();
  });

  $(document).ready(function(){
   $('.create').on('click',function(e){

    var confirm=true;

    var cluster= $('#cluster_id').val();
    if(!cluster)
    {
     confirm=false;
     $('#cluster_id').focus();
     Swal.fire({
       type: "warning",
       title: 'Cluster is required'      
     })
     return;
   }

   $.ajax({
     type:'POST',
     headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url:'{{url("/admin/election/is_valid")}}',
    data: { 
      'cluster': cluster
    },
    datatype:'json',
    success:function(data) {
      if(data==2)
      {
        confirm=false;
        Swal.fire({
         type: "warning",
         title: 'You are not allowed to create a new election module because there is currently an existing election module that is open.'      
       })
        return;
      }
    }
  });

   var year= $('#year').val();
   if(!year)
   {
     confirm=false;
     $('#year').focus();
     Swal.fire({
       type: "warning",
       title: 'Year is required'      
     })


     return;
   }
   

   var year= $('#election_date').val();
   if(!year)
   {
     confirm=false;
     $('#election_date').focus();
     Swal.fire({
       type: "warning",
       title: 'Election Date is required'      
     })


     return;
   }

   if(confirm)
   {
    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to create this election?',
      
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Submit'
    }).then((result) => {
      if (result.value) {
        console.log();
        var res=(result.value);
        $('#create_election').trigger('click');

      }
    })
  }
})
 })

</script>