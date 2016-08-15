$(document).ready(function () {
	var voting = false;

	$('#top-list, #profile').on('click', 'button[data-karma="plus"], button[data-karma="minus"]',
	function () {
		if (voting) {
			return false;
		}
		voting = true;
		var element = $('#top-list').attr('id') != undefined ? 'topList' : 'profile';
		var params = {};
		var url = window.location.href.slice(window.location.href.indexOf('?') + 1);
		url.split('&').forEach(function (item) {
			item = item.split('=');
			params[item[0]] = item[1];
		})

		$.ajax({
			url: "{{ url('/vote') }}",
			type: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: {
				userId: $(this).attr('data-user-id'),
				karma: $(this).attr('data-karma'),
				from: element,
				page: params.page
			},
			dataType: 'html',
			success: function (data, textStatus, jqXHR) {
				switch (element) {
					case 'topList':
						$('#top-list').empty().append(data);
						break;
					case 'profile':
						$('#profile').empty().append(data);
						break;
					default:
						alert('unknown place');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				switch (jqXHR.status) {
					case 401:
						return alert('Зарегистрируйтесь для того, чтобы иметь возможность голосовать.');
					case 422:
						return alert('Ошибка. Сервер получил неверные данные.');
					case 500:
						return alert('По какой-то причине Ваш голос не засчитан.');
				}
				alert(jqXHR.status + ' ' + textStatus + '. ' + errorThrown);
			},
			beforeSend: function () {
				$('#loader').show();
			},
			complete: function () {
				$('#loader').hide();
				voting = false;
			}
		});
	});
});