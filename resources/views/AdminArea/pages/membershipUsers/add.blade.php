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
                <a href="{{url('admin/membership/all')}}" class="btn btn-primary">
                    <span class="fa fa-plus-circle"></span> All Memberships
                </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-body">
                    <form action="{{url('admin/membership/store')}}" method="POST">
                        @csrf
                        {{--  <input type="hidden" name="id" value="{{ isset($membership) ? $membership->id : '' }}">  --}}
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="plan_name">Seslect User</label>
                                    <select name="user_id" class="form-control">
                                        <option value="" disabled selected>Select a user</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->first_name }} {{ $user->last_name }}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="card_name">Card Name (optional)</label>
                                    <input type="text" class="form-control" name="card_name" id="card_name" placeholder="Enter Card Name" value="{{old('card_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="yearly_price">Select a Plan Package</label>
                                    <select name="plan_package" class="form-control">
                                        <option value="" disabled selected>Select a Plan Package</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="yearly">Yearly</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="free_membership">Are you sure giving free membership to this user?</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="yes" name="free_membership" value="1" checked>
                                        <label class="form-check-label" for="yes">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="no" name="free_membership" value="0">
                                        <label class="form-check-label" for="no">No</label>
                                    </div>
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

    .form-check {
        position: relative;
        display: block;
        padding-left: 1.25rem;
        width: max-content;
        float: left;
        margin-right: 30px;
      }

      label{
        width: 100%;
      }

</style>
@endsection
