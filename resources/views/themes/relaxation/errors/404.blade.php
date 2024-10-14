@extends($theme.'layouts.error')
@section('title','404')
@section('content')
	<section class="error d-flex justify-content-center align-items-center">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="error-container text-center">
						<div class="error-content">
							<h3>@lang('Oops! Nothing was Found')</h3>
							<p>@lang("Something went wrong, it looks like this page doesn't exist anymore.")</p>
							<a href="{{ route('page','/') }}" class="btn-2">@lang('Go Back Home') <span></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection