@extends($theme.'layouts.error')
@section('title','403 Forbidden')


@section('content')
	<section class="error-section">
		<div class="container">
			<div class="row g-5 align-items-center">
				<div class="col-sm-6">
					<div class="error-content">
						<div class="error-title">@lang('Forbidden')</div>
						<div class="error-info">{{trans("You don't have permission to access ‘/’ on")}} <span
								class="text-gradient">{{trans('this server')}}</span></div>
						<div class="btn-area">
							<a href="{{ route('page','/') }}" class="btn-2">@lang('Go Back Home') <span></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
