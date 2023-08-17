<?php if( have_rows('content') ): ?>
    <?php while( have_rows('content') ): the_row(); ?>
        <?php if( get_row_layout() == 'sub_topic' ): 
            $title = get_sub_field('sub_topic_title');
            $slug = sanitize_title($title);
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
				</div>
			</div>            
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
                <h2 id="<?php echo $slug;?>"><?php echo $title; ?></h2>
                <?php echo $content; ?>
			</div>
        </div>
        <?php endif; ?>
    <?php endwhile; ?>
<?php endif; ?>