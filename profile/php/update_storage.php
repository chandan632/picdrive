<?php
    session_start();
    $username = $_SESSION['username'];
    require("../../php/database.php");
    $plans = $_GET['plans'];
    $storage = $_GET['storage'];
    $purchase_date = date('Y-m-d');

    if($plans == "starter"){
    // get free storage
    $select_sstorage = "SELECT storage FROM users WHERE username = '$username'";
    $response = $db->query($select_sstorage);
    $data = $response->fetch_assoc();

    $final_storage = $data['storage']+$storage;

    // update storage
    $update_storage = "UPDATE users SET plans = '$plans', storage='$final_storage',purchase_date='$purchase_date' WHERE username = '$username'";
    if($db->query($update_storage))
    {
        header("Location:../profile.php");
    }
    else{
        echo "Update failed";
    }
}
else{
    $update_storage = "UPDATE users SET plans = '$plans', storage=0,purchase_date='$purchase_date' WHERE username = '$username'";
    if($db->query($update_storage))
    {
        header("Location:../profile.php");
    }
    else{
        echo "Update failed";
    }
}
?>