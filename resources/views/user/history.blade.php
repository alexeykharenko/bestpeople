@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-9 col-md-offset-1">
			<h1>Полная история голосов пользователя <a href="{{ url('/profile/' . $user->id) }}">
				{{ $user->login }}</a></h1>
			@forelse ($whoVote as $who)
				<p class="{{ $who->pivot->vote == 'plus' ? 'bg-success' : 'bg-danger' }}">
					{{ $who->pivot->updated_at->format('d.m.Y в H:i:s') }}
					<a href="{{ url('/profile/' . $who->pivot->id_who) }}">
					{{ $who->login }}</a> поставил{{ $who->sex == 'female' ? 'а ' : ' ' }}
					{{ $who->pivot->vote }}</p>
			@empty
				<p>К сожалению, за Вас пока никто не проголосовал.</p>
			@endforelse
			{{ $whoVote->render() }}
		</div>
	</div>
</div>
@endsection