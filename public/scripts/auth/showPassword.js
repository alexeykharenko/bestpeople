$(document).ready(function () {
	$('#show-password').change(function () {
		if ($('#show-password').prop('checked')) {
			$('#password').prop('type', 'text');
		} else {
			$('#password').prop('type', 'password');
		}
	});
});