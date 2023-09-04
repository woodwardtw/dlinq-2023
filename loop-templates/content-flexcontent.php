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
                            $description = $resource['resource_description'];
                            echo "<a href='{$link}'>
                                    <li>
                                        {$title}
                                        <div class='resource-description'>{$description}</div>
                                    </li>
                                </a>";
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
            $accord_title = get_sub_field('accordion_title');
            echo "<div class='row topic-row full-width-row d-flex justify-content-around'>";
            if($accord_title){
                $title_slug = sanitize_title($accord_title);
                echo "<h2 id='{$title_slug}'>{$accord_title}</h2>";
            }
            echo "<div class='accordion' id='accordion-{$index}'>";
            foreach($accordion_parts as $piece){
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
                        <div id='{$slug}-content' class='accordion-collapse collapse hide' aria-labelledby='{$slug}'>
                        <div class='accordion-body'>
                         {$content}
                        </div>
                        </div>
                    </div>
                ";

            }
            echo "</div></div>";
        ?>
        <?php endif?>
        <!--CUSTOM POSTS BY CATEGORY-->
        <?php if( get_row_layout() == 'posts' ):
        $title = 'Learn more';
        if(get_sub_field('title')){
             $title = get_sub_field('title');
        }
        $slug = sanitize_title( $title);
            echo "<div class='row topic-row full-width-row'>
                    <div class='col-md-8 offset-md-2'>
                        <h2 id='{$slug}'>{$title}</h2>
                    </div>
                        ";
         
            $cats = get_sub_field('category');
            $type = get_sub_field('post_type');
            $args = array(
                'category__and' => $cats,
                'post_type' => $type,
                'posts_per_page' => 10,
                'paged' => get_query_var('paged')
            );
            $the_query = new WP_Query( $args );

            // The Loop
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
                // Do Stuff
                $title = get_the_title();
                $url = get_the_permalink();
                if(get_the_content()){
                     $excerpt = wp_trim_words(get_the_content(), 30);
                }
                if(get_field('project_summary')){
                   $excerpt =  wp_trim_words(get_field('project_summary'), 30); 
                }
               
                echo "
                    <div class='col-md-8 offset-md-2'>
                        <div class='post-block'>
                            <a class='post-link stretched-link' href='{$url}'>
                                <h3>{$title}</h3>                           
                                <p>{$excerpt}</p>
                             </a>
                        </div>
                    </div>
                ";
                endwhile;
            endif;

            // Reset Post Data
            wp_reset_postdata();
            echo "</div>";
        ?>
        <?php endif;?>
    <?php endwhile; ?>
<?php endif; ?>