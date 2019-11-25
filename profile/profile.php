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
    <link href="https://fonts.googleapis.com/css?family=Francois+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="./../js/jquery-3.4.1.min.js"></script>
    <script src="./../js/popper.min.js"></script>
    <script src="./../js/bootstrap.min.js"></script>
    <script src="./js/profile.js"></script>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 p-5 border">
                <div class="d-flex mb-5 flex-column justify-content-center align-items-center w-100 bg-white rounded-lg shadow-lg" style="height:250px">
                    <i class="fa fa-folder-open upload-icon" style="font-size:100px"></i>
                    <h4>UPLOAD FILES</h4>
                    <span>FREE SPACE : 10MB</span>
                    <div class="progress w-50 my-2" style="height: 5px">
                        <div class="progress-bar progress-bar-animated progress-bar-striped w-50"></div>
                    </div>
                    <div>
                        <span>50%</span>
                        <i class="fa fa-pause-circle"></i>
                        <i class="fa fa-times-circle"></i>
                    </div>
                </div>

                <div class="d-flex mb-5 flex-column justify-content-center align-items-center w-100 bg-white rounded-lg shadow-lg" style="height:250px">
                    <i class="fa fa-database" style="font-size:80px"></i>
                    <h4>MEMORY STATUS</h4>
                    <span class="memory">
                    <?php
                        $get_status = "SELECT storage,used_storage FROM users WHERE username = '$username'";
                        $response = $db->query($get_status);
                        $data = $response->fetch_assoc();
                        $total = $data["storage"];
                        $used = $data["used_storage"];
                        echo $used."MB/".$total."MB";
                        $percentage = round(($used * 100) / $total, 2);
                        $color = "";
                        if($percentage>80)
                        {
                            $color = "bg-danger";
                        }
                        else{
                            $color = "bg-primary";
                        }
                    ?>
                    </span>
                    <div class="progress w-50 my-2" style="height: 5px">
                        <div class="progress-bar <?php echo $color;?>" style="width:<?php echo $percentage.'%'; ?> "></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-5 border"></div>
            <div class="col-md-3 p-5 border">
            <div class="d-flex mb-5 flex-column justify-content-center align-items-center w-100 bg-white rounded-lg shadow-lg" style="height:250px">
                    <a href="gallery.php">
                    <i class="fa fa-image" style="font-size:80px"></i>
                    </a>
                    <h4>GALLERY</h4>
                    <span class="count-photo">
                    <?php
                        $get_id = "SELECT id FROM users WHERE username = '$username'";
                        $response = $db->query($get_id);
                        $data = $response->fetch_assoc();
                        $table_name = "user_".$data['id'];
                        $count_photo = "SELECT count(id) AS total FROM $table_name";
                        $response = $db->query($count_photo);
                        $data = $response->fetch_assoc();
                        echo $data['total']." PHOTOS";
                        $_SESSION['table_name'] = $table_name;
                    ?>
                    </span>
                </div>

                <div class="d-flex mb-5 flex-column justify-content-center align-items-center w-100 bg-white rounded-lg shadow-lg" style="height:250px">
                    <a href="shop.php">
                    <i class="fa fa-shopping-cart" style="font-size:100px"></i>
                    </a>
                    <h4>MEMORY SHOPPING</h4>
                    <span>
                        STARTS FROM <i class="fa fa-inr"></i> 99.00/mo
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("form").submit(function(e){
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "php/upload.php",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
    </script>
</body>
</html>