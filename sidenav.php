<?php
**
** template for sidenav.php
** for displaying New Posts vs. Related Posts in side navigation
**

   //get primary category id
   $primary_cat_id = get_post_meta($post->ID, '_category_permalink', true);
   //get page id to exclude below, this excludes the current post from showing in "Related"
   $pageID =  $wp_query->post->ID;
?>  

  <!-- switch for title, displays on pages with and without primary category -->
	<h2 class="widgettitle">

<?php 
		//if on home page or page without a primary cat, i.e., pages vs. posts
		if(is_page('home') || ($primary_cat_id == "")){ 
			echo "New ";
		} else {
			echo "Related ";
		} ?>posts</h2>

<div class="related">
		<ul>

<?php
      //Query for related posts
      $args_related = array(
         		'showposts' => 7,
	      		'orderby' => date,
	      		'meta_key' => '_category_permalink',
	      		'meta_value' => $primary_cat_id,
	      		'post__not_in' => array($pageID)
	      		);
      $my_related = new WP_Query($args_related);
      
      // Query for featured posts
	   $args_featured = array(
	      		'meta_key'=>'featured', 
	      		'meta_value'=>'featured',
	      		'showposts' => 8,
	      		'orderby' => date
	      		);
      $my_featured = get_posts($args_featured);
      
      // if on home page or other pages - not posts
      if (is_page('home') || ($primary_cat_id == "")){
      foreach ($my_featured as $post) {
	          setup_postdata($post);
	          $alt_hed = get_post_meta($post->ID,"alt_hed");
	          echo '<li class="clear"><a class="invert writeup" href="';
	          the_permalink();
	          echo '">';
	          echo ($alt_hed) ? "{$alt_hed[0]}" : get_the_title();
	          echo '</a>';
	          echo  '<a class="related_thumb" href="'. get_permalink() .'">'. get_the_post_thumbnail(null, 'small-post-thumbnail', array('title' => ''.get_the_title().'')) .'</a></li>';
	        } // end the for each
       } // end the Home Page conditional for featured posts
     
     // if post has primary category
     if(is_single()) {
    	 if($my_related->have_posts()):
    	 	while($my_related->have_posts()):
    	 		$my_related->the_post();
				$alt_hed = get_post_meta($post->ID,"alt_hed");
	          	echo '<li class="clear"><a class="invert writeup" href="';
	          	the_permalink();
	          	echo '">';
	          	echo ($alt_hed) ? "{$alt_hed[0]}" : get_the_title();
	          	//the_title();
	          	echo '</a>';
	          	echo  '<a class="related_thumb" href="'. get_permalink() .'">'. get_the_post_thumbnail(null, 'small-post-thumbnail', array('title' => ''.get_the_title().'')) .'</a></li>';  
	           	endwhile; //end while have posts
          endif; //end if have posts
        } // end the Related conditional for featured posts
?>
        </ul>
</div> <!-- end .related -->
