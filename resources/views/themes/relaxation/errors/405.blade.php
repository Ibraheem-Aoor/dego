@extends($theme.'layouts.error')
@section('title','405')


@section('content')
	<section class="error-section">
		<div class="container">
			<div class="row g-5 align-items-center errorItemDiv">
				<div class="col-sm-6">
					<div class="error-content">
						<div class="error-title">@lang('Opps! 405')</div>
						<div class="error-info">{{trans('Method Not')}} <span
								class="text-gradient">{{trans('Allowed')}}</span></div>
						<div class="btn-area">
							<a href="{{ route('page','/') }}" class="btn-2">@lang('Go Back Home') <span></span></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
