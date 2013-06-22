mywordpress
===========

I have been developing and programming in Wordpress for several years. I reuse a lot of the same code, and thought I would post some here that you might find helpful. Caveat: a lot of this code is hacked from other places, useful resources include http://wordpress.stackexchange.com/, http://codex.wordpress.org/Function_Reference, and http://stackoverflow.com/ 

For multiple side navigation templates, in your "sidebar.php" file:
```php
<?php 
$title = get_the_title();
if ($title == "Title of Page") {
   require_once("new-sidebar-template.php");
} elseif ($title == "Title of other Page") {
   require_once("other-sidebar-template.php");
} else {
   require_once("sidenav-all.php");
}
?>
```

For New Posts vs. Related Posts in side navigation, in my "sidenav-all.php" file:
```php
<?php
   //get primary category id
   $primary_cat_id = get_post_meta($post->ID, '_category_permalink', true);
   //get page id to exclude below, this excludes the current post from showing in "Related"
   $pageID =  $wp_query->post->ID;
?>  
```
```html
	<!-- switch for title, displays on pages with and without primary category -->
	<h2 class="widgettitle">
```
```php
<?php 
		//if on home page or page without a primary cat, i.e., pages vs. posts
		if(is_page('home') || ($primary_cat_id == "")){ 
			echo "New ";
		} else {
			echo "Related ";
		} ?>posts</h2>
```
```html
<div class="related">
		<ul>
```
```php
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
```
```html
        </ul>
	</div> <!-- end .related -->
```
