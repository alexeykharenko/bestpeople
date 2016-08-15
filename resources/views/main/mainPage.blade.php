@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-1">
			<h1>Лучшие люди интернета</h1>
			<img src="{{ asset('loader.gif') }}" id="loader">
			<div id="top-list">
				@include('main.topList')
			</div>
			{{ $bestPeople->render() }}
		</div>
	</div>
</div>

<!-- <script src="{{ asset('scripts/user/vote.js') }}"></script> -->
@include('scripts.vote')
@endsection