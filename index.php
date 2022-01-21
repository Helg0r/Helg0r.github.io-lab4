<?php
require 'db.php';
session_start();
require 'templates/head.html';
$posts_size = 6;
$posts_count = $connection->prepare("SELECT id FROM posts");
$posts_count->execute();
$posts_count = $posts_count->fetchAll();
$posts_count = count($posts_count);
$offset = $posts_count - $posts_size;
if ($offset < 0) {
    $offset = 0;
    $posts_size = $posts_count - $posts_size;
}
$posts = $connection->prepare("SELECT * FROM posts LIMIT $posts_size OFFSET $offset");
$posts->execute();
$posts = array_reverse($posts->fetchAll());
?>

<body>
    <?php require 'templates/header.php' ?>
    <main class="main">
        <div class="wrapper wrapper_main">
            <div class="main__title">Последние обзоры</div>
            <div class="reviews">
                <?php foreach ($posts as $post) :
                    $author_id = $post['author_id'];
                    $post_author = $connection->prepare("SELECT users.name FROM users WHERE id=?");
                    $post_author->execute([$author_id]);
                    $post_author = $post_author->fetchAll();
                ?>
                    <div class="review">
                        <div class="review__img-block">
                            <img src="posts-img/<?= $post['img'] ?>" alt="" class="review__img">
                        </div>
                        <a href="review.php?id=<?= $post['id'] ?>" class="review__title"><?= $post['name'] ?></a>
                        <div class="review__author"><?= $post_author[0]['name'] ?></div>
                        <div class="review__date"><?= $post['date'] ?></div>
                        <a href="review.php?id=<?= $post['id'] ?>" class="review__link">Подробнее</a>
                    </div>
                <?php endforeach; ?>
            </div>
            <button id="ajax_loader_button" class="ajax-loader-button" data-page="1" data-page-max="<?= ceil($posts_count / $posts_size) ?>">Загрузить ещё</button>
        </div>
    </main>
    <?php require 'templates/footer.html' ?>
    <?php require 'templates/forms.html' ?>
    <script src="js/forms.js"></script>
    <script src="js/ajax.js"></script>
</body>

</html>