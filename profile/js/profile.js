$(document).ready(function () {
    $(".upload-icon").click(function () {
        var input = document.createElement("INPUT");
        input.type = "file";
        input.accept = "images/*";
        input.click();
        input.onchange = function () {
            var file = new FormData();
            file.append("data", this.files[0]);
            $.ajax({
                type: "POST",
                url: "php/upload.php",
                data: file,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    alert(response);
                    $.ajax({
                        type: "POST",
                        url: "php/count_photo.php",
                        beforeSend: function () {
                            $(".count-photo").html("Updating...");
                        },
                        success: function (response) {
                            $(".count-photo").html(response);
                        }
                    });
                }
            });
        }
    });
});