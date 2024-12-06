$(document).ready(function (){

    $('#loginForm').on('submit',function (e){
        e.preventDefault();
        let formAction = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,

            success: function (response) {
                showPopup(response['message'], 'success');
                waitForPopupToHide();
                window.location.href='/';
            },
            error: function (error) {

                showPopup(error.responseJSON['message'], 'danger');
                console.log(error.responseJSON['message']);

            }
        });
    })

    $('#registerForm').on('submit',function (e){
        if($('#password').val()!==$('#confirmPassword').val()){
            showPopup('Пароли не совпадают','danger')
            return false;
        }
        e.preventDefault();
        let formAction = $(this).attr('action');
        let formData = $(this).serialize();

        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,

            success: function (response) {
                showPopup(response['message'], 'success');
                waitForPopupToHide();
                window.location.href='/';
            },
            error: function (error) {

                showPopup(error.responseJSON['message'], 'danger');
                console.log(error.responseJSON['message']);

            }
        });
    })

    $('#createUserFormForm').on('submit',function (e){
        if($('#password').val()!==$('#confirmPassword').val()){
            showPopup('Пароли не совпадают','danger')
            return false;
        }
        e.preventDefault();
        let formAction = $(this).attr('action');
        let formData = $(this).serialize();
        var form = $(this);
        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,

            success: function (response) {
                showPopup(response['message'], 'success');
                form[0].reset()
            },
            error: function (error) {

                showPopup(error.responseJSON['message'], 'danger');


            }
        });
    })

    $('#editUser').on('submit',function (e){
        if($('#password').val()!==$('#confirmPassword').val()){
            showPopup('Пароли не совпадают','danger')
            return false;
        }
        e.preventDefault();
        let formAction = $(this).attr('action');
        let formData = $(this).serialize();
        var form = $(this);
        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,

            success: function (response) {
                showPopup(response['message'], 'success');
                form[0].reset()
            },
            error: function (error) {

                showPopup(error.responseJSON['message'], 'danger');
            }
        });
    })


        $('.processUser button').on('click', function (e) {
            e.preventDefault();

            let form = $(this).closest('.processUser');
            let id = $(form).find('input[name="user_id"]').val();
            let url = $(this).hasClass('accept') ? '/accept-user/'+ id : '/reject-user/' + id;

            $.ajax({
                url: url,
                type: 'get',
                success: function (response) {
                    showPopup(response.message, 'success');
                    form.closest('.card').remove();
                },
                error: function (error) {
                    showPopup('Ошибка: ' + error.responseJSON.message, 'danger');
                }
            });
        });

    $('.editUserListForm').on('click', function (e) {
        e.preventDefault();
        let id =$(this).closest('form').find('input[name="user_id"]').val();
        let url =
        $.ajax({
            url: url,
            type: 'get',
            success: function (response) {
                showPopup(response.message, 'success');
                form.closest('.card').remove();
            },
            error: function (error) {
                showPopup('Ошибка: ' + error.responseJSON.message, 'danger');
            }
        });
    });

    $('.deleteUserListForm').on('click', function (e) {
        e.preventDefault();
        let id =$(this).closest('form').find('input[name="user_id"]').val();
        console.log(id)
    });
    $('.banUserListForm').on('click', function (e) {
        e.preventDefault();
        let id =$(this).closest('form').find('input[name="user_id"]').val();
        console.log(id)

    });



    $('#uploadImageForm').on('submit', function (e) {
        e.preventDefault();

        let formAction = $(this).attr('action');
        let formData = new FormData(this);

        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                console.log('Успех:', response);
                alert('Файлы успешно загружены!');
            },
            error: function (xhr, status, error) {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при загрузке файлов.');
            }
        });
    });

});

function showPopup(message, type) {
    const $popupMessage = $('#popupMessage');

    $popupMessage
        .text(message)
        .removeClass('d-none alert-success alert-danger')
        .addClass(`alert-${type}`)
        .fadeIn();


    setTimeout(function () {
        $popupMessage.fadeOut(function () {
            $popupMessage.addClass('d-none');
        });
    }, 2000);
}

function waitForPopupToHide() {
    const popup = $('#popupMessage');

    const interval = setInterval(function () {
        if (popup.hasClass('d-none')) {
            clearInterval(interval);

        }
    }, 250);
}


