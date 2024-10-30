@extends('admin.layouts.app')
@section('page_title', __('Packages'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item"><a class="breadcrumb-link"
                                    href="javascript:void(0);">@lang('Dashboard')</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Packages')</li>
                        </ol>
                    </nav>
                    <h1 class="page-header-title">@lang('Package List')</h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang('Active Packages')</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $totalActivePackage }}</span>
                                <span class="text-body fs-5 ms-1">{{ 'from ' . $totalPackage }}</span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-soft-success text-success p-1">
                                    <i class="bi-graph-up"></i> {{ number_format($totalActivePercentage, 2) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang('Inactive Package')</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $totalInactivePackage }}</span>
                                <span class="text-body fs-5 ms-1">{{ 'from ' . $totalPackage }}</span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-soft-info text-info p-1">
                                    <i class="bi-graph-down"></i> {{ number_format($totalInactivePercentage, 2) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Today's Created Package")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $totalCreatedToday }}</span>
                                <span class="text-body fs-5 ms-1">{{ 'from ' . $totalPackage }}</span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-soft-success text-success p-1">
                                    <i class="bi-graph-up"></i> {{ number_format($totalTotalCreatedTodayPercentage) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Today's Created Package")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $totalCreatedThisMonth }}</span>
                                <span class="text-body fs-5 ms-1">{{ 'from ' . $totalPackage }}</span>
                            </div>
                            <div class="col-auto">
                                <span class="badge bg-soft-success text-success p-1">
                                    <i class="bi-graph-up"></i> {{ number_format($totalTotalCreatedThisMonthPercentage) }}%
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header card-header-content-md-between">
                <div class="mb-2 mb-md-0">
                    <div class="input-group input-group-merge input-group-flush">
                        <div class="input-group-prepend input-group-text">
                            <i class="bi-search"></i>
                        </div>
                        <input id="datatableSearch" type="search" class="form-control" placeholder="@lang('Search Packages')"
                            aria-label="@lang('Search Packages')" autocomplete="off">
                    </div>
                </div>

                <div class="d-grid d-sm-flex justify-content-md-end align-items-sm-center gap-2">
                    <div id="datatableCounterInfo">
                        <div class="d-flex align-items-center">
                            <span class="fs-5 me-3">
                                <span id="datatableCounter">0</span>
                                @lang('Selected')
                            </span>
                            <a class="btn btn-outline-danger btn-sm" href="javascript:void(0)" data-bs-toggle="modal"
                                data-bs-target="#DeleteMultipleModal">
                                <i class="bi-trash"></i> @lang('Delete')
                            </a>
                        </div>
                    </div>
                    <div id="datatableCounterInfo2" class="d-none">
                        <div class="d-flex align-items-center">
                            <a class="btn btn-outline-primary btn-sm inactiveButton" id="inactiveButton"
                                href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#inactiveMultipleModal">
                                <i class="fal fa-gauge me-2"></i>@lang('Status Change')
                            </a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <button type="button" class="btn btn-white btn-sm w-100" id="dropdownMenuClickable"
                            data-bs-auto-close="false" id="usersFilterDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bi-filter me-1"></i> @lang('Filter')
                        </button>
                        <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered filter_dropdown"
                            aria-labelledby="dropdownMenuClickable">
                            <div class="card">
                                <div class="card-header card-header-content-between">
                                    <h5 class="card-header-title">@lang('Filter Packages')</h5>
                                    <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2"
                                        id="filter_close_btn">
                                        <i class="bi-x-lg"></i>
                                    </button>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 mb-4">
                                            <span class="text-cap text-body">@lang('Package')</span>
                                            <input type="text" class="form-control" id="name"
                                                autocomplete="off">
                                        </div>

                                        <div class="col-sm mb-4">
                                            <small class="text-cap text-body">@lang('Status')</small>
                                            <div class="tom-select-custom">
                                                <select class="js-select js-datatable-filter form-select form-select-sm"
                                                    id="filter_status" data-target-column-index="4"
                                                    data-hs-tom-select-options='{
                                                              "placeholder": "Any status",
                                                              "searchInDropdown": false,
                                                              "hideSearch": true,
                                                              "dropdownWidth": "10rem"
                                                            }'>
                                                    <option value="all"
                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-secondary"></span>All Status</span>'>
                                                        @lang('All Status')
                                                    </option>
                                                    <option value="0"
                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-warning"></span>Inactive</span>'>
                                                        @lang('Inactive')
                                                    </option>
                                                    <option value="1"
                                                        data-option-template='<span class="d-flex align-items-center"><span class="legend-indicator bg-success"></span>Active</span>'>
                                                        @lang('Active')
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-4">
                                            <label for="startDateLabel" class="form-label">@lang('Start Date')</label>
                                            <input class="form-control" id="startDateLabel" name="startDate"
                                                type="text" />
                                        </div>
                                        <div class="col-sm-12 mb-4">
                                            <label for="endDateLabel" class="form-label">@lang('End Date')</label>
                                            <input class="form-control" id="endDateLabel" name="endDate"
                                                type="text" />
                                        </div>


                                    </div>

                                    <div class="d-grid">
                                        <button type="button" id="filter_button"
                                            class="btn btn-primary">@lang('Apply')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-primary btn-sm" href="{{ route('admin.package.add') }}">
                        <i class="bi-plus-circle me-1"></i> @lang('Add New')
                    </a>
                </div>
            </div>


            <div class=" table-responsive datatable-custom  ">
                <table id="datatable"
                    class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                    data-hs-datatables-options='{
                       "columnDefs": [{
                          "targets": [0, 7],
                          "orderable": false
                        }],
                       "order": [],
                       "info": {
                         "totalQty": "#datatableWithPaginationInfoTotalQty"
                       },
                       "search": "#datatableSearch",
                       "entries": "#datatableEntries",
                       "pageLength": 15,
                       "isResponsive": false,
                       "isShowPaging": false,
                       "pagination": "datatablePagination"
                     }'>
                    <thead class="thead-light">
                        <tr>
                            <th class="table-column-pe-0">
                                <div class="form-check">
                                    <input class="form-check-input check-all tic-check" type="checkbox" name="check-all"
                                        id="datatableCheckAll">
                                    <label class="form-check-label" for="datatableCheckAll"></label>
                                </div>
                            </th>
                            <th>@lang('Package')</th>
                            @if (getAuthUser('admin'))
                                <th>@lang('Company')</th>
                            @endif
                            <th>@lang('Category')</th>
                            <th>@lang('Start Point')</th>
                            <th>@lang('End Point')</th>
                            <th>@lang('Destination')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Created at')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>


            <div class="card-footer">
                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <div class="d-flex justify-content-center justify-content-sm-start align-items-center">
                            <span class="me-2">@lang('Showing:')</span>
                            <div class="tom-select-custom">
                                <select id="datatableEntries" class="js-select form-select form-select-borderless w-auto"
                                    autocomplete="off"
                                    data-hs-tom-select-options='{
                                            "searchInDropdown": false,
                                            "hideSearch": true
                                          }'>
                                    <option value="10">10</option>
                                    <option value="15" selected>15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <span class="text-secondary me-2">of</span>
                            <span id="datatableWithPaginationInfoTotalQty"></span>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex  justify-content-center justify-content-sm-end">
                            <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="deleteModalLabel"><i class="bi bi-check2-square"></i> @lang('Confirmation')
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="setRoute">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p>@lang('Do you want to delete this Package')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="discountModalLabel"><i class="bi bi-check2-square"></i>
                        @lang('Confirmation')</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post" class="setdiscountRoute">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="row">
                            <div class="row">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="pt-1">
                                            <label class="form-label" for="discount_type">@lang('Discount Type')</label>
                                            <select class="form-control js-select" id="discount_type"
                                                name="discount_type">
                                                <option value="" disabled selected>@lang('Select Type')</option>
                                                <option value="0"
                                                    {{ old('discount_type') == '0' ? 'selected' : '' }}>@lang('Percentage')
                                                </option>
                                                <option value="1"
                                                    {{ old('discount_type') == '1' ? 'selected' : '' }}>@lang('Amount')
                                                </option>
                                            </select>
                                            @error('discount_type')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="pt-3">
                                            <label class="form-label">@lang('Discount Amount')</label>
                                            <input type="text" name="amount" class="form-control"
                                                value="{{ old('amount') }}" placeholder="e.g 50" />
                                            @error('amount')
                                                <span class="invalid-feedback d-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel"
        data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="statusModalLabel"><i class="bi bi-check2-square"></i> @lang('Confirmation')
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="get" class="setStatusRoute">
                    @method('get')
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to change the status of this item? This action cannot be undone and will affect the current status of the item.')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="DeleteMultipleModal" tabindex="-1" role="dialog"
        aria-labelledby="DeleteMultipleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="DeleteMultipleModalLabel"><i class="fa-light fa-square-check"></i>
                        @lang('Confirmation')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        @lang('Do you want to delete all selected data?')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary delete-multiple">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="inactiveMultipleModal" tabindex="-1" role="dialog"
        aria-labelledby="inactiveMultipleModalLabel" data-bs-backdrop="static" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="inactiveMultipleModalLabel"><i class="fa-light fa-square-check"></i>
                        @lang('Confirmation')</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" class="setInactiveRoute" method="post">
                    @csrf
                    <div class="modal-body">
                        @lang('Do you want to inactive all selected data?')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary inactive-multiple">@lang('Confirm')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/flatpickr.min.css') }}">
@endpush


@push('js-lib')
    <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/appear.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hs-counter.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/flatpickr.js') }}"></script>
@endpush


@push('script')
    <script>
        flatpickr('#startDateLabel', {
            enableTime: false,
            dateFormat: "Y-m-d",
        });
        flatpickr('#endDateLabel', {
            enableTime: false,
            dateFormat: "Y-m-d",
        });
        $(document).on('click', '.deleteBtn', function() {
            let route = $(this).data('route');
            $('.setRoute').attr('action', route);
        })
        $(document).on('click', '.statusBtn', function() {
            let route = $(this).data('route');
            $('.setStatusRoute').attr('action', route);
        })
        $(document).on('click', '.discountBtn', function() {
            let route = $(this).data('route');
            let type = $(this).data('discount_type');
            let amount = $(this).data('discount_amount');

            $('.setdiscountRoute').attr('action', route);
            $('#discount_type').val(type);
            $('input[name="amount"]').val(amount);
        });
        $(document).on('ready', function() {
            new HSCounter('.js-counter')
            new HSFileAttach('.js-file-attach')
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250,
                placeholder: 'Select Type'

            })

            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('admin.all.package.search', ['destination' => $destination, 'category' => $category]) }}",
                },
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox'
                    },
                    {
                        data: 'package',
                        name: 'package'
                    },
                    @if(getAuthUser('admin'))
                    {
                        data: 'company',
                        name: 'company'
                    },
                    @endif
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'start_point',
                        name: 'start_point'
                    },
                    {
                        data: 'end_point',
                        name: 'end_point'
                    },
                    {
                        data: 'destination',
                        name: 'destination'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'create-at',
                        name: 'created-at'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    classMap: {
                        checkAll: '#datatableCheckAll',
                        counter: '#datatableCounter',
                        counterInfo: '#datatableCounterInfo'
                    }
                },
                language: {
                    zeroRecords: `<div class="text-center p-4">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`,
                    processing: `<div><div></div><div></div><div></div><div></div></div>`
                },
            })
            $('#datatable').on('select.dt deselect.dt', function() {
                var selectedRows = $('#datatable').DataTable().rows({
                    selected: true
                }).count();

                if (selectedRows > 0) {
                    $('#datatableCounterInfo').removeClass('d-none');
                    $('#datatableCounterInfo2').removeClass('d-none');
                } else {
                    $('#datatableCounterInfo').addClass('d-none');
                    $('#datatableCounterInfo2').addClass('d-none');
                }
            });

            $(document).on('click', '#filter_button', function() {

                let filterName = $('#name').val();
                let startDate = $('#startDateLabel').val();
                let endDate = $('#endDateLabel').val();
                let filterStatus = $('#filter_status').val();


                const datatable = HSCore.components.HSDatatables.getItem(0);

                datatable.ajax.url("{{ route('admin.all.package.search') }}" +
                    "?filterName=" + encodeURIComponent(filterName) +
                    "&startDate=" + encodeURIComponent(startDate) +
                    "&endDate=" + encodeURIComponent(endDate) +
                    "&filterStatus=" + encodeURIComponent(filterStatus)).load();
            });

            $.fn.dataTable.ext.errMode = 'throw';


            $(document).on('click', '#datatableCheckAll', function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            $(document).on('change', ".row-tic", function() {
                let length = $(".row-tic").length;
                let checkedLength = $(".row-tic:checked").length;
                if (length == checkedLength) {
                    $('#check-all').prop('checked', true);
                } else {
                    $('#check-all').prop('checked', false);
                }
            });

            $(document).on('click', '.delete-multiple', function(e) {
                e.preventDefault();
                let all_value = [];
                $(".row-tic:checked").each(function() {
                    all_value.push($(this).attr('data-id'));
                });
                let strIds = all_value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.package.delete.multiple') }}",
                    data: {
                        strIds: strIds
                    },
                    datatType: 'json',
                    type: "post",
                    success: function(data) {
                        location.reload();
                    },
                });
            });
            $(document).on('click', '.inactive-multiple', function(e) {
                e.preventDefault();
                let all_value = [];
                $(".row-tic:checked").each(function() {
                    all_value.push($(this).attr('data-id'));
                });
                let strIds = all_value;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('admin.package.inactiveMultiple') }}",
                    data: {
                        strIds: strIds
                    },
                    datatType: 'json',
                    type: "post",
                    success: function(data) {
                        location.reload();
                    },
                });
            });
        });
    </script>
@endpush
