@extends('admin.layouts.app')
@section('page_title',__('Subscriber List'))
@section('content')
    <div class="content container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">@lang('Plans')</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-no-gutter">
                            <li class="breadcrumb-item">
                                <a class="breadcrumb-link" href="{{ route('admin.dashboard') }}">
                                    @lang('Dashboard')
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">@lang('Manage Plan')</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-4 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Total Subscriber")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $totalSubscriber }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $totalSubscriber }}</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("This Month Subscriber")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $thisMonthSubscriber }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $totalSubscriber }}</span>
                            </div>
                            <div class="col-auto">
                                @if($thisMonthSubscriberGrowth > 0)
                                    <span class="badge bg-soft-success text-success p-1">
                                        <i class="bi-graph-up"></i> {{ number_format($thisMonthSubscriberGrowth , 2) }}%
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger p-1">
                                        <i class="bi-graph-down"></i> {{ number_format($thisMonthSubscriberGrowth , 2) }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 mb-3 mb-lg-5">
                <div class="card h-100">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-2">@lang("Current Year Subscriber")</h6>
                        <div class="row align-items-center gx-2">
                            <div class="col">
                                <span class="js-counter display-4 text-dark">{{ $thisYearSubscriber ?? 0 }}</span>
                                <span class="text-body fs-5 ms-1">@lang("From") {{ $totalSubscriber ?? 0 }}</span>
                            </div>
                            <div class="col-auto">
                                @if($growthPercentageYear > 0)
                                    <span class="badge bg-soft-success text-success p-1">
                                        <i class="bi-graph-up"></i> {{ number_format($growthPercentageYear , 2) }}%
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger p-1">
                                        <i class="bi-graph-down"></i> {{ number_format($growthPercentageYear , 2) }}%
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-header card-header-content-md-between">
                    <div class="mb-2 mb-md-0">
                        <div class="input-group input-group-merge input-group-flush">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi-search"></i>
                            </div>
                            <input id="datatableSearch" type="search" class="form-control" placeholder="@lang('Search Subscribers')"
                                   aria-label="@lang('Search Subscribers')" autocomplete="off">
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
                                   data-bs-target="#subscriberDeleteMultipleModal">
                                    <i class="bi-trash"></i> @lang('Delete')
                                </a>
                            </div>
                        </div>

                        <div class="dropdown">
                            <a href="{{route('admin.send.subscriber.email')}}" class="btn btn-sm btn-primary mr-2">
                                <span><i class="fa fa-envelope"></i> @lang('Send Mail')</span>
                            </a>
                        </div>
                    </div>
                </div>


                <div class=" table-responsive datatable-custom  ">
                    <table id="datatable"
                           class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                           data-hs-datatables-options='{
                           "columnDefs": [{
                              "targets": [0, 3],
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
                            <th>@lang('Email')</th>
                            <th>@lang('Subscribed At')</th>
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
                                    <select id="datatableEntries"
                                            class="js-select form-select form-select-borderless w-auto" autocomplete="off"
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
        <div class="modal fade" id="subscriberDeleteMultipleModal" tabindex="-1" role="dialog" aria-labelledby="subscriberDeleteMultipleModalLabel" data-bs-backdrop="static"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="subscriberDeleteMultipleModalLabel"><i
                                class="fa-light fa-square-check"></i> @lang('Confirmation')</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <div class="modal-body">
                            @lang('Do you want to delete all selected property?')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn-primary delete-multiple">@lang('Confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" data-bs-backdrop="static"
             aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="deleteModalLabel"><i
                                class="fa-sharp fa-light fa-square-check"></i> @lang('Confirmation')</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteForm" action="" method="get" >
                        @csrf
                        @method('get')
                        <div class="modal-body">
                            @lang('Do you want to delete subscriber?')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">@lang('Close')</button>
                            <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection


        @push('css-lib')
            <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
        @endpush


        @push('js-lib')
            <script src="{{ asset('assets/admin/js/hs-file-attach.min.js') }}"></script>
            <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
            <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
            <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
            <script src="{{ asset('assets/admin/js/appear.min.js') }}"></script>
            <script src="{{ asset("assets/admin/js/hs-counter.min.js") }}"></script>
        @endpush


        @push('script')
            <script>
                $('#deleteModal').on('show.bs.modal', function (event) {
                    let button = $(event.relatedTarget);
                    let route = button.data('route');
                    let form = $(this).find('form#deleteForm');
                    form.attr('action', route);
                });

                $(document).on('ready', function () {
                    new HSCounter('.js-counter')
                    new HSFileAttach('.js-file-attach')
                    HSCore.components.HSTomSelect.init('.js-select', {
                        maxOptions: 250,
                    })

                    HSCore.components.HSDatatables.init($('#datatable'), {
                        processing: true,
                        serverSide: true,

                        ajax: {
                            url: "{{ route("admin.subscriber.search.list") }}",

                        },
                        columns: [
                            {data: 'checkbox', name: 'checkbox'},
                            {data: 'email', name: 'email'},
                            {data: 'subscribed_at', name: 'subscribed_at'},
                            {data: 'action', name: 'action'},
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

                    $.fn.dataTable.ext.errMode = 'throw';


                    $(document).on('click', '#datatableCheckAll', function () {
                        $('input:checkbox').not(this).prop('checked', this.checked);
                    });

                    $(document).on('change', ".row-tic", function () {
                        let length = $(".row-tic").length;
                        let checkedLength = $(".row-tic:checked").length;
                        if (length == checkedLength) {
                            $('#check-all').prop('checked', true);
                        } else {
                            $('#check-all').prop('checked', false);
                        }
                    });

                    $(document).on('click', '.delete-multiple', function (e) {
                        e.preventDefault();
                        let all_value = [];
                        $(".row-tic:checked").each(function () {
                            all_value.push($(this).attr('data-id'));
                        });
                        let strIds = all_value;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ route('admin.subscriber.delete.multiple') }}",
                            data: {strIds: strIds},
                            datatType: 'json',
                            type: "post",
                            success: function (data) {
                                location.reload();
                            },
                        });
                    });


                });

            </script>

    @endpush




