<!-- jQuery -->
<script src="{{url('/portal')}}/plugins/jquery/jquery.min.js"></script>




<!-- Bootstrap 4 -->
<script src="{{url('/portal')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="{{url('/portal')}}/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="{{url('/portal')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('/portal')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{url('/portal')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('/portal')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- SweetAlert2 -->
<script src="{{url('/portal')}}/plugins/sweetalert2/sweetalert2.min.js"></script>

<!-- Toastr -->
<script src="{{url('/portal')}}/plugins/toastr/toastr.min.js"></script>

<!-- Select2 -->
<script src="{{url('/portal')}}/plugins/select2/js/select2.full.min.js"></script>

<!-- Moment -->
<script src="{{url('/portal')}}/plugins/moment/moment.min.js"></script>

<!-- Daterange -->
<script src="{{url('/portal')}}/plugins/daterangepicker/daterangepicker.js"></script>

<!-- Bootstrap Slider -->
<script src="{{url('/portal')}}/plugins/bootstrap-slider/bootstrap-slider.min.js"></script>
<!-- jQuery Knob -->
<script src="{{url('/portal')}}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- <script src="{{url('/portal')}}/plugins/urdu/urdutextbox.js"></script> -->

<!-- Highcharts -->
<script src="{{url('/portal')}}/plugins/highcharts-11.2.0/highcharts.js"></script>
<script src="{{url('/portal')}}/plugins/highcharts-11.2.0/modules/exporting.js"></script>
<script src="{{url('/portal')}}/plugins/highcharts-11.2.0/modules/export-data.js"></script>
<script src="{{url('/portal')}}/plugins/highcharts-11.2.0/modules/accessibility.js"></script>

<script>
    var Toast = Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 3000
    });

    function toast_error(message){
        toastr.error(message)
    }

    function toast_success(message){
        toastr.success(message)
    }

    function toast_info(message){
        toastr.info(message)
    }

    function sweet_alert_info(message)
    {
        Toast.fire({
            icon: 'info',
            title: message
        });
    }

    function delete_confirmation(link="http://www.google.com", text="You won't be able to revert this!")
    {
        Swal.fire({
            title: 'Are you sure?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = link;
            }
        })
    }
</script>


@if(session('success'))
<script type="text/javascript"> 
    toast_success("{{session('success')}}")
</script>
@endif

@if(session('error'))
<script type="text/javascript"> 
    toast_error("{{session('error')}}")
</script>
@endif

@if ($errors->any())
@foreach ($errors->all() as $error)
<script type="text/javascript">
    toast_error("{{$error}}")
</script>
@endforeach
@endif

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script> -->
<script src="{{url('/portal')}}/plugins/dropzone/min/dropzone.min.js"></script>

<script>
    var uploadedDocumentMap = {}
      Dropzone.options.documentDropzone = {
        url: "{{ route('image.store') }}",
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        headers: {
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
          $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
          uploadedDocumentMap[file.name] = response.name
        },
        removedfile: function (file) {
          file.previewElement.remove()
          var name = ''
          if (typeof file.file_name !== 'undefined') {
            name = file.file_name
          } else {
            name = uploadedDocumentMap[file.name]
          }
          $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
        },
        init: function () {
        }
      }

</script>
<script>
    // Add a click event listener to the notification icon
    $(document).ready(function() {
        $('#notificationIcon').click(function() {
            // Open the notification modal
            $('#notificationModal').modal('show');
        });
    });
    
</script>

<script>
      $('.modalsearch').select2();
    </script>
    

