<?php
include('./classes/DB.php');
include('./classes/Login.php');

if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
} else {
        echo 'Not logged in';
}
echo "<h1>Notifcations</h1>";
if (DB::query('SELECT * FROM notifications WHERE receiver=:userid', array(':userid'=>$userid))) {

        $notifications = DB::query('SELECT * FROM notifications WHERE receiver=:userid ORDER BY id DESC', array(':userid'=>$userid));

        foreach($notifications as $n) {

                if ($n['type'] == 1) {
                        $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];

                        if ($n['extra'] == "") {
                                echo "You got a notification!<hr />";
                        } else {
                                $extra = json_decode($n['extra']);

                                echo $senderName." mentioned you in a post! - ".$extra->postbody."<hr />";
                        }

                } else if ($n['type'] == 2) {
                        $senderName = DB::query('SELECT username FROM users WHERE id=:senderid', array(':senderid'=>$n['sender']))[0]['username'];
                        echo $senderName." liked your post!<hr />";
                }

        }

}


?>
