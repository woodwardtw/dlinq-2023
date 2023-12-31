<div class="row event-row">
  <div class="accordion" id="eventAccordion">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          <span class='event-count'><?php echo $args['count'];?></span> Upcoming <?php if($post->post_type === 'topic') {the_title();}?> event<?php echo $args['plural'];?>
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#eventAccordion">
        <div class="accordion-body">
          <?php 
            echo do_shortcode( '[tribe_events view="summary" tribe-bar="false" category="'. $args['cat'] .'"]', FALSE );
          ?>
        </div>
      </div>
    </div>
  </div>
</div>