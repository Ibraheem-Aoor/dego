@extends($theme . 'layouts.app')
@section('title',trans('Home'))
@section('content')
    {!!  $sectionsData !!}
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <style>
        .lang_active{
            color: var(--primary-color) !important;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script>
        flatpickr('#myID', {
            enableTime: false,
            dateFormat: 'Y-m-d',
            minDate: 'today',
            disableMobile: "true"
        });
        document.addEventListener("DOMContentLoaded", function () {
            function handleInput(inputBox) {
                if (inputBox) {
                    const inputField = inputBox.querySelector(".form-control");
                    if (inputField) {
                        inputBox.addEventListener("click", function () {
                            inputField.focus();
                        });
                    }
                }
            }

            const inputBox = document.querySelector(".input-box");
            handleInput(inputBox);
            const inputBox2 = document.querySelector(".input-box2");
            handleInput(inputBox2);
        });
        $(document).ready(function() {
            function hideSearchResults() {
                $('#searchResults').empty().hide();
            }

            $('input[name="search"]').on('keyup', function() {
                let searchValue = $(this).val().trim();
                if (searchValue === '') {
                    hideSearchResults();
                    return;
                }

                $.ajax({
                    url: "{{ route('live.data') }}",
                    method: 'GET',
                    data: { search: searchValue },
                    success: function(response) {
                        $('#searchResults').empty();
                        if (response.length > 0) {
                            response.forEach(function(item) {
                                var resultHtml = '';
                                var itemTitle = item.title || item.name;
                                if (item.details) {
                                    resultHtml = '<a href="#" class="search-item">' +
                                        '<div class="img-area">' +
                                        '<img src="' + item.url + '" alt="' + itemTitle + '">' +
                                        '</div>' +
                                        '<div class="text-area">' +
                                        '<h5 class="title mb-0">' + itemTitle + '</h5>' +
                                        '<span class="sub-title">' + item.location + '</span>' +
                                        '</div>' +
                                        '</a>';
                                } else if (item.icon) {
                                    resultHtml = '<a href="#" class="search-item">' +
                                        '<div class="icon-area">' +
                                        '<i class="' + item.icon + '"></i>' +
                                        '</div>' +
                                        '<div class="text-area">' +
                                        '<h5 class="title mb-0">' + itemTitle + '</h5>' +
                                        '<span class="sub-title">nearby</span>' +
                                        '</div>' +
                                        '</a>';
                                } else {
                                    resultHtml = '<a href="#" class="search-item">' +
                                        '<div class="icon-area">' +
                                        '<i class="' + item.logo + '"></i>' +
                                        '</div>' +
                                        '<div class="text-area">' +
                                        '<h5 class="title mb-0">' + itemTitle + '</h5>' +
                                        '</div>' +
                                        '</a>';
                                }

                                let $resultItem = $(resultHtml);
                                $resultItem.on('click', function(event) {
                                    event.preventDefault();
                                    $('input[name="search"]').val(itemTitle);
                                    hideSearchResults();
                                });

                                $('#searchResults').append($resultItem);
                            });
                            $('#searchResults').show();
                        } else {
                            hideSearchResults();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#searchResults').length && !$(e.target).closest('input[name="search"]').length) {
                    hideSearchResults();
                }
            });
        });

        function toggleHeart(element) {
            @if (!auth()->check())
                window.location.href = '{{ route("login") }}';
            return;
            @endif

            let heartIcon = $(element).find('i.fa-heart');
            let packageId = $(element).data('id');
            let type = $(element).data('type');

            if (heartIcon.hasClass('fa-solid')) {
                removeFavorite(packageId);
                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                heartIcon.css('color', '');
            } else {
                addFavorite(packageId);
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                heartIcon.css('color', 'red');
            }
        }

        function addFavorite(packageId) {
            $.ajax({
                url: '{{ route('user.package.reaction') }}',
                type: 'GET',
                data: {
                    package_id: packageId,
                    reaction: 1
                },
                success: function(response) {
                    Notiflix.Notify.success(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        function removeFavorite(packageId) {
            $.ajax({
                url: '{{ route('user.package.reaction') }}',
                type: 'GET',
                data: {
                    package_id: packageId,
                    reaction: 0
                },
                success: function(response) {
                    Notiflix.Notify.success(response.message);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

    </script>
@endpush
