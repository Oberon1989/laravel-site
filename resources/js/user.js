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

                console.log(response);

            },
            error: function (xhr, status, error) {

                console.error('Ошибка:', error);

            }
        });
    })


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
