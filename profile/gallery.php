<?php
    session_start();
    $username = $_SESSION['username'];
    if(empty($username))
    {
        header("Location:../index.php");
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Page</title>
    <link rel="stylesheet" href="./../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/animate.css">
    <link href="https://fonts.googleapis.com/css?family=Francois+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="./../js/jquery-3.4.1.min.js"></script>
    <script src="./../js/popper.min.js"></script>
    <script src="./../js/bootstrap.min.js"></script>
    <script src="./js/profile.js"></script>
    <script src="./js/edit_photo.js"></script>
    <style>
        span:focus{
            outline: 2px dashed red;
            padding: 2px;
            box-shadow: 0px 0px 5px grey;
        }
    </style>
</head>
<body style="background:#FCD0CF">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
        <a href="" class="navbar-brand" href="#">
            <?php
                require("../php/database.php");
                $email = $_SESSION['username'];
                $get_name = "SELECT full_name from users WHERE username='$email'";
                $response = $db->query($get_name);
                $name = $response->fetch_assoc();
                echo $name["full_name"];
            ?>
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="php/logout.php" class="nav-link">
                    <i class="fa fa-sign-out" style="font-size: 18px"></i>Logout
                </a>
            </li>
        </ul>
    </nav>
    <br>
    <div class="container mt-5">
    <div class="row">
    <?php
        $table_name = $_SESSION['table_name'];
        $get_image_path = "SELECT * FROM $table_name";
        $response = $db->query($get_image_path);
        while($data = $response->fetch_assoc())
        {
           $image_name = pathinfo($data['image_name']);
           $image_name = $image_name['filename'];
           $path = str_replace("../","",$data['image_path']);
           echo "<div class='col-md-3 px-5 pb-5'>
            <div class='card shadow-lg'>
                <div class='card-body d-flex justify-content-center align-items-center'>
                    <img src='".$path."' width='100' height='150' class='rounded-circle pic'>
                </div>
                <div class='card-footer d-flex justify-content-around align-items-center'>
                <span>".$image_name."</span>
                <i class='fa fa-save save-icon d-none' data-location='".$path."'></i>
                <i class='fa fa-spinner fa-spin loader edit-icon d-none' data-location='".$path."'></i>
                <i class='fa fa-edit edit-icon' data-location='".$path."'></i>
                <i class='fa fa-download download-icon' data-location='".$path."' file-name='".$image_name."'></i>
                <i class='fa fa-trash delete-icon' data-location='".$path."'></i>
                </div>
            </div>
           </div>";
        }
    ?>
    </div>
    </div>
    <div class="modal my-5 animated bounceIn" id="view-modal">
        <div class="modal-dialog">
        <i class="fa fa-times-circle float-right text-white" data-dismiss="modal"></i>
            <div class="modal-content">
            
                <div class="modal-body">
                    welcome
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".pic").each(function(){
                $(this).click(function(){
                    var image = document.createElement('IMG');
                    image.src = $(this).attr("src");
                    image.style.width = "100%";
                    $(".modal-body").html(image);
                    $("#view-modal").modal();
                });
            });
        });
    </script>
</body>
</html>