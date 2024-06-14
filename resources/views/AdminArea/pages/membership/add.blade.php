@extends('AdminArea.layouts.app')

@section('content')
<div class="content">
    <div class="row align-items-center p-0 m-0">
        <div class="col-md-6 p-0 m-0">
            <div class="breadcrumb-wrapper">
                <h1>Membership Plan</h1>
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
            <div class="breadcrumb-wrapper">
                <a href="{{url('admin/all-plan')}}" class="btn btn-primary">
                    <span class="fa fa-plus-circle"></span> All Plan
                </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-body">
                    <form action="{{url('admin/add-plan')}}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ isset($membership) ? $membership->id : '' }}">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="plan_name">Plan Name</label>
                                    <input type="text" class="form-control" name="plan_name" id="plan_name" placeholder="Enter Plan Name" required value="{{ isset($membership) ? $membership->plan_name : old('plan_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="monthly_price">Monthly Price</label>
                                    <input type="text" class="form-control" name="monthly_price" id="monthly_price" placeholder="Enter Plan Monthly Price" oninput="validateInput(this)" required value="{{ isset($membership) ? $membership->monthly_price : old('monthly_price') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="yearly_price">Yearly Price</label>
                                    <input type="text" class="form-control" name="yearly_price" id="yearly_price" placeholder="Enter Plan Yearly Price" oninput="validateInput(this)" required value="{{ isset($membership) ? $membership->yearly_price : old('yearly_price') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="description">Plan Description</label>
                                    <textarea class="form-control" name="plan_description" id="description" required>{{ isset($membership) ? $membership->plan_description : old('plan_description') }}</textarea>
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
