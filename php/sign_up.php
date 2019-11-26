<?php
    require("database.php");
    $fullname = base64_decode($_POST["fullname"]);
    $username = base64_decode($_POST["username"]);
    $password = md5(base64_decode($_POST["password"]));
    // echo $fullname." ".$username." ".$password;
    $pattern = "GA0a!b1|cBdN@efg2hCiH3`jkD#lP4OmM%n^JVo\Q5pRE_<q=)SIK9rs6&tT*uUF,L-(vZ/7w~Wx+8yX>zY";
    $length = strlen($pattern) - 1;
    $i;
    $code = [];
    for($i=0;$i<6;$i++){
        $indexing_number = rand(0, $length);
        $code[] = $pattern[$indexing_number];
    }
    $activation_code = implode($code);

    $store_user = "INSERT INTO users(full_name, username, user_password, activation_code) values('$fullname', '$username', '$password', '$activation_code')";
    if($db->query($store_user)){
        $check_mail = mail($username, "Picdrive activation code", "Thanks for choosing our product. Your activation code is ".$activation_code);
        if($check_mail){
            echo "sending success";
        }
        else{
            echo "sending failed";
        }
    }
    else{
        echo "sign up failed";
    }
?>

<?php

    $db->close();

?>