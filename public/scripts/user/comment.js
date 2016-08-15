$(document).ready(function () {
	var sendingComment = false;

	$('#send-comment').submit(function (event) {
		if (sendingComment) {
			return false;
		}
		sendingComment = true;
		if ($.trim($(this).find('textarea').val()) == '') {
			alert('Напишите хоть что-нибудь.');
			sendingComment = false;
			return false;
		}
		event.preventDefault();
		var form = $(this);

		$.ajax({
			url: '/bestpeople/public/comment',
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: form.serialize() + '&userId=' + form.attr('data-user-id'),
			dataType: 'html',
			success: function (data, textStatus, jqXHR) {
				form.find('textarea').val('');
				$('#comments').empty().append(data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				switch (jqXHR.status) {
					case 401:
						return alert('Зарегистрируйтесь для того, чтобы иметь возможность комментировать.');
					case 422:
						return alert('Ошибка. Сервер получил неверные данные.');
					case 500:
						return alert('По какой-то причине Ваш комментарий не отправлен.');
				}
				alert(jqXHR.status + ' ' + textStatus + '. ' + errorThrown);
			},
			beforeSend: function () {
				$('#loader').show();
			},
			complete: function () {
				$('#loader').hide();
				sendingComment = false;
			}
		});
	});

	var deletingComment = false;

	$('#comments').on('click', 'a.comment-delete', function (event) {
		if (deletingComment) {
			return false;
		}
		deletingComment = true;
		event.preventDefault();
		var link = $(this);

		$.ajax({
			url: '/bestpeople/public/comment/' + link.attr('data-comment-id'),
			type: 'DELETE',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function (data, textStatus, jqXHR) {
				if (data.deleted) {
					link.parent().siblings('pre.comment-text').addClass('comment-deleted');
					link.empty().append('восстановить комментарий');
					link.removeClass('comment-delete').addClass('comment-recover');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				switch (jqXHR.status) {
					case 401:
						return alert('Зарегистрируйтесь для того, чтобы иметь доступ к этому функционалу.');
					case 403:
						return alert('Вы не можете удалить этот комментарий.');
					case 422:
						return alert('Ошибка. Сервер получил неверные данные.');
					case 500:
						return alert('Не удалось удалить комментарий.');
				}
				alert(jqXHR.status + ' ' + textStatus + '. ' + errorThrown);
			},
			beforeSend: function () {
				$('#loader').show();
			},
			complete: function () {
				$('#loader').hide();
				deletingComment = false;
			}
		});
	});

	var recoveringComment = false;

	$('#comments').on('click', 'a.comment-recover', function (event) {
		if (recoveringComment) {
			return false;
		}
		recoveringComment = true;
		event.preventDefault();
		var link = $(this);

		$.ajax({
			url: '/bestpeople/public/recover_comment/' + link.attr('data-comment-id'),
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: 'json',
			success: function (data, textStatus, jqXHR) {
				if (data.recovered) {
					link.parent().siblings('pre.comment-text').removeClass('comment-deleted');
					link.empty().append('удалить комментарий');
					link.removeClass('comment-recover').addClass('comment-delete');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				switch (jqXHR.status) {
					case 401:
						return alert('Зарегистрируйтесь для того, чтобы иметь доступ к этому функционалу.');
					case 403:
						return alert('Вы не можете восстановить этот комментарий.');
					case 422:
						return alert('Ошибка. Сервер получил неверные данные.');
					case 500:
						return alert('Не удалось восстановить комментарий.');
				}
				alert(jqXHR.status + ' ' + textStatus + '. ' + errorThrown);
			},
			beforeSend: function () {
				$('#loader').show();
			},
			complete: function () {
				$('#loader').hide();
				recoveringComment = false;
			}
		});
	});
});