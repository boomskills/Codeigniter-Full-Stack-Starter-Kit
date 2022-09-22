<?php foreach ($posts as $post) { ?>
    <h3><a href="<?php echo base_url(sprintf(POST_DETAIL_PATH, $post->post_id, slug($post->title), $post->id)); ?>"><?php echo $post->title; ?></a></h3>
<?php } ?>
