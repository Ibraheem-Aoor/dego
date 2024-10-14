@extends('admin.layouts.app')
@section('page_title', __('Blog Category'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="javascript:void(0)">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Manage Blog')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Blogs')</h1>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">@lang('Blogs')</h4>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary btn-sm"><i class="bi-plus-circle me-1"></i>@lang('Add Blogs')</a>
            </div>

            <div class="table-responsive">
                <table class="table table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Title')</th>
                        <th>@lang('Status')</th>
                        <th class="text-center">
                            @foreach($allLanguage as $language)
                                <img class="avatar avatar-xss avatar-square me-2"
                                     src="{{ getFile($language->flag_driver, $language->flag) }}"
                                     alt="{{ $language->name }} Flag">
                            @endforeach
                        </th>
                        <th>@lang('Action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($blogs as $key => $blog)
                        <tr>
                            <td>{{ $loop->index + 1  }}</td>
                            <td>
                                @lang(optional($blog->details)->title)
                            </td>
                            <td>
                                @if ($blog->blog_status == 0)
                                    <span class="badge bg-soft-warning text-warning">
                                        <span class="legend-indicator bg-warning"></span> @lang('Inactive')
                                    </span>

                                @elseif ($blog->blog_status == 1)
                                    <span class="badge bg-soft-success text-success">
                                        <span class="legend-indicator bg-success"></span> @lang('Active')
                                    </span>

                                @endif
                            </td>
                            <td class="text-center">
                                @foreach($allLanguage as $language)
                                    <a href="{{ route('admin.blog.edit', [$blog->id, $language->id]) }}"
                                       class="btn btn-white btn-icon btn-sm flag-btn"
                                       target="_blank">
                                        <i class="bi {{ $blog->getLanguageEditClass($blog->id, $language->id) }}"></i>
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-white btn-sm" href="{{ route('admin.blog.edit', [$blog->id, $defaultLanguage->id]) }}">
                                        <i class="bi-pencil-fill me-1"></i> Edit
                                    </a>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white btn-icon btn-sm dropdown-toggle dropdown-toggle-empty" id="productsEditDropdown1" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                        <div class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="productsEditDropdown1">
                                            <a class="dropdown-item statusBtn text-dark"
                                                 href="javascript:void(0)"
                                                 data-route="{{ route("admin.blog.status", $blog->id) }}"
                                                 data-bs-toggle="modal" data-bs-target="#statusModal">
                                                <i class="bi-check-circle dropdown-item-icon text-dark"></i> @lang("Status")
                                            </a>

                                            <a class="dropdown-item"
                                               href="{{ route("admin.blog.seo", $blog->id) }}">
                                                <i class="fa-light fa-magnifying-glass dropdown-item-icon"></i>
                                                @lang("SEO")
                                            </a>
                                            <a class="dropdown-item deleteBtn text-danger"
                                               href="javascript:void(0)"
                                               data-route="{{ route("admin.blogs.destroy", $blog->id) }}"
                                               data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <i class="bi-trash dropdown-item-icon text-danger"></i> @lang("Delete")
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="odd"><td valign="top" colspan="8" class="dataTables_empty"><div class="text-center p-4">
                                    <img class="mb-3 dataTables-image" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                                    <img class="mb-3 dataTables-image" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                                    <p class="mb-0">@lang("No data to show")</p>
                                </div></td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
         data-bs-backdrop="static"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel"><i
                            class="bi bi-check2-square"></i> @lang("Confirmation")</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="setRoute">
                    @csrf
                    @method("delete")
                    <div class="modal-body">
                        <p>@lang("Do you want to delete this category")</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Delete Modal -->
    @include('admin.partials.model')


@endsection




@push('script')
    <script>
        "use script";
        $(document).ready(function () {
            $('.deleteBtn').on('click', function () {
                let route = $(this).data('route');
                $('.setRoute').attr('action', route);
            })
        })
    </script>
@endpush


