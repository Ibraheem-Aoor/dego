<div class="modal fade" id="bookingInformation" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bookingInformationLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="bookingInformationLabel">@lang('Booking Information')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th class="w-50">@lang('Package Name'):</th>
                        <td><span class="packageName"></span></td>
                    </tr>
                    <tr>
                        <th class="w-50">@lang('Total Amount'):</th>
                        <td><span class="totalAmount"></span></td>
                    </tr>
                    <tr>
                        <th class="w-50">@lang('Number Of Adults'):</th>
                        <td><span class="adult"></span></td>
                    </tr>
                    <tr>
                        <th class="w-50">@lang('Number Of Children'):</th>
                        <td><span class="children"></span></td>
                    </tr>
                    <tr>
                        <th class="w-50">@lang('Number Of Infant'):</th>
                        <td><span class="infant"></span></td>
                    </tr>
                    <tr>
                        <th class="w-50">@lang('Booking Date'):</th>
                        <td><span class="bookingDate"></span></td>
                    </tr>
                    <tr>
                        <th class="w-50">@lang('Total Person'):</th>
                        <td><span class="totalPerson"></span></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).on("click", '.bookingView', function (e) {
            let title = $(this).data('title');
            let price = $(this).data('price');
            let adult = $(this).data('adult');
            let child = $(this).data('child');
            let infant = $(this).data('infant');
            let totalPerson = $(this).data('total_person');
            let date = $(this).data('date');


            $('.totalPerson').html(totalPerson);
            $('.packageName').html(title);
            $('.totalAmount').html(price);
            $('.adult').html(adult);
            $('.children').html(child);
            $('.infant').html(infant);
            $('.bookingDate').html(date);
        });
    </script>
@endpush
