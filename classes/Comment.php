<?php
class Comment {
        public static function createComment($commentBody, $postId, $userId) {

                if (strlen($commentBody) > 160 || strlen($commentBody) < 1) {
                        die('Incorrect length!');
                }

                if (!DB::query('SELECT id FROM posts WHERE id=:postid', array(':postid'=>$postId))) {
                        echo 'Invalid post ID';
                } else {
                        DB::query('INSERT INTO comments VALUES (\'\', :comment, :userid, NOW(), :postid)', array(':comment'=>$commentBody, ':userid'=>$userId, ':postid'=>$postId));
                }

        }
}
?>
