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
                xhr: function () {
                    var request = new XMLHttpRequest();
                    request.upload.onprogress = function (e) {
                        var loaded = (e.loaded / 1024 / 1024).toFixed(2);
                        var total = (e.loaded / 1024 / 1024).toFixed(2);
                        var percentage = (loaded * 100) / total;
                        $(".progress-control").css({
                            width: percentage + "%",
                        });
                        $(".progress-percentage").html(percentage + "% " + loaded + "MB / " + total + "MB");
                    }
                    return request;
                },
                beforeSend: function () {
                    $(".upload-header").html("Please wait...");
                    $(".upload-icon").css({
                        opacity: "0.5",
                        pointerEvents: "none"
                    });
                    $(".upload-progress-con").removeClass("d-none");
                    $(".progress-details").removeClass("d-none");
                },
                success: function (response) {
                    alert(response);
                    if (response.trim() == "Success!") {
                        $(".upload-header").html("UPLOAD FILES");
                        $(".upload-icon").css({
                            opacity: "1",
                            pointerEvents: "inherit",
                        });
                        $(".upload-progress-con").addClass("d-none");
                        $(".progress-details").addClass("d-none");
                    }
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
                    $.ajax({
                        type: "POST",
                        url: "php/memory.php",
                        beforeSend: function () {
                            $(".memory-status").html("Updating...");
                            $(".free-space").html("Updating...");
                        },
                        success: function (response) {
                            var json_response = JSON.parse(response)
                            var memory_status = json_response[0]
                            var free_memory = json_response[1]
                            var percentage = json_response[2] + "%"
                            $(".memory-status").html(memory_status);
                            $(".free-space").html("FREE SPACE : " + free_memory)
                            $(".memory-progress").css({
                                width: percentage
                            })
                        }
                    });
                }
            });
        }
    });
});