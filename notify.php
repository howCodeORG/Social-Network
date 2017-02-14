<?php
include('./classes/DB.php');
include('./classes/Login.php');

if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        echo 'Not logged in';
}

if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', array(':userid'=>$userid))) {

        $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid', array(':userid'=>$userid));

        foreach($notifications as $n) {
                print_r($n);
        }

}


?>
