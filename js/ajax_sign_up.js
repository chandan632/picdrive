$(document).ready(function () {
    $(".submit-btn").on('click', function (e) {
        e.preventDefault();
        $.ajax({
            cache: false,
            type: "POST",
            url: "php/sign_up.php",
            data: {
                fullname: btoa($("#fullname").val()),
                username: btoa($("#email").val()),
                password: btoa($("#password").val())
            },
            beforeSend: function () {
                $('.submit-btn').html("Processing please wait!");
                $(".submit-btn").attr("disabled", "disabled");
            },
            success: function (response) {
                if (response.trim() == "sending success") {
                    $("#signup-form").fadeOut(500, function () {
                        $(".activator").removeClass("d-none");
                    });
                }
                else {
                    var message = document.createElement('DIV');
                    message.className = "alert alert-warning";
                    message.innerHTML = "<b>Something went wrong please try again later</b>";
                    $(".signup-notice").append(message);
                    $(".submit-btn").html("Register now");
                    $("form").trigger('reset');
                    $(".email-loader").addClass('d-none');
                    setTimeout(function () {
                        $(".signup-notice").html("");
                    }, 2000);
                }
            }
        });
    });
});