@extends('AdminArea.layouts.app')

@section('content')
<div class="content">
    <div class="row align-items-center p-0 m-0">
        <div class="col-md-6 p-0 m-0">
            <div class="breadcrumb-wrapper">
                <h1>Stripe Account</h1>
                {{--  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0">
                        <li class="breadcrumb-item">
                            <a href="{{route('admin.index')}}">
                                <i class="mdi mdi-home"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            stripe
                        </li>
                    </ol>
                </nav>  --}}
            </div>
        </div>
        <div class="col-md-6 text-right p-0 m-0">
            <div class="breadcrumb-wrapper">
                <a href="{{url('admin/add-stripe')}}" class="btn btn-primary">
                    <span class="fa fa-plus-circle"></span> Add Account
                </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default" style="width:100%;overflow: auto";>
                <div class="card-body">
                    <div class="responsive-data-table">
                        <table id="responsive-data-table" class="table dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Secret Key</th>
                                    <th>Public Key</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($stripeAccounts as $key => $stripeAccount)
                                <tr>
                                    <td>
                                        {{$key+1}}
                                    </td>
                                    <td>
                                        {{$stripeAccount->secret_key}}
                                    </td>
                                    <td>
                                        {{$stripeAccount->public_key}}
                                    </td>
                                    <td>
                                        {{$stripeAccount->created_at}}
                                    </td>
                                    <td class="text-left">
                                        <div class="dropdown">
                                            <a class="btn btn-lg text-dark p-0" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical mdi-18px"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <a class="dropdown-item"
                                                    href="{{url('admin/edit-stripe', $stripeAccount->id)}}">
                                                    <i
                                                        class="mdi mdi-square-edit-outline text-info mdi-18px"></i>&nbsp;Edit
                                                </a>
                                                <div class="dropdown-divider responsive-moblile"></div>
                                                {{--  <a class="dropdown-item delete-data" data-id="{{$stripeAccount->id}}"
                                                    href="javascript:void(0)">
                                                    <i class="mdi mdi-delete text-danger mdi-18px"></i>&nbsp;Delete
                                                </a>  --}}
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#responsive-data-table').DataTable({
            language: {
                paginate: {
                    next: '<i class="mdi mdi-chevron-right"></i>',
                    previous: '<i class="mdi mdi-chevron-left"></i>'
                }
            },
            "dom": '<"row justify-content-between top-information"lf>rt<"row justify-content-between bottom-information"ip><"clear">'
        });
    });
    $(".delete-data").on('click', function () {
        var id = $(this).attr('data-id');
        $.confirm({
            title: 'Are you sure?',
            content: 'This will delete this Stripe Account permanently',
            buttons: {
                confirm: {
                    btnClass: 'btn-blue',
                    action: function () {
                        window.location.href = '{{ url("admin/delete-stripe") }}/' + id;
                    }
                },
                cancel: {
                    action: function () {}
                }
            }
        });

    });

</script>
@endsection
