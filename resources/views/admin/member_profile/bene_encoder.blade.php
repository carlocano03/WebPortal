@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<div class="container mp-container">
  <div class="row no-gutters mp-mt4 justify-content-center">
    <div class="col-12 col-lg-10 mp-ph2 mp-pv2">
      <div class="mp-pt4 mp-text-fs-large mp-text-c-primary">

        <br>
        <br>
        Beneficiary Encoder
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
             <table style="width:100%" class="mp-table mp-text-fs-small" id="dataTable">
              <thead class="mp-text-fs-large" >
               <tr>
                <th style="text-align:center">Name</th>
                <th style="text-align:center">Birthdate</th>
                <th style="text-align:center">Relationship</th>
                <th style="text-align:center"></th>
              </tr>
            </thead>
            <tbody>



            </tbody>
          </table>

        </div>
      </div>
    </div>

    <br>
    <br>
    <div id='json' align="center">
    </div>
    <div class="mp-pb4 mp-input-group">
      <label class="mp-input-group__label" for="currentPassword">
       Name
     </label>
     <input class="mp-input-group__input mp-text-field" 
     type="text"
     name="beni_name" 
     id="beni_name"
     required 
     />

   </div>
   <div class="mp-pb4 mp-input-group">
    <label class="mp-input-group__label" for="password">
      Relationship
    </label>
    <input 
    class="mp-input-group__input mp-text-field" 
    type="text"
    name="relationship"
    id="relationship"
    required 
    />
  </div>
  <div class="mp-pb4 mp-input-group">
    <label class="mp-input-group__label" for="confirmPassword">
      Birthdate
    </label>
    <input autocomplete="off" 
    class="mp-input-group__input mp-text-field" 
    type="text" 
    id="birth_date"
    name="birth_date" 
    value=""
    required 
    />
  </div>
  <div class="mp-pt3 row justify-content-center align-items-center">
    <div class="col col-auto">
      <button type="button"  name='add-bene' id="add-bene" class="mp-button mp-button--accent">Add Beneficiary</button>
      <button type="button"  name='generate' id="generate" class="mp-button mp-button-accent" style="background-color:#48a19a!important; color: white!important;">Generate</button>
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
    $( "#birth_date" ).datepicker({
      dateFormat: 'yy-mm-dd'
    });

    $('#generate').click(
      function($e) {
       $( "#json" ).empty(); 
       $e.preventDefault();

       var array = [];
       var all = [];

       $('#dataTable tr').has('td').each(function() {
        var arrayItem = [];
        $('td', $(this)).each(function(index, item) {
          if(index!=3)
          {
            var itemm = $(item).html();
            if(itemm=="")
            {
              itemm=null;
            }
            arrayItem.push(itemm);

          }
          
        });
        array.push(arrayItem);
        console.log(JSON.stringify(array));

        
      });
       $( "#json" ).append( "<strong>"+JSON.stringify(array)+"</strong>" );

     } 
     );
  });


  
  
  $('#add-bene').click(
    function($e) {
      var name=$('#beni_name').val();
      $('#beni_name').val('');
      var relationship=$('#relationship').val();
      $('#relationship').val('');
      var birthdate=$('#birth_date').val();
      $('#birth_date').val('');
      $e.preventDefault();      
      $('table tbody').append(
        "<tr>\n" +
        "<td style='text-align:center'>"+name+"</td>"+ 
        "<td style='text-align:center'>"+birthdate+"</td>"+ 
        "<td style='text-align:center'>"+relationship+"</td>"+ 
        " <td style='text-align:center; width:10px'><button  type='button'  name='rem_bene' id='rem_bene'  class='mp-button remove' value='Remove' style=' background-color: red; color: white'> <i class='mp-icon icon-trash'></i> </button></td>"+ 
        "</tr>\n"
        );
    }
    );



  $(document).on('click', 'button.remove', function () {
   $(this).closest('tr').remove();
   return false;
 });


</script>
@endsection
