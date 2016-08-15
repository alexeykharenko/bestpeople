@extends('layouts.app')

@section('content')
	<div class="container">
		<img src="{{ asset('loader.gif') }}" id="loader">
		<div class="row">
			<div class="col-md-7 col-md-offset-1" id="comments">
				<h1>Все комментарии, оставленные для <a href="{{ url('/profile/' . $user->id) }}">
					{{ $user->login }}</a></h1>
				@forelse ($whoComment as $who)
					<div class="comment-block">
						<pre class="comment-text">{{ $who->pivot->comment }}</pre>
						<p class="comment-left">написал{{ $who->sex == 'female' ? 'а ' : ' ' }}
						<a href="{{ url('/profile/' . $who->pivot->id_who) }}">{{ $who->login }}</a>
						{{ $who->pivot->updated_at->format('d.m.Y в H:i:s') }}</p>
						@if($authId === $who->id)
							<p class="action-right"><a href="#" class="comment-action comment-delete"
							data-comment-id="{{ $who->pivot->id }}">удалить комментарий</a></p>
						@endif
						<div class="after-comment"></div>
					</div>
				@empty
					<p>Никто тут не написал.</p>
				@endforelse
				{{ $whoComment->render() }}
			</div>
		</div>
	</div>

	<!-- <script src="{{ asset('scripts/user/comment.js') }}"></script> -->
	@include('scripts.comment')
@endsection