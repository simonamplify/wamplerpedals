<?php 
$args = array(
  'post_type'=> 'artist',
  'orderby' => 'title',
  'order'    => 'ASC',
  'posts_per_page' => '1000'
);              

echo '<div class="artistOverlay"></div>';

$artist_query = new WP_Query( $args );

if($artist_query->have_posts() ) : while ( $artist_query->have_posts() ) : $artist_query->the_post();

  echo '<div class="artistModal artist-'; the_ID(); echo '">'; the_title('<h3>', '</h3>'); the_excerpt();
    echo '<a href="#artist-'; the_ID(); echo '" class="closeArtist">Close</a>';
  echo '</div>';

endwhile; else: 

endif; wp_reset_postdata();

echo '<ul class="list artists">';

if($artist_query->have_posts() ) : while ( $artist_query->have_posts() ) : $artist_query->the_post();

  echo '<li class="artist">'; 
  echo '<div class="artistDetails"><h4 class="artistName">'; echo '<a href="#artist-'; the_ID(); echo '" class="bioBtn">'; the_title(); echo '</a>'; echo '</h4>'; echo '<div class="artistContent">'; the_content(); echo '</div>'; echo '</div>'; 
  echo '</li>';

endwhile; else: 

endif; wp_reset_postdata();

echo '</ul>';

?>