@extends($theme.'layouts.error')
@section('title','419')


@section('content')
	<section class="error-section">
		<div class="container">
			<div class="row g-5 align-items-center">
				<div class="col-sm-6">
					<div class="error-content">
						<div class="error-title">@lang('419')</div>
						<div class="error-info">{{trans('Sorry, your session')}} <span
								class="text-gradient">{{trans('has expired')}}</span></div>
						<div class="btn-area">
							<a href="{{ route('page','/') }}" class="btn-2">@lang('Go Back Home') <span></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
