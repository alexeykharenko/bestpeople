@forelse($bestPeople as $user)
	<div class="row top-user-block">
		<div class="col-md-2">
			<p class="text-center"><img src="{{ asset('uploads/avatars') . '/' . $user->avatar }}"
				class="main-avatar"></p>
			<p class="text-center"><a href="{{ url('/profile/' . $user->id) }}">{{ $user->login}}</a></p>
		</div>

		<div class="col-md-7">
			<p class="text-center h3">{{ $user->karma }}</p>
		</div>

		<div class="col-md-3">
			<button class="main-send-vote btn{!! (isset($user->getVotes[0]) &&
				$user->getVotes[0]->vote == 'plus' ? ' btn-success" disabled' : '"') !!}
				{{ $authId == $user->id ? 'disabled' : '' }}
				data-user-id="{{ $user->id }}" data-karma="plus">
				+</button>
			<button class="main-send-vote btn{!! (isset($user->getVotes[0]) &&
				$user->getVotes[0]->vote == 'minus' ? ' btn-danger" disabled' : '"') !!}
				{{ $authId == $user->id ? 'disabled' : '' }}
				data-user-id="{{ $user->id }}" data-karma="minus">
				-</button>
		</div>
	</div>
@empty
	<div class="row">
		<div class="col-md-12">
			<h3>Похоже, на сайте нет пользователей. Станьте первым, зарегистрировавшись.</h3>
		</div>
	</div>
@endforelse