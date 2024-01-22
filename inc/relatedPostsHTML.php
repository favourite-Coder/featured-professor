<?php

function relatedPostsHTML($id) {
  $postsAboutThisProf = new WP_Query(array(
    'posts_per_page' => -1,
    'post_type' => 'post',
    'meta_query' => array(
      array(
        'key' => 'featuredprofessor',
        'compare' => '=',
        'value' => $id
      )
    )
  ));

  ob_start();

  if ($postsAboutThisProf->found_posts) { ?>
    <p><?php the_title(); ?> is mentioned in the following posts:</p>
    <ul>
      <?php
      while($postsAboutThisProf->have_posts()) {
        $postsAboutThisProf->the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      <?php }
      ?>
    </ul>
  <?php }

  wp_reset_postdata();
  return ob_get_clean();
}