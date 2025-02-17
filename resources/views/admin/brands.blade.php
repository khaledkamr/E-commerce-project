@extends("layouts.admin")
@section("content")
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Brands</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Brands</div>
                </li>
            </ul>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-between gap10 flex-wrap">
                <div class="wg-filter flex-grow">
                    <form class="form-search">
                        <fieldset class="name">
                            <input type="text" placeholder="Search here..." class="" name="name"
                                tabindex="2" value="" aria-required="true" required="">
                        </fieldset>
                        <div class="button-submit">
                            <button class="" type="submit"><i class="icon-search"></i></button>
                        </div>
                    </form>
                </div>
                <a class="tf-button style-1 w208" href="{{route('admin.brand.add')}}"><i
                        class="icon-plus"></i>Add new</a>
            </div>
            <div class="wg-table table-all-user">
                <div class="table-responsive">
                    @if (Session::has('success'))
                        <p class="alert alert-success">{{session::get('success')}}</p>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="col-id">#</th>
                                <th class="col-logo">Logo</th>
                                <th class="col-name">Name</th>
                                <th class="col-slug">Slug</th>
                                <th class="col-products">Products</th>
                                <th class="col-action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($brands as $brand)
                                <tr>
                                    <td class="col-id">{{$brand->id}}</td>
                                    <td class=col-logo>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <img width="60px" src="{{asset("storage/$brand->image")}}" alt="{{$brand->name}}">
                                        </div>
                                    </td>
                                    <td class="col-name fw-bold">{{$brand->name}}</td>
                                    <td class="col-slug">{{$brand->slug}}</td>
                                    <td class="col-products"><a href="#" target="_blank">{{$brand->products_count}}</a></td>
                                    <td class="col-action">
                                        <div class="list-icon-function">
                                            <a href="{{route('admin.brand.edit', $brand->id)}}">
                                                <div class="item edit ps-5">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{route("admin.brand.delete", $brand->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="item text-danger delete border-0" type="submit">
                                                    <i class="icon-trash-2"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="divider mb-5"></div>
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$brands->links('pagination::bootstrap-5')}}
            </div>
        </div>
    </div>
</div>

<style>
    /* Ensure the table layout is fixed */
    .wg-table table {
        width: 100%;
        table-layout: fixed; /* Prevents misalignment of table header and body */
        border-collapse: collapse;
    }

    /* Define column widths */
    .col-id {
        width: 10%;
        text-align: center;
    }
    .col-logo {
        width: 10%;
        text-align: center;
    }
    .col-name {
        width: 30%;
        text-align: center;
    }
    .col-slug {
        width: 25%;
    }
    .col-products {
        width: 15%;
        text-align: center;
    }
    .col-action {
        width: 10%;
        text-align: center;
    }

    /* Ensure headers and table data cells align */
    .wg-table th, .wg-table td {
        padding: 10px;
        vertical-align: middle;
        text-align: center;
    }

    /* Fix for Name column to align image and text properly */
    .col-name .pname {
        display: flex;
        align-items: center;
        gap: 10px;
        justify-content: start;
    }

    .col-name .pname img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }

    .col-name .name {
        flex-grow: 1;
        text-align: left;
    }
</style>

@endsection

@push('scripts')
    <script>
        $(function() {
            $('.delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record",
                    type: "warning",
                    buttons: ["no", "yes"],
                    confirmButtonColor: "#dc3545"
                }).then(function(result) {
                    if(result) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush