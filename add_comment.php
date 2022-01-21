<?php
require 'db.php';
session_start();

$post_id = $_POST['post_id'];
$author_id = $_SESSION['user']['id'];
$text = $_POST['text'];
$author_name = $_SESSION['user']['name'];

$text = htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, 'UTF-8');


$comment = $connection->prepare("INSERT INTO comments (author_id, post_id, text) VALUES (?,?,?)");
$comment->execute([$author_id, $post_id, $text]);
$comment = $comment->fetchAll();

$comment_date = $connection->prepare("SELECT date FROM comments WHERE author_id=? AND post_id=? AND text=?");
$comment_date->execute([$author_id, $post_id, $text]);
$comment_date = $comment_date->fetchAll();
?>
<div class="comment">
    <div class="comment__author"><?= $author_name ?></div>
    <div class="comment__date"><?= $comment_date[0]['date'] ?></div>
    <div class="comment__text"><?= $text ?></div>
</div>