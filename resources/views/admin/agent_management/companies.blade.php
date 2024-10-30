@extends('admin.layouts.app')
@section('page_title', __('View Profile'))
@section('content')
    <div class="content container-fluid">
        <div class="row justify-content-lg-center">
            <div class="col-lg-10">
                @include('admin.agent_management.components.header_user_profile')
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header card-header-content-md-between">
                                <div class="mb-2 mb-md-0">
                                    <div class="input-group input-group-merge navbar-input-group">
                                        <div class="input-group-prepend input-group-text">
                                            <i class="bi-search"></i>
                                        </div>
                                        <input type="search" id="datatableSearch"
                                            class="search form-control form-control-sm" placeholder="@lang('Search transaction')"
                                            aria-label="@lang('Search transaction')" autocomplete="off">
                                    </div>
                                </div>


                            </div>

                            <div class=" table-responsive datatable-custom  ">
                                <table id="datatable"
                                    class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                                    data-hs-datatables-options='{
                                       "columnDefs": [{
                                          "targets": [0, 4],
                                          "orderable": false
                                        }],
                                       "order": [],
                                       "info": {
                                         "totalQty": "#datatableWithPaginationInfoTotalQty"
                                       },
                                       "search": "#datatableSearch",
                                       "entries": "#datatableEntries",
                                       "pageLength": 10,
                                       "isResponsive": false,
                                       "isShowPaging": false,
                                       "pagination": "datatablePagination"
                                     }'>
                                    <thead class="thead-light">
                                        <tr>
                                            <th>@lang('No.')</th>
                                            <th>@lang('Company')</th>
                                            <th>@lang('country')</th>
                                            <th>@lang('Packages')</th>
                                            <th>@lang('Date-time')</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer">
                                <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                                    <div class="col-sm mb-2 mb-sm-0">
                                        <div
                                            class="d-flex justify-content-center justify-content-sm-start align-items-center">
                                            <span class="me-2">@lang('Showing:')</span>
                                            <div class="tom-select-custom">
                                                <select id="datatableEntries"
                                                    class="js-select form-select form-select-borderless w-auto"
                                                    autocomplete="off"
                                                    data-hs-tom-select-options='{
                                                        "searchInDropdown": false,
                                                        "hideSearch": true
                                                      }'>
                                                    <option value="5">5</option>
                                                    <option value="10" selected>10</option>
                                                    <option value="15">15</option>
                                                    <option value="20">20</option>
                                                </select>
                                            </div>
                                            <span class="text-secondary me-2">@lang('of')</span>
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
                </div>
            </div>
        </div>
    </div>


@endsection

@push('css-lib')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/tom-select.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/flatpickr.min.css') }}">
@endpush

@push('js-lib')
    <script src="{{ asset('assets/admin/js/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select.min.js') }}"></script>
@endpush


@push('script')
    <script>
        $(document).on('ready', function() {

            HSCore.components.HSFlatpickr.init('.js-flatpickr')
            HSCore.components.HSTomSelect.init('.js-select', {
                maxOptions: 250,
            })

            HSCore.components.HSDatatables.init($('#datatable'), {
                processing: true,
                serverSide: true,
                ordering: false,
                ajax: {
                    url: "{{ route('admin.agents.companies.search', $user->id) }}",
                },
                columns: [{
                        data: 'no',
                        name: 'no'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },
                    {
                        data: 'packages',
                        name: 'packages'
                    },
                    {
                        data: 'date-time',
                        name: 'date-time'
                    },
                ],
                language: {
                    zeroRecords: `<div class="text-center p-4">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error.svg') }}" alt="Image Description" data-hs-theme-appearance="default">
                    <img class="dataTables-image mb-3" src="{{ asset('assets/admin/img/oc-error-light.svg') }}" alt="Image Description" data-hs-theme-appearance="dark">
                    <p class="mb-0">No data to show</p>
                    </div>`,
                    processing: `<div><div></div><div></div><div></div><div></div></div>`
                },
            });




            $.fn.dataTable.ext.errMode = 'throw';
        });
    </script>
@endpush
