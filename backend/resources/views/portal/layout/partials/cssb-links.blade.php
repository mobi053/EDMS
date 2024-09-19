<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<!-- Font Awesome -->
<link rel="stylesheet" href="{{url('/portal')}}/plugins/fontawesome-free/css/all.min.css">

<!-- Theme style -->
<link rel="stylesheet" href="{{url('/portal')}}/dist/css/adminlte.min.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />


<link rel="stylesheet" href="{{url('/portal')}}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('/portal')}}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{url('/portal')}}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<!-- Toastr -->
<link rel="stylesheet" href="{{url('/portal')}}/plugins/toastr/toastr.min.css">

<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{url('/portal')}}/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<!-- Select2 -->
<link rel="stylesheet" href="{{url('/portal')}}/plugins/select2/css/select2.min.css">

<!-- Daterange -->
<link rel="stylesheet" href="{{url('/portal')}}/plugins/daterangepicker/daterangepicker.css">

<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

<!-- Bootstrap Slider -->
<link rel="stylesheet" href="{{url('/portal')}}/plugins/bootstrap-slider/css/bootstrap-slider.min.css">

<!--mycss--->



<!---andmycss js-->

<style type="text/css">
    form label.required:after {
        color: red;
        content: " *";
    }

    .nowrap {
        white-space: nowrap;
    }

    .container {
        position: relative;
        display: inline-block;
        height: 100px;
        width: 100px;
    }

    .close-button {
        position: absolute;
        top: -10px;
        right: -20px;
        z-index: 999;
        cursor: pointer;
    }

    /*  total duration css after filter  */
    .clock-day:before {
        /* content: var(--timer-day); */
        content: "25";
    }

    .clock-hours:before {
        content: var(--timer-hours);
        /* content: "18"; */
    }

    .clock-minutes:before {
        content: var(--timer-minutes);
        /* content: "34"; */
    }

    .clock-seconds:before {
        content: var(--timer-seconds);
        /* content: "17"; */
    }

    .clock-container {
        /* margin-top: 30px; */
        margin-bottom: 30px;
        /* background-color: #080808; */
        background-color: #343a40;
        border-radius: 5px;
        /* padding: 60px 20px; */
        /*box-shadow: 1px 1px 5px rgba(255, 255, 255, 0.15), 0 15px 90px 30px rgba(0, 0, 0, 0.25); */
        display: flex;
    }

    .clock-col {
        text-align: center;
        margin-right: 40px;
        margin-left: 40px;
        min-width: 90px;
        position: relative;
    }

    .clock-col:not(:last-child):before,
    .clock-col:not(:last-child):after {
        content: "";
        background-color: rgba(255, 255, 255, 0.3);
        height: 5px;
        width: 5px;
        border-radius: 50%;
        display: block;
        position: absolute;
        right: -42px;
    }

    .clock-col:not(:last-child):before {
        top: 35%;
    }

    .clock-col:not(:last-child):after {
        top: 50%;
    }

    .clock-timer:before {
        color: #fff;
        font-size: 3.2rem;
        text-transform: uppercase;
    }
    .clock-timer {
        color: #fff;
        font-size: 3.2rem;
        text-transform: uppercase;
    }

    .clock-label {
        color: rgba(255, 255, 255, 0.35);
        text-transform: uppercase;
        font-size: 1rem;
        margin-top: 10px;
    }

    @media (max-width: 500px) {
        .clock-container {
            flex-direction: column;
            padding-top: 40px;
            padding-bottom: 40px;
        }

        .clock-col+.clock-col {
            margin-top: 20px;
        }

        .clock-col:before,
        .clock-col:after {
            display: none !important;
        }
    }

    .timeline>div>.counter {
        background-color: #adb5bd;
        border-radius: 50%;
        font-size: 16px;
        font-weight: 700;
        height: 30px;
        left: 18px;
        line-height: 30px;
        position: absolute;
        text-align: center;
        top: 0;
        width: 30px;
    }

    .task-counter {
        padding: 11px;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
/*
************************************************

************************************************
subtask
 */
.timeline>div>div>.timeline-item {
    box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
    border-radius: .25rem;
    background-color: #fff;
    color: #495057;
    margin-left: 60px;
    margin-right: 15px;
    margin-top: 0;
    padding: 0;
    position: relative;
}
.timeline>div>div>.timeline-item>.timeline-header, .timeline>div>.timeline-item>div.collapse>.timeline-header {
    border-bottom: 1px solid rgba(0, 0, 0, .125);
    color: #495057;
    font-size: 16px;
    line-height: 1.1;
    margin: 0;
    padding: 10px;
}
.preview-container {
    width: 100px; /* Adjust the width as needed */
    height: 100px; /* Adjust the height as needed */
    border: 1px solid #ccc;
    overflow: hidden;
    position: relative;
}

.preview-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pdf-preview,
.generic-preview {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f0f0f0;
}

.pdf-preview p,
.generic-preview p {
    font-size: 16px;
    color: #333;
}

    .badge-activity:nth-child(odd) {
        color: #7a99c6
    }

    .badge-activity {
        background-color: #fff;
    }

    .table.table-bordered.dataTable.no-footer {
        max-width: 100% !important;
    }

    .attachment-container {
    display: flex;
    overflow-x: auto; /* Add horizontal scroll if needed */
    flex-wrap: nowrap; /* Prevent wrapping to next line */
}

.attachment-item {
    margin-right: 10px; /* Adjust spacing between attachments */
}

.attachment-image,
.attachment-video,
.attachment-pdf,
.attachment-document {
    max-width: 100px;
    max-height: 100px;
    margin: 5px;
}
.select2-container {
    max-width: 100%;
    display: inline-block;
    
}
.select2-container .select2-selection--single {
    height: calc(2.25rem + 2px);
    border: 1px solid #ced4da;
}
#end_date, #start_date{
    width: 224px;
    height: calc(2.25rem + 1px);
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding-left: 5px;
    padding-right: 5px;
   
}

#subtaskTable_filter, #subtaskTablet_filter {
    display: inline-flex;
    float: right;
}
#subtaskTable_wrapper .dt-buttons, #subtaskTablet_wrapper .dt-buttons{
    display: inline-flex;

}

.select2 {
    text-align:left;
    margin-right: 5px;
    display: block;
}
.btn-group{
    margin-right: 10px;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice{
    background-color: #007bff;
    border: 1px solid #006fe6;
    border-radius: 4px;
    cursor: default;
    float: left;
    margin-right: 5px;
    margin-top: 5px;
    padding: 0 5px;

}


.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #111;
}
.user-report-form .select2 {
    display: inline-block;
}
.hourly-table td {
    vertical-align: middle;
}
.hourly-table .form-group {
    margin-bottom: 0;
}
/* Table Row Colors */
.row-primary {
    color: #004085 !important;
    background-color: #cce5ff !important;
    border-color: #b8daff !important;
}
.row-secondary {
    color: #525048 !important;
    background-color: #d2d6de !important;
    border-color: #b7b6b5 !important;
}
.row-success {
    color: #155724 !important;
    background-color: #d4edda !important;
    border-color: #c3e6cb !important;
}
.row-warning {
    color: #856404 !important;
    background-color: #fff3cd !important;
    border-color: #ffeeba !important;
}
.row-danger {
    background-color: #f8d7da !important;
    color: #721c24 !important;
    border-color: #f5c6cb !important;
}
</style>