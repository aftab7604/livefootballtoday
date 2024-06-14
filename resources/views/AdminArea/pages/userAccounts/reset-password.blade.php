@extends('AdminArea.layouts.app')

@section('content')
<div class="content">
    <div class="row align-items-center p-0 m-0">
        <div class="col-md-6 p-0 m-0">
            <div class="breadcrumb-wrapper">
                <h1>User New Password</h1>
                {{--  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0">
                        <li class="breadcrumb-item">
                            <a href="https://football-today.co.uk/admin">
                                <i class="mdi mdi-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Category
                        </li>
                    </ol>
                </nav>  --}}
            </div>
        </div>
        <div class="col-md-6 text-right p-0 m-0">
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-body">  
                    <form action="{{url('admin/user-account/success-reset-password')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ isset($users) ? $users->id : '' }}">
                        <div class="row justify-content-center">
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input type="password" minlength="4" maxlength="16" class="form-control" name="password" id="password" placeholder="Enter User Password" required value="">
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" minlength="4" maxlength="16" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter User confirm_password" required value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-footer pt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-default">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{route('admin.article.image.upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form',
            height: 400
        });
    });

    function validateInput(input) {
        // Remove non-digit characters except dot
        input.value = input.value.replace(/[^\d.]/g, '');

        // Ensure that the dot appears only once
        var dotCount = (input.value.match(/\./g) || []).length;
        if (dotCount > 1) {
            input.value = input.value.substr(0, input.value.lastIndexOf('.'));
        }
    }

    function readImageURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#inp_image_pre').attr('src', e.target.result)
                // initCropper();
            };
            reader.readAsDataURL(input.files[0]);
        }
        $('.cropping-elements').removeClass('d-none');
    }

    function initCropper() {
        var $image = $('#inp_image_pre');
        $image.cropper('destroy');
        $image.cropper({
            aspectRatio: 6 / 4
        });
        var cropper = $image.data('cropper');
    }

    function destroye() {
        $currentCropper = $('#inp_image_pre').data('cropper');
        if ($currentCropper) {
            $currentCropper.destroy();
        }
    }

</script>
@endsection

@section('css')
<style>
    .custom-file-input {
        width: 100% !important;
        margin: 0 !important;
        opacity: 0 !important;
    }

</style>
@endsection
