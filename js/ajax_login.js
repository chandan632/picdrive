$(document).ready(function () {
    $(".login-submit-btn").click(function (e) {
        e.preventDefault();
        var username = btoa($("#login-email").val());
        var password = btoa($("#login-password").val());
        $.ajax({
            type: "POST",
            url: "php/login.php",
            data: {
                username: username,
                password: password
            },
            beforeSend: function () {
                $(".login-submit-btn").html("Processing please wait....");
                $(".login-submit-btn").attr("disabled", "disabled");
            },
            success: function (response) {
                alert(response);
                if (response.trim() == "Login success") {
                    location = "profile/profile.php";
                } else if (response.trim() == "Login pending") {
                    $("#login-form").fadeOut(500, function () {
                        $(".login-activator").removeClass("d-none");
                    })
                } else if (response.trim() == "Wrong password") {
                    var message = document.createElement("DIV");
                    message.className = "alert alert-warning";
                    message.innerHTML = "<b>Wrong password!</b>";
                    $(".login-notice").append(message);
                    $("#login-form").trigger('reset');
                    $(".login-submit-btn").html("Login now");
                    $(".login-submit-btn").removeAttr("disabled");
                    setTimeout(function () {
                        $(".login-notice").html("");
                    }, 5000);
                } else {
                    message = document.createElement("DIV");
                    message.className = "alert alert-warning";
                    message.innerHTML = "<b>User not found! Please signup.</b>";
                    $(".login-notice").append(message);
                    $("#login-form").trigger('reset');
                    $(".login-submit-btn").html("Login now");
                    $(".login-submit-btn").removeAttr("disabled");
                    setTimeout(function () {
                        $(".login-notice").html("");
                    }, 5000);
                }
            }
        });
    });
});