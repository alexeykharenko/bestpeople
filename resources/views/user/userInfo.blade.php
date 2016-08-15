<div class="row">
	<div class="col-md-3 col-md-offset-1">
		<h3>Карма: {{ $userProfile->karma }}</h3>
		@if ($authId === $userProfile->id)
			<a href="{{ url('/edit_profile') }}">Изменить информацию о себе</a>
		@else
			<button class="profile-send-vote btn{!! (isset($userProfile->getVotes[0]) &&
				$userProfile->getVotes[0]->vote == 'plus' ? ' btn-success" disabled' : '"') !!}
				data-user-id="{{ $userProfile->id }}" data-karma="plus">
				+</button>
			<button class="profile-send-vote btn{!! (isset($userProfile->getVotes[0]) &&
				$userProfile->getVotes[0]->vote == 'minus' ? ' btn-danger" disabled' : '"') !!}
				data-user-id="{{ $userProfile->id }}" data-karma="minus">
				-</button>
		@endif
	</div>
</div>

<div class="row">
	<div class="col-md-6 col-md-offset-1">
		<h1>История голосов</h1>
		<?php $i = 0; ?>
		@forelse ($userProfile->whoVote as $who)
			<p class="{{ $who->pivot->vote == 'plus' ? 'bg-success' : 'bg-danger' }}">
				{{ $who->pivot->updated_at->format('d.m.Y в H:i:s') }}
				<a href="{{ url('/profile/' . $who->pivot->id_who) }}">
				{{ $who->login }}</a> поставил{{ $who->sex == 'female' ? 'а ' : ' ' }}
				{{ $who->pivot->vote }}</p>
			@break(++$i == 4)
		@empty
			<p>К сожалению, за Вас пока никто не проголосовал.</p>
		@endforelse
		@if ($i >= 4)
			<a href="{{ url('/profile/' . $userProfile->id . '/history') }}">Показать полную историю голосов...</a>
		@endif
	</div>
</div>