<?php if( have_rows('content') ): ?>
    <?php while( have_rows('content') ): the_row(); ?>
    <?php $index = get_row_index(); ?>
    <!--SUB TOPIC-->
        <?php if( get_row_layout() == 'sub_topic' ): 
            $title = get_sub_field('sub_topic_title');
            $slug = sanitize_title($title);
            $resources = get_sub_field('resources');
        ?>
            <div class='row topic-row'>
				<div class='col-md-5'>
					<div class='sub-topic'>
                        <?php if (get_sub_field('sub_topic_title')): ?>
						<h2 id='<?php echo $slug;?>'><?php echo $title; ?></h2>
                        <?php endif;?>
						<?php the_sub_field('sub_topic_content'); ?>
					</div>
				</div>
				<div class='col-md-5 offset-md-2'>
                    <?php if($resources):                    
                        echo "<div class='menu-block'>
                        <ul class='resource-links'>";
                        foreach($resources as $resource){
                            $title = $resource['resource_title'];
                            $link = $resource['resource_link'];
                            echo "<li>
                                    <a href='{$link}'>{$title}</a>
                                </li>";
                        }
                        echo "</ul></div>";
                    ?>
                    <?php endif;?>
				</div>
			</div>
        <!--IMAGE LOOP-->            
        <?php elseif( get_row_layout() == 'image' ): 
            $title = get_sub_field('title');
            $slug = sanitize_title($title);
            $content = get_sub_field('content');
            $image = get_sub_field('image');
            $direction = get_sub_field('image_align');
            $order_left = ' order-first ';
            $order_right = ' order-last ';
            if($direction == 'right'){
                $order_left = ' order-last ';
                $order_right = ' order-first ';
            }
            ?>
        <div class='row topic-row'>
				<div class='col-md-5<?php echo $order_left;?>'>    
                    <figure>
                        <?php echo wp_get_attachment_image( $image['ID'], 'large', array('class'=>'img-fluid') ); ?>
                        <figcaption><?php echo $image['caption']; ?></figcaption>
                    </figure>
                </div>
            <div class='col-md-2 order-2'></div>
            <div class='col-md-5 <?php echo $order_right;?>'>
                <?php if($title) :?>
                    <h2 id="<?php echo $slug;?>"><?php echo $title; ?></h2>
                <?php endif;?>
                <?php echo $content; ?>
			</div>
        </div>
        <?php endif; ?>
        <!--full block loop-->
         <?php if( get_row_layout() == 'full_block' ): 
            $title = get_sub_field('title');
            $content = get_sub_field('content');
            $slug = sanitize_title($title);
        ?>
            <div class='row topic-row full-width-row'>
				<div class='col-md-8 offset-md-2'>
                    <?php if($title):?>
                        <h2 id="<?php echo $slug?>"><?php echo $title;?></h2>
                    <?php endif;?>
                    <?php echo $content;?>
                </div>
            </div>
        <?php endif;?>
         <!--person loop-->
         <?php if( get_row_layout() == 'people' ): 
            $persons = get_sub_field('individuals');
        ?>
            <div class='row topic-row full-width-row d-flex justify-content-around'>
				<?php
                //var_dump($persons);
                    foreach($persons as $person){
                        $post_id = $person;
                        $name = get_the_title($post_id);
                        $title = get_field('job_title', $post_id);
                        $img = dlinq_person_thumb_check($post_id, 'medium', 'free-bio-pic');
                        echo "
                        <div class='col-md-4'>
                            <div class='person-block'>
                                {$img}
                                <h2 class='small-name'>{$name}</h2>
                                <div class='title'>{$title}</div>
                            </div>
                        </div>
                        ";
                    }
                ?>
            </div>
        <?php endif;?>
          <!--accordion loop-->
         <?php if( get_row_layout() == 'accordion' ): 
            $accordion_parts = get_sub_field('accordion_parts');
            echo "<div class='accordion accordion-flush' id='accordion-{$index}'>";
            foreach($accordion_parts as $piece){
                //var_dump($piece);
                $title = $piece['title'];
                $slug = sanitize_title($title);
                $content = $piece['content'];
                echo "
                    <div class='accordion-item' id='{$slug}-item'>
                        <h2 class='accordion-header' id='{$slug}'>
                        <button class='accordion-button collapsed' id='{$slug}-button' type='button' data-bs-toggle='collapse' data-bs-target='#{$slug}-content' aria-expanded='false' aria-controls='{$slug}-content'>
                            {$title}
                        </button>
                        </h2>
                        <div id='{$slug}-content' class='accordion-collapse collapse hide' aria-labelledby='{$slug}' >
                        <div class='accordion-body'>
                         {$content}
                        </div>
                        </div>
                    </div>
                ";

            }
            echo "</div>";
        ?>
        <?php endif?>
    <?php endwhile; ?>
<?php endif; ?>