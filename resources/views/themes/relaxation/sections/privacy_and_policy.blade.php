<section class="terms">
    <div class="container">
        <div class="terms-container">
            <div class="row">
                <div class="col-lg-12">
                    @foreach(@$privacy_and_policy['multiple'] as $item)
                        <div class="terms-content">
                            <h6>@lang(@$item['topic'])</h6>
                            <p>{{ strip_tags(@$item['description']) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
