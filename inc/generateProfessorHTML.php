<?php

function generateProfessorHTML($id) {
  $profPost = new WP_Query(array(
    'post_type' => 'professor',
    'p' => $id
  ));

  while($profPost->have_posts()) {
    $profPost->the_post();
    ob_start(); ?>
    <div class="professor-callout">
      <div class="professor-callout__photo" style="background-image: url(<?php the_post_thumbnail_url('professorPortrait') ?>)"></div>
      <div class="professor-callout__text">
        <h5><?php the_title(); ?></h5>
        <p><?php echo wp_trim_words(get_the_content(), 30); ?></p>

        <?php
        $relatedPrograms = get_field('related_programs');
        if ($relatedPrograms) { ?>
          <p>Name teaches:
            <?php foreach($relatedPrograms as $key => $program) {
              echo get_the_title($program);
              if ($key != array_key_last($relatedPrograms) && count($relatedPrograms) > 1) {
                echo ', ';
              }
            } ?>.
          </p>
        <?php }
        ?>

        <p><strong><a href="<?php the_permalink() ?>">Learn more about <?php the_title() ?> &raquo;</a></strong></p>

      </div>
    </div>
    <?php
    wp_reset_postdata();
    return ob_get_clean();
  }
}