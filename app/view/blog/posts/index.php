<h1>Blog post index</h1>

<?php foreach ($posts as $post): ?>
    <h2><?php echo $post->title; ?></h2>
    <p><?php echo $post->content; ?></p>
<?php endforeach; ?>
