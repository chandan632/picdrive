$(document).ready(function () {
    $(".activation-btn").click(function () {
        var code = btoa($("#code").val());
        var username = btoa($("#email").val());
        $.ajax({
            type: "POST",
            url: "php/activator.php",
            data: {
                code: code,
                username: username
            },
            beforeSend: function () {
                $(".activation-btn").html("Please wait we are checking...");
            },
            success: function (response) {
                alert(response);
            }
        });
    });
});