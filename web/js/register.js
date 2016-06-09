$(document).ready(function () {

    $('#registerForm').submit(function (event) {
        register(event);
    });
});

function register(event) {
	event.preventDefault();
        var formData = $('#registerForm').serialize();
	$.ajax({
		url: '/register',
		type: 'PUT',
		data: formData,
		success: function(response) {
                    $('#responce').html(response['message']);
		},
		error: function(response) {
                    alert('error');
		}
	});
}
