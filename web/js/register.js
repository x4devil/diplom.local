$(document).ready(function () {

    $('#registerForm').submit(function (event) {
        register(event);
    });
    $('#loginForm').submit(function (event) {
        login(event);
    });
});

function register(event) {
    event.preventDefault();
    var formData = $('#registerForm').serialize();
    $.ajax({
        url: '/register',
        type: 'PUT',
        data: formData,
        success: function (data) {
            $('#responce').html(
                    '<span class="label label-' + data['responce']['code'] + '">' + data['responce']['message'] + '</span>'
                    );
            $('#fio').val('');
            $('#phone').val('');
            $('#login').val('');
            $('#password').val('');
            $('#confirm-password').val('');
            
            if (data['responce']['code'] === 'success') {
                $('#modalRegistration').modal('hide');
            }
        },
        error: function (response) {
            '<span class="label label-error">Произошла ошибка попробуйте позже</span>'
        }
    });
}

function login(event) {
    event.preventDefault();
    var login = $('#login-login').val();
    var password = $('#login-password').val();
    $.ajax({
        url: '/login',
        type: 'PUT',
        data: {'login-login' : login, 'login-password': password},
        success: function (data) {
            $('#responceLogin').html(
                    '<span class="label label-' + data['responce']['code'] + '">' + data['responce']['message'] + '</span>'
                    );
            $('#login-login').val('');
            $('#login-password').val('');

            if (data['responce']['code'] === 'success') {
                $('#modalLogin').modal('hide');
                $('#loginUser').html('Вы вошли как:' + data['responce']['user']);
            }
        },
        error: function (response) {
            '<span class="label label-error">Произошла ошибка попробуйте позже</span>'
        }
    });
}
