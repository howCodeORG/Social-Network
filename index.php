<?php
include('./classes/DB.php');
include('./classes/Login.php');
include('./classes/Post.php');
$showTimeline = False;
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $showTimeline = True;
} else {
        echo 'Not logged in';
}

if (isset($_GET['postid'])) {
        Post::likePost($_GET['postid'], $userid);
}

$followingposts = DB::query('SELECT posts.id, posts.body, posts.likes, users.`username` FROM users, posts, followers
WHERE posts.user_id = followers.user_id
AND users.id = posts.user_id
AND follower_id = 1
ORDER BY posts.likes DESC;');

foreach($followingposts as $post) {

        echo $post['body']." ~ ".$post['username'];
        echo "<form action='index.php?postid=".$post['id']."' method='post'>";

        if (!DB::query('SELECT post_id FROM post_likes WHERE post_id=:postid AND user_id=:userid', array(':postid'=>$post['id'], ':userid'=>$userid))) {

        echo "<input type='submit' name='like' value='Like'>";
        } else {
        echo "<input type='submit' name='unlike' value='Unlike'>";
        }
        echo "<span>".$post['likes']." likes</span>
        </form>
        <hr /></br />";


}


?>
