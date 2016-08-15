<h1>Комментарии</h1>
<?php $i = 0; ?>
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
	@break(++$i == 4)
@empty
	<p>Никто тут не написал.</p>
@endforelse
@if ($i >= 4)
	<a href="{{ url('/profile/' . $userProfile->id . '/comments') }}">Показать все комментарии...</a>
@endif