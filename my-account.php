<?php
include('./classes/DB.php');
include('./classes/Login.php');
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        die('Not logged in!');
}

if (isset($_POST['uploadprofileimg'])) {

        $image = base64_encode(file_get_contents($_FILES['profileimg']['tmp_name']));

        $options = array('http'=>array(
                'method'=>"POST",
                'header'=>"Authorization: Bearer 813d9b0ee1b108a3383f6bd016dd9260873fa681\n".
                "Content-Type: application/x-www-form-urlencoded",
                'content'=>$image
        ));

        $context = stream_context_create($options);

        $imgurURL = "https://api.imgur.com/3/image";

        if ($_FILES['profileimg']['size'] > 10240000) {
                die('Image too big, must be 10MB or less!');
        }

        $response = file_get_contents($imgurURL, false, $context);
        $response = json_decode($response);
        echo '<pre>';
        print_r($response);
        echo "</pre>";

        DB::query("UPDATE users SET profileimg = :profileimg WHERE id=:userid", array(':profileimg'=>$response->data->link, ':userid'=>$userid));

}
?>
<h1>My Account</h1>
<form action="my-account.php" method="post" enctype="multipart/form-data">
        Upload a profile image:
        <input type="file" name="profileimg">
        <input type="submit" name="uploadprofileimg" value="Upload Image">
</form>
