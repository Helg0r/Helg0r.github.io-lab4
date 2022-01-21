<?php
require "db.php";

$posts_size = 6;
$posts_count = $connection->prepare("SELECT id FROM posts");
$posts_count->execute();
$posts_count = $posts_count->fetchAll();
$posts_count = count($posts_count);

$current_page = (int)($_GET['page']);
$last_item = $posts_count - (($current_page - 1) * $posts_size);
$offset = $posts_count - ($current_page * $posts_size);
if ($offset < 0) {
    $offset = 0;
    $posts_size = $last_item;
}
$posts = $connection->prepare("SELECT * FROM posts LIMIT $posts_size OFFSET $offset");
$posts->execute();
$posts = array_reverse($posts->fetchAll());


foreach ($posts as $post) :
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