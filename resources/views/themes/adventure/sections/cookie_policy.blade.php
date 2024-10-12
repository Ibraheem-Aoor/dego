<section class="terms">
    <div class="container">
        <div class="terms-container">
            <div class="row">
                <div class="header-text mb-5">
                    <h6 class="cookieHeading">@lang(@$cookie_policy['single']['heading'])</h6>
                </div>
                <div class="col-lg-12">
                    @foreach($cookie_policy['multiple'] as $item)
                        <div class="terms-content my-1">
                            <h6>@lang($item['topic'])</h6>
                            <p>{{ strip_tags($item['description']) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
