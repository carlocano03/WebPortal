@extends('layouts/main')
@section('content_body')
<div class="container mp-container">
  <div class="row no-gutters mp-mt5">
    <div class="col-12 mp-ph2 mp-pv2 mp-text-fs-large mp-text-c-accent">
      Import
    </div>
  </div>
 
    <div class="row no-gutters mp-mb4">
      <div class="col-12 mp-ph2 mp-pv2">
        <div class="row no-gutters">
         
          <div class="col-12 col-md-4 col-lg-3">
            <div class="mp-tab mp-tab--accent mp-tab--active">
              <a class="mp-tab__link" href="{{url('/admin/import_member')}}">
               Import Members
              </a>
            </div>
          </div>
           <div class="col-12 col-md-4 col-lg-3">
            <div class="mp-tab mp-tab--accent ">
              <a class="mp-tab__link" href="{{url('/admin/import_equity')}}">
               Update Equity
              </a>
            </div>
          </div>
           <div class="col-12 col-md-4 col-lg-3">
            <div class="mp-tab mp-tab--accent ">
              <a class="mp-tab__link" href="{{url('/admin/import_loan')}}">
               Update Loan Transaction
              </a>
            </div>
          </div>
         
        </div>
        <div class="row no-gutters">
          <div class="col">
            <div class="mp-pb4 mp-pv4 mp-card mp-card--tabbed">
              <div class="mp-pt3 mp-pb3 mp-text-fs-small mp-text-right">
                 <a class="mp-link" href="{{url('/admin/beneficiary-encoder')}}">Generate Beneficiary Format</a>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="mp-link" href="{{url('/admin/tempass')}}">Download Temporary Passwords</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="mp-link" href="{{url('/templates/new_members_template.csv')}}">Download the template (csv)</a>

              </div>
              <form id="import" class="mp-dropzone" action="{{url('/admin/import_member')}}" method="post" enctype="multipart/form-data">
                <div class="mp-dropzone__default dz-message" data-dz-message>
                  <span>Drop CSV file here or click to upload</span>
                </div>
              </form>
              <div class="mp-pt3 mp-pb4">
                <button id="uploadButton" type="button" class="mp-button mp-button--accent" disabled>Upload</button>
                
                <!-- <div class="mp-pt3 mp-pb3 mp-text-fs-small mp-text-right">
                  <a class="mp-link" href="{{url('/admin/tempass')}}">Download Temporary Passwords</a>
                </div> -->
                
              </div>
              <div class="mp-dropzone__template">
                <div id="filePreview" class="mp-dropzone__preview">
                  <div class="mp-mr2 mp-mt1 mp-dropzone__thumb">
                    <img data-dz-thumbnail />
                    <i class="mp-icon icon-doc mp-text-c-primary mp-text-fs-xxxlarge"></i>
                  </div>
                  <div class="mp-dropzone__details">
                    <div class="mp-dropzone__filename" data-dz-name></div>
                    <div class="mp-dropzone__size" data-dz-size></div>
                    <div class="mp-dropzone__remove mp-mt2 mp-text-fs-small">
                      <a href="#" class="mp-link" data-dz-remove>Remove</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="processingModal" aria-hidden="true" class="mp-modal">
    <div tabindex="-1" class="mp-modal__overlay">
      <div role="dialog" aria-modal="true" aria-labelledby="processingModal" class="mp-modal__content">
        <div class="mp-card mp-pv3 mp-ph3">
          <div class="mp-mvauto mp-pt3 mp-pb4"><div class="mp-spinner mp-spinner--accent mp-spinner--large">
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
  <div></div>
</div>
</div>
          <div class="mp-text-fs-large mp-text-center mp-pb3 mp-text-c-primary">Uploading CSV</div>
          <div class="mp-text-center mp-pb2">Please do not refresh the browser or navigate away from this page.</div>
        </div>
      </div>
    </div>
  </div>
  <div id="successModal" aria-hidden="true" class="mp-modal">
    <div tabindex="-1" class="mp-modal__overlay" data-micromodal-close>
      <div role="dialog" aria-modal="true" aria-labelledby="successModal" class="mp-modal__content">
        <div class="mp-card mp-pv3 mp-ph3">
          <div class="mp-text-center mp-pt3 mp-pb4">
            <i style="font-size: 5rem;" class="mp-text-c-primary mp-icon icon-check"></i>
          </div>
          <div class="mp-text-fs-large mp-text-center mp-pb4">Success!</div>
          <div class="mp-pb3 mp-modal__message">The contents of the CSV file have been imported successfully.</div>
          <div>
            <a class="mp-link mp-link--primary mp-modal__view-details" href="#">
              <span>View details</span> <i class="mp-icon mp-icon--small icon-arrow-down"></i>
            </a>
          </div>
          <div class="mp-modal__details"><ul></ul></div>
          <div class="mp-pt4 mp-text-right">
            <button type="button" class="mp-button mp-button--mini" data-micromodal-close>Close</button>
           <a href="{{url('/admin/members')}}" class="mp-ml2 mp-button mp-button--accent mp-button--mini">View Members</a>
           <!--  <button type="button" class="" onclick="">
              View Members
            </button> -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="errorModal" aria-hidden="true" class="mp-modal">
    <div tabindex="-1" class="mp-modal__overlay" data-micromodal-close>
      <div role="dialog" aria-modal="true" aria-labelledby="errorModal" class="mp-modal__content">
        <div class="mp-card mp-pv3 mp-ph3">
          <div class="mp-text-center mp-pt3 mp-pb4">
            <i style="font-size: 5rem; color: #CC0000;" class="mp-icon icon-close"></i>
          </div>
          <div class="mp-text-fs-large mp-text-center mp-pb4">Import Failed</div>
          <div class="mp-pb3 mp-modal__message">Your CSV file contains errors that must be resolved before importing. See details below.</div>
          <div class="mp-modal__details"><ul></ul></div>
          <div class="mp-pt4 mp-text-right">
            <button class="mp-ml2 mp-button mp-button--mini" data-micromodal-close>Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
 @endsection

@section('scripts')
<script src="{{ asset('/dist/adminDashboard.js') }}"></script>
<script src="{{ asset('/dist/adminImport.js') }}"></script>  
@endsection