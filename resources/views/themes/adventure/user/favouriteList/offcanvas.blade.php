<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">@lang('Favourite List Filter')</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form action="{{ route('user.dashboard') }}" method="GET">
            <div class="row g-4">
                <div>
                    <label for="packageTitle" class="form-label">@lang('Package')</label>
                    <input type="text" class="form-control" name="title" value="{{ request()->title }}" id="packageTitle">
                </div>
                <div id="formModal">
                    <label class="form-label" for="fromDate">@lang('Date From')</label>
                    <input type="text" class="form-control" value="{{ request()->from_date }}" name="from_date" id="fromDate">
                </div>
                <div id="formModal">
                    <label class="form-label" for="toDate">@lang('Date To')</label>
                    <input type="text" class="form-control" value="{{ request()->to_date }}" name="to_date" id="toDate">
                </div>
                <div class="btn-area">
                    <button type="submit" class="cmn-btn">@lang('Filter')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script>
        flatpickr('#fromDate', {
            enableTime: false,
            dateFormat: "Y-m-d",
            disableMobile: "true"
        });
        flatpickr('#toDate', {
            enableTime: false,
            dateFormat: "Y-m-d",
            disableMobile: "true"
        });
    </script>
@endpush
