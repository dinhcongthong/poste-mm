<!DOCTYPE html>
<html lang="ja-jp">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('images/poste/favicon.ico') }}">

    <title>{{ isset($pageTitle) ? $pageTitle : '' }} | Admin Dashboard</title>

    {{-- Bootstrap 4.0.1 CSS --}}
    <link rel="stylesheet" href="{{ asset('vendors/bootstrap/css/bootstrap.min.css') }}">
    {{-- FontAwesome 5.3.1 --}}
    <link rel="stylesheet" href="{{ asset('vendors/fontawesome/css/all.min.css') }}">
    {{-- DataTable CSS 1.10.19 --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendors/datatables/datatables.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('vendors/datatables/plugins/css/dataTables.bootstrap4.min.css') }}">
    {{-- Animate CSS --}}
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    {{-- Select 2 --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/select2/css/select2.min.css') }}">
    {{-- Bootstrap4 Dialog --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-dialog/css/bootstrap-dialog.min.css') }}">
    {{-- Bootstrap4 Datetimepicker --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/bootstrap4-datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    {{-- Style --}}
    <link rel="stylesheet" href="{{ asset('_admin/css/main.css') }}">

    {!! isset($stylesheets) ? $stylesheets : '' !!}

    @yield('stylesheets')
</head>
<body class="bg-light">

    <div class="container-fluid">
        <div class="row">
            {{-- Sidebar --}}
            <div class="col-12 col-sm-3 col-md-2 bg-dark" id="sidebar">
                @include('admin.includes.sidebar')
            </div>
            {{-- End Sidebar --}}
            <div class="col-12 col-sm-9 col-md-10">
                {{-- Top Bar --}}
                <div class="row d-none d-sm-flex">
                    <div class="col-12 justify-content-between flex-row d-flex p-0" id="topbar">
                        @include('admin.includes.topbar')
                    </div>
                </div>
                {{-- End Top Bar --}}

                {{-- Content --}}
                <div class="row">
                    <div class="col-12">
                        @yield('content')
                    </div>
                </div>
                {{-- End Content --}}
            </div>
        </div>
    </div>

    @include('auth.logout-form')

    {{-- Jquery --}}
    <script type="text/javascript" src="{{ asset('vendors/jquery/jquery-3.3.1.min.js') }}"></script>
    {{-- Popperjs for BS4 --}}
    <script src="{{ asset('js/popper.min.js') }}"></script>
    {{-- BS4 --}}
    <script src="{{ asset('vendors/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- FontAwesome 5.3.1 --}}
    <script src="{{ asset('vendors/fontawesome/js/all.min.js') }}"></script>
    {{-- DataTables --}}
    <script src="{{ asset('vendors/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/plugins/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables/plugins/js/dataTables.bootstrap4.min.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('vendors/select2/js/select2.min.js') }}"></script>
    {{-- Bootstrap4 Dialog --}}
    <script src="{{ asset('vendors/bootstrap4-dialog/js/bootstrap-dialog.min.js') }}"></script>
    {{-- MomentJs --}}
    <script src="{{ asset('js/moment.min.js') }}"></script>
    {{-- Bootstrap4 Datetimepicker --}}
    <script src="{{ asset('vendors/bootstrap4-datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
    {{-- CKEditor --}}
    <script src="{{ asset('vendors/ckeditor4/ckeditor.js') }}"></script>

    <script>var base_url = "{{ URL::to('/') }}"</script>
    <script src="{{ asset('_admin/js/main.js') }}"></script>

    {!! isset($scripts) ? $scripts : '' !!}

    @yield('scripts')
</body>
</html>
