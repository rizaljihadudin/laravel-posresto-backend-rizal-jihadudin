@extends('layouts.app')

@section('title', 'Add User')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            border-radius: 5px;
            z-index: 1000;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></div>
                    <div class="breadcrumb-item">Add New Users</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Form Input Users</h4>
                        </div>
                        <div class="card-body col-md-8 offset-2">
                            <div class="form-group">
                                <label>Name <font color="red">*</font></label>
                                <input type="text"
                                    class="form-control @error('name')
                                is-invalid
                            @enderror"
                                    name="name">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email <font color="red">*</font></label>
                                <input type="email"
                                    class="form-control @error('email')
                                is-invalid
                            @enderror"
                                    name="email" value="">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password <font color="red">*</font></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                        class="form-control @error('password')
                                is-invalid
                            @enderror"
                                        name="password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Role <font color="red">*</font></label>
                                <div class="selectgroup w-100">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="customRadioInline1" name="role"
                                            class="custom-control-input" value="admin">
                                        <label class="custom-control-label" for="customRadioInline1">Admin</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline ml-2">
                                        <input type="radio" id="customRadioInline2" name="role"
                                            class="custom-control-input" value="staff">
                                        <label class="custom-control-label" for="customRadioInline2">Staff</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline ml-2">
                                        <input type="radio" id="customRadioInline3" name="role"
                                            class="custom-control-input" value="user">
                                        <label class="custom-control-label" for="customRadioInline3">User</label>
                                    </div>
                                </div>
                                @error('role')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Cancel</a>
                            <button class="btn btn-success" id="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-overlay" id="loading-overlay">
                <img src="{{ asset('gif/cat2.gif') }}" alt="" width="100" height="100">
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#loading-overlay').hide();

            //submit btn
            $('#submitBtn').on('click', function (e) {
                $('#loading-overlay').css('display', 'block');
                setTimeout(function () {
                    $('#loading-overlay').hide();
                    $('#formUsers').submit();
                }, 4000);
            });
        });
    </script>
@endpush
