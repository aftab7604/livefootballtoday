@extends('AdminArea.layouts.app')

@section('content')
<div class="content">
    <div class="row align-items-center p-0 m-0">
        <div class="col-md-6 p-0 m-0">
            <div class="breadcrumb-wrapper">
                <h1>Edit Article</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}">
                                <i class="mdi mdi-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.article.all')}}">
                                Article
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            Edit Article
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-default">
                <div class="card-body">
                    <form action="{{route('admin.article.update', $article->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        placeholder="Enter Title" value="{{$article->title}}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Category</label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}"
                                            {{$article->category_id == $category->id ? 'selected':''}}>
                                            {{$category->title}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="input-group">
                                    <label for="custom-file-input" class="w-100">Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" accept="image/*" id="image1"
                                            name="image1" onchange="readImageURL(this);">
                                        <label class="custom-file-label" for="image1">Choose Article Image</label>
                                    </div>
                                </div>
                                <div class="col-md-8 cropping-elements text-center">
                                    <h6 class="text-center">Original Image</h6>
                                    <hr>
                                    <div class="image_container">
                                        <img id="inp_image_pre"
                                            src="{{$article->image?asset('uploads/'.$article->image):''}}"
                                            style="width:100%" alt="your image" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                        <label for="artical_status">Artical Status</label>
                                        <select name="artical_status" class="form-control artical_status" id="artical_status">
                                            <option value="paid" {{ $article->artical_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="free" {{ $article->artical_status === 'free' ? 'selected' : '' }}>Free</option>
                                        </select>                                        
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description"
                                        required>{{$article->description}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="control control-checkbox">
                                    Publish
                                    <input type="checkbox" name="published" {{$article->status ? 'checked' : ''}}>
                                    <div class="control-indicator"></div>
                                </label>
                            </div>
                            <div class="col-md-12">
                                <label class="control control-checkbox">
                                    Add to Recommended list
                                    <input type="checkbox" name="recommended"
                                        {{$article->recommended ? 'checked' : ''}}>
                                    <div class="control-indicator"></div>
                                </label>
                            </div>
                        </div>
                        <div class="form-footer pt-4 text-center">
                            <button type="submit" class="btn btn-primary btn-default">Update</button>
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

    function readImageURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#inp_image_pre').attr('src', e.target.result)
                // initCropper();
            };
            reader.readAsDataURL(input.files[0]);
        }
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

    .ck-editor__editable_inline {
        min-height: 400px;
    }

</style>
@endsection
