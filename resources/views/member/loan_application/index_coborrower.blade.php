@extends('layouts/main')
@section('content_body')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<div class="container mp-container">
 
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-primary">
      Loan Application
    </div>
  </div>
  

  <div class="row no-gutters mp-mb4">
    <div class="col-12 mp-ph2 mp-pv2">
      <div class="row no-gutters">
       
        <div class="col-6 col-lg-3">
          <div class="mp-tab ">
            <a class="mp-tab__link" href="{{ url('/member/loan-app') }}">
              Personal Loan
            </a>
          </div>
        </div>

        <div class="col-6 col-lg-3">
          <div class="mp-tab mp-tab--active">
            <a class="mp-tab__link" href="{{ url('/member/coborrower') }}">
              Co-Borrower Loan
            </a>
          </div>
        </div>
        
      </div>
      <div class="row no-gutters">
        <div class="col">
          <div class="mp-ph4 mp-pv4 mp-card mp-card--tabbed">

            <div class="mp-overflow-x">
              <table class="mp-table mp-text-fs-small">
                <thead>
                  <tr>
                    <th>Date Applied</th>
                    <th>Principal Borrower</th>
                    <th>Loan Status</th>
                    <th class="mp-text-center"></th>
                   
                  </tr>
                </thead>
                <tbody>
                 
                 
                 <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td class="mp-text-center">
                    <a data-md-tooltip="View Details" href="{{url('/admin/member_soa/')}}">
                            <i class="mp-icon md-tooltip icon-book-open mp-text-c-primary mp-text-fs-large"></i>
                          </a>
                    
                  </td>
                  
                   
                    
                  </tr>
                  
              </tbody>
            </table>
          </div>
          
          <div class="mp-card__footer__pair">
            
            <div>
            
              
        
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
      $(function() {
        $('input[name="optradio"]').change(function()
        {
          console.log(this.value);
          if (this.value=='A') {
            $('input[name="bank"]').removeAttr("disabled");
            $('#acc_name').removeAttr("disabled");
            $('#acc_num').removeAttr("disabled");
            $('input[name="bank"]').attr('required', 'true');
            $('#acc_name').attr('required', 'true');
            $('#acc_num').attr('required', 'true');
          }
          else
          {
            $('input[name="bank"]').attr('disabled', 'disabled');
            $('#acc_name').attr('disabled', 'disabled');
            $('#acc_num').attr('disabled', 'disabled');
          }

        });


      });

      $('#cast').click(function () {

    // alert($(this).closest("tr").find('input[name="bene_id"]').val())
    Swal.fire({
      title: 'Are you sure you want to update?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, proceed'
    }).then((result) => {
      if (result.value) {
       $("#sub").click();

     }
   })
  })

      function isNumber(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode != 46 && charCode > 31 
          && (charCode < 48 || charCode > 57))
         return false;

       return true;
     }

   </script>
   @endsection
