@extends('layouts.app')

@section('content')
	<div class="container">
		<img src="{{ asset('loader.gif') }}" id="loader">
		<div class="row">
			<div class="col-md-6 col-md-offset-1">
				<img src="{{ asset('uploads/avatars/' . $userProfile->avatar) }}" class="profile-avatar">
				<span class="h1 profile-login">{{ $userProfile->login }}</span>
			</div>
		</div>
		<div id="profile">
			@include('user.userInfo')
		</div>

		<div class="row">
			<div class="col-md-6 col-md-offset-1">
				<div id="comments">
					@include('user.comments', ['whoComment' => $userProfile->whoComment])
				</div>
				<form role="form" type="POST" action="" id="send-comment" data-user-id="{{ $userProfile->id }}">
					{{ csrf_field() }}

					<div class="form-group">
						<textarea name="comment" placeholder="Оставьте Ваш комментарий..." rows="5"
						required maxlength="1000" style="resize: none" class="form-control"></textarea>
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary" value="Отправить"
						class="form-control">
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- <script src="{{ asset('scripts/user/vote.js') }}"></script> -->
	@include('scripts.vote')
	<!-- <script src="{{ asset('scripts/user/comment.js') }}"></script> -->
	@include('scripts.comment')
@endsection