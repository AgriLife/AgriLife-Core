<?php
/**
 * Template Name: Flexible Columns
 */

add_action( 'genesis_entry_content', 'fc_repeating_content' );
function fc_repeating_content()
{
  if ( get_field( 'rows' ) && have_rows( 'rows' ) ) { ?>
    <div class="rows"><?php

    $layout = get_post_meta(get_the_ID())['_genesis_layout'][0];

    while( have_rows( 'rows' ) ): the_row();

      ?><div class="row"><?php
      $subfield = get_sub_field( 'content' );
      $type = gettype( $subfield );
      if( $type == 'string' ){

        // Full Width
        ?><div class="small-12 medium-12 large-12 columns"><?php
        echo $subfield;
        ?></div><?php

      } else if( $type == 'array' ){

        // Columns
        $count = count( $subfield );
        $cols = (12 - 12 % $count) / $count;

        // Determine proper image URL based on expected width of columns
        if( $layout == 'full-width-content' ){
          // 2-column, 500px wide
          // 3-column, 304px wide
          $imgsize = 'medium_large';
        } else {
          // 2-column, 334px wide
          // 3-column, 213px wide
          $imgsize = $cols == 2 ? 'medium_large' : 'medium';
        }

        foreach( $subfield as $cell ){
          $heading = $cell['heading'];
          $img = $cell['image'];
          $desc = $cell['description'];
          $link = $cell['link'];

          if( $heading != '' ){
            if( $link != '' )
              $heading = "<a href=\"{$link}\">{$heading}</a>";
            $heading = "<h4>{$heading}</h4>";
          }

          if( $img != '' ){
            $url = $img['sizes'][$imgsize];
            $img = "<img src=\"{$url}\" title=\"{$img['title']}\" alt=\"{$img['alt']}\"/>";
            if( $link != '' )
              $img = "<a href=\"{$link}\">{$img}</a>";
            $img = "<p>" . $img . "</p>";
          }

          echo "<div class=\"small-12 medium-{$cols} large-{$cols} columns\">{$heading}{$img}{$desc}</div>";

        }

      }

      ?></div><?php

    endwhile; ?>
    </div><?php
  }
}

genesis();
