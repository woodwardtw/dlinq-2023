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
                            $type = $resource['resource_type'];
                            if(str_contains(strtolower($description), 'coming soon')){
                                $link = "#{$slug}";       
                            }
                            if(array_key_exists('host', parse_url($link))){
                                $url_source = dlinq_remove_www(parse_url($link)["host"]);
                            } else {
                                $url_source = $link;
                            }
                           
                            echo "
                                    <li>                                        
                                        <a href='{$link}'>
                                           <div class='inline'>
                                                <div class='resource-icon {$type}' arial-lable='Icon for {$type}.'></div>
                                           </div>
                                           <div class='inline'>
                                                {$title}
                                                <div class='resource-source'>source: {$url_source}</div>
                                                <div class='resource-description'>{$description} &nbsp;</div>
                                            </div>                                    
                                        </a>
                                    </li>
                                ";
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
        <div class='row topic-row d-flex align-items-center'>
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
            $title = get_sub_field('title');
            $slug = sanitize_title($title);
        ?>
            <div class='row topic-row full-width-row d-flex justify-content-around people-row'>
            <?php if($title):?>
                <div class="col-md-12">
                    <h2 id="<?php echo $slug?>"><?php echo $title;?></h2>
                </div>
            <?php endif;?>
				<?php                   
                    foreach($persons as $person){
                        $post_id = $person;
                        $name = get_the_title($post_id);
                        $title = get_field('job_title', $post_id);
                        $img = dlinq_person_thumb_check($post_id, 'portrait', 'free-bio-pic img-fluid');
                        $email_html = '';
                        if(get_field('email', $post_id)){
                            $email = get_field('email', $post_id);
                            $email_html = "<a href='mailto:{$email}' aria-lable='Email to {$name}'>✉️ Connect</a>";
                        }
                        $link = get_permalink( $post_id);
                        echo "
                        <div class='col-md-4 person-holder'>
                            <div class='person-block'>
                                {$img}
                                <a href='{$link}'><h2 class='small-name'>{$name}</h2></a>
                                <div class='title'>{$title}</div>
                                <div class='small-contact'>
                                    {$email_html}
                                </div>
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
                'posts_per_page' => -1,
                'paged' => get_query_var('paged')
            );
            $the_query = new WP_Query( $args );

            // The Loop
            if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
                // Do Stuff
                $title = get_the_title();
                $url = get_the_permalink();
                $html = "";
                if(get_the_content()){
                     $excerpt = wp_trim_words(get_the_content(), 30);
                     $html = "<div class='col-md-8 offset-md-2'>
                        <div class='post-block'>
                            <a class='post-link stretched-link' href='{$url}'>
                                <h3>{$title}</h3>                           
                                <p>{$excerpt}</p>
                             </a>
                        </div>
                    </div>";
                }
                if(get_field('project_summary')){
                   $excerpt =  wp_trim_words(get_field('project_summary'), 30); 
                    $html = "<div class='col-md-8 offset-md-2'>
                        <div class='post-block'>
                            <a class='post-link stretched-link' href='{$url}'>
                                <h3>{$title}</h3>                           
                                <p>{$excerpt}</p>
                             </a>
                        </div>
                    </div>";
                }
                if(get_field('workshop_description')){
                   $excerpt =  wp_trim_words(get_field('workshop_description'), 30); 
                    $html = "<div class='col-md-8 offset-md-2'>
                        <div class='post-block'>
                            <a class='post-link stretched-link' href='{$url}'>
                                <h3>{$title}</h3>                           
                                <p>{$excerpt}</p>
                             </a>
                        </div>
                    </div>";
                }
                if(get_field('prompt')){
                   //$excerpt =  wp_trim_words(get_field('prompt'), 30); 
                   $html = get_template_part( 'loop-templates/content', 'prompt' );
                }
                echo $html;
                endwhile;
            endif;            
            // Reset Post Data
            wp_reset_postdata();
            echo "</div>";
        ?>        
        <?php endif;?>
        <!--challenge loop-->
         <?php if( get_row_layout() == 'challenge' ): 
            $title = get_sub_field('challenge_title');
            $content = get_sub_field('challenge_description');
            $form = get_sub_field('form_id');
            $slug = sanitize_title($title);
        ?>
            <div class='row topic-row full-width-row'>
				<div class='col-md-8 offset-md-2'>
                    <?php if($title):?>
                        <h2 id="<?php echo $slug;?>"><?php echo $title;?></h2>
                    <?php endif;?>
                    <?php echo $content;?>
                    <?php if ($form > 0) {
                        gravity_form($form);//show form
                        dlinq_gf_form_entry_display($form);//show form entries
                        }?>
                </div>
            </div>
        <?php endif;?>
          <!--challenge loop-->
         <?php if( get_row_layout() == 'side_nav' ): 
            $big_group = get_sub_field('big_group');
            //GET BIG GROUP TITLE AND SUB GROUPS
            $big_titles = array();
            $sg_titles = array();
            foreach($big_group as $group){
                $title = $group['big_group_title'];
                $slug = sanitize_title($title);
                $items = $group['sub_group'];
                //get sub group title and content
                array_push($big_titles, $title);//top nav
                foreach($items as $item){
                    $sg_title = $item["sub-group_title"];
                    $sg_content = $item["sub-group_content"];
                    //dlinq_side_nav_sg_builder($sg_title);
                    array_push($sg_titles, $sg_title);
                }  
                var_dump($title);
                var_dump($sg_titles); 
                dlinq_side_nav_sg_builder($title, $sg_titles);
            }
            
        ?>
            <div class='row topic-row full-width-row'>
				<div class='col-md-8 offset-md-2'>
                   sidenav
                </div>
            </div>
        <?php endif;?>
    <?php endwhile; ?>
<?php endif; ?>