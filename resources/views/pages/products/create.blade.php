@extends('layouts.app')

@section('title', 'Product Create')

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

        .custom-switches-stacked .custom-switch {
            display: inline-block;
            margin-right: 10px; /* Jarak antara radio button */
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add Product Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></div>
                    <div class="breadcrumb-item active">Product</div>
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h4>From Product</h4>
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
                                <label>Description <font color="red">*</font></label>
                                <input type="text"
                                    class="form-control @error('description')
                                is-invalid
                            @enderror"
                                    name="description">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Price <font color="red">*</font></label>
                                <input type="text" oninput="validateNumberInput(this)"
                                    class="form-control @error('price')
                                is-invalid
                            @enderror"
                                    name="price">
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Stock <font color="red">*</font></label>
                                <input type="text" oninput="validateNumberInput(this)"
                                    class="form-control @error('stock')
                                is-invalid
                            @enderror"
                                    name="stock">
                                @error('stock')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Category <font color="red">*</font></label>
                                <select class="form-control selectric @error('category_id') is-invalid @enderror"
                                    name="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Photo Product <font color="red">*</font></label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input  @error('image') is-invalid @enderror"
                                        name="image" id="customFile" onchange="previewImage(this)" accept=".jpg, .jpeg, .png">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                <div id="imagePreview" class="mt-2"></div>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Status <font color="red">*</font></label>
                                <div class="row">
                                    <label class="custom-switch">
                                        <input type="radio" name="status" value="1" class="custom-switch-input" checked>
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Active</span>
                                    </label>
                                    <label class="custom-switch">
                                        <input type="radio" name="status" value="2" class="custom-switch-input">
                                        <span class="custom-switch-indicator"></span>
                                        <span class="custom-switch-description">Inactive</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Is Favorite <font color="red">*</font></label>
                                <div class="selectgroup selectgroup-pills">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="is_favorite" value="1" class="selectgroup-input"
                                            checked="">
                                        <span class="selectgroup-button">Yes</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="is_favorite" value="0" class="selectgroup-input">
                                        <span class="selectgroup-button">No</span>
                                    </label>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Cancel</a>
                            <button class="btn btn-success" id="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card-overlay" id="loading-overlay">
                    <img src="{{ asset('gif/cat2.gif') }}" alt="" width="100" height="100">
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#loading-overlay').hide();

            //submit btn
            $('#submitBtn').on('click', function(e) {
                $('#loading-overlay').css('display', 'block');
                setTimeout(function() {
                    $('#loading-overlay').hide();
                    $('#formUsers').submit();
                }, 4000);
            });
        });

        function previewImage(input) {
            var fileInput = input;
            var preview = document.getElementById('imagePreview');

            while (preview.firstChild) {
                preview.removeChild(preview.firstChild);
            }

            var files = fileInput.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var imageType = /image.*/;

                if (!file.type.match(imageType)) {
                    continue;
                }

                var img = document.createElement("img");
                img.classList.add("img-thumbnail");
                img.file = file;
                img.setAttribute("height", "150");
                img.setAttribute("width", "150");
                preview.appendChild(img);

                var reader = new FileReader();
                reader.onload = (function (aImg) {
                    return function (e) {
                        aImg.src = e.target.result;
                    };
                })(img);
                reader.readAsDataURL(file);
            }
        }

        function validateNumberInput(input) {
            // Hapus karakter selain angka
            input.value = input.value.replace(/[^0-9]/g, '');
        }
    </script>
@endpush
