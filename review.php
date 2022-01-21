<?php
require 'db.php';
session_start();
require 'templates/head.html';

$post_id = $_GET['id'];

$post = $connection->prepare("SELECT * FROM posts WHERE id=?");
$post->execute([$post_id]);
$post = $post->fetchAll();
$post = $post[0];

$post_author_id = $post['author_id'];
$post_author = $connection->prepare("SELECT users.name FROM users WHERE id=?");
$post_author->execute([$post_author_id]);
$post_author = $post_author->fetchAll();

$comments = $connection->prepare("SELECT * FROM comments WHERE post_id=?");
$comments->execute([$post_id]);
$comments = $comments->fetchAll();
$comments = array_reverse($comments);
?>

<head>
    <link rel="stylesheet" href="css/review.css">
</head>

<body>
    <?php require 'templates/header.php' ?>
    <main class="main">
        <div class="wrapper wrapper_main">
            <div class="img-block">
                <img src="posts-img/<?= $post['img'] ?>" alt="" class="img-block__img">
            </div>
            <div class="name"><?= $post['name'] ?></div>
            <div class="trailer">
                <div class="trailer__title">Трейлер фильма</div>
                <iframe class="trailer__video" src="<?= $post['trailer_url'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
            <div class="author">Автор: <?= $post_author[0]['name'] ?></div>
            <div class="date">Дата публикации: <?= $post['date'] ?></div>
            <p class="review-text"><?= $post['review'] ?></p>
            <div class="comments">
                <?php if ($_SESSION['user']['id'] != "") : ?>
                    <form action="POST" class="add-comment-form" id="add-comment-form" data-post="<?= $_GET['id'] ?>">
                        <div class="add-comment-form__title">Добавить комментарий</div>
                        <textarea name="text" id="add-comment-form__text" maxlength="255" rows="20" required placeholder="Текст комментария" class="add-comment-form__text"></textarea>
                        <input id="add-comment-form__submit" class="add-comment-form__submit" type="submit" value="Опубликовать комментарий">
                    </form>
                <?php else : ?>
                    <div class="comments__auth-title">Для возможности комментирования, необходимо авторизироваться</div>
                <?php endif; ?>
                <div class="comments__title" id="comments__title">Комментарии:</div>
                <?php foreach ($comments as $comment) :
                    $comment_author_id = $comment['author_id'];
                    $comment_author = $connection->prepare("SELECT users.name FROM users WHERE id=?");
                    $comment_author->execute([$comment_author_id]);
                    $comment_author = $comment_author->fetchAll();
                    $comment_author = $comment_author[0];
                ?>
                    <div class="comment">
                        <div class="comment__author"><?= $comment_author['name'] ?></div>
                        <div class="comment__date"><?= $comment['date'] ?></div>
                        <div class="comment__text"><?= $comment['text'] ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php require 'templates/footer.html' ?>
    <?php require 'templates/forms.html' ?>
    <script src="js/forms.js"></script>
    <script src="js/add_comment.js"></script>
</body>

</html>