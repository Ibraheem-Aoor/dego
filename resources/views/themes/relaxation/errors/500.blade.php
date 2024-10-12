@extends($theme.'layouts.error')
@section('title','500')
@section('content')
	<section class="error-section">
		<div class="container">
			<div class="row g-5 align-items-center">
				<div class="col-sm-6">
					<div class="error-content">
						<div class="error-title">@lang('Internal Server Error')</div>
						<div class="error-info">{{trans('The server encountered an internal error misconfiguration and was unable to complete your request.')}} <span
								class="text-gradient">{{trans('Please contact the server administrator.')}}</span></div>
						<div class="btn-area">
							<a href="{{ route('page','/') }}" class="btn-2">@lang('Go Back Home') <span></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
