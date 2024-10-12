@extends($theme . 'layouts.app')
@section('title',trans('Home'))
@section('content')
    {!!  $sectionsData !!}
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset($themeTrue . 'css/flatpickr.min.css') }}">
    <style>
        .supportItem{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
    </style>
@endpush
@push('script')
    <script src="{{ asset($themeTrue.'js/flatpickr.js')}}"></script>
    <script>
        flatpickr('#myID', {
            enableTime: false,
            dateFormat: "Y-m-d",
            minDate: 'today',
            disableMobile: "true"
        });

        function updateCount(type, delta) {
            const spans = document.querySelectorAll(`.${type}`);
            let count = parseInt(spans[0].textContent);
            count = Math.max(0, count + delta);

            spans.forEach(span => {
                span.textContent = count;
            });

            document.getElementById(type + 'Input').value = count;
        }

        document.querySelectorAll('.increment, .decrement, .incrementTwo, .decrementTwo, .incrementThree, .decrementThree').forEach(button => {
            button.addEventListener('click', () => {
                const type = button.getAttribute('data-type');
                const delta = button.classList.contains('increment') || button.classList.contains('incrementTwo') || button.classList.contains('incrementThree') ? 1 : -1;
                updateCount(type, delta);
            });
        });

        function toggleHeart(element) {
            let heartIcon = $(element).find('i.fa-heart');
            let destinationId = $(element).data('id');

            if (heartIcon.hasClass('fa-solid')) {
                removeFavorite(destinationId);
                heartIcon.removeClass('fa-solid').addClass('fa-regular');
                heartIcon.css('color', '');
            } else {
                addFavorite(destinationId);
                heartIcon.removeClass('fa-regular').addClass('fa-solid');
                heartIcon.css('color', 'red');
            }
        }

        function addFavorite(destinationId) {
            $.ajax({
                url: '{{ route('user.destination.reaction') }}',
                type: 'GET',
                data: {
                    destination_id: destinationId,
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

        function removeFavorite(destinationId) {
            $.ajax({
                url: '{{ route('user.destination.reaction') }}',
                type: 'GET',
                data: {
                    destination_id: destinationId,
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
        document.addEventListener('DOMContentLoaded', function() {
            const accordions = document.querySelectorAll('.accordion');

            accordions.forEach(acc => {
                acc.addEventListener('click', function(event) {
                    const icon = event.target.closest('.icon');
                    if (!icon) return;

                    const action = icon.getAttribute('data-action');
                    const content = this.querySelector('.acc-content');

                    if (action === 'open') {
                        this.classList.add('active-block');
                        content.style.display = 'block';
                    } else if (action === 'close') {
                        this.classList.remove('active-block');
                        content.style.display = 'none';
                    }

                    accordions.forEach(a => {
                        if (a !== this) {
                            a.classList.remove('active-block');
                            a.querySelector('.acc-content').style.display = 'none';
                        }
                    });
                });
            });

            if (accordions.length > 0) {
                const firstAcc = accordions[0];
                firstAcc.classList.add('active-block');
                firstAcc.querySelector('.acc-content').style.display = 'block';
            }
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

    </script>
@endpush
