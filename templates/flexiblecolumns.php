<?php
/**
 * Template Name: Flexible Columns
 */

  
if ( !get_field( 'show_page_title' ) ){
  remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

add_action( 'genesis_entry_content', 'fc_repeating_content' );
function fc_repeating_content()
{

  if ( get_field( 'rows' ) && have_rows( 'rows' ) ) { ?>
    <div class="rows"><?php

    $layout = get_post_meta(get_the_ID())['_genesis_layout'][0];

    while( have_rows( 'rows' ) ): the_row();

      ?><div class="row"><?php

      $rowname = get_row()['acf_fc_layout'];
      $type = gettype( $subfield );

      if( $rowname == 'contact_info' ){

        $content = sprintf( '<div class="small-12 medium-12 large-12 columns"><h3>Contact</h3><p>%s<br>%s<br>%s</p></div>', get_sub_field('name'), get_sub_field('email'), get_sub_field('phone') );

        echo $content;

      } else if( $rowname == 'button' ){

        $content = sprintf( '<div class="small-12 medium-12 large-12 columns"><a class="button" href="%s">%s</a></div>', get_sub_field('link'), get_sub_field('text') );

        echo $content;

      } else if( $rowname == 'full_width' ){

        // Full Width
        ?><div class="small-12 medium-12 large-12 columns"><?php
        echo get_sub_field( 'content' );
        ?></div><?php

      } else if( $rowname == 'columns' ){
        // Columns
        $subfield = get_sub_field( 'content' );
        $count = count( $subfield );
        $cols = (12 - 12 % $count) / $count;

        foreach( $subfield as $cell ){
          $heading = $cell['heading'];
          $img = $cell['columnimage'];
          $desc = $cell['description'];
          $link = $cell['link'];

          if( $heading != '' ){
            if( $link != '' )
              $heading = "<a href=\"{$link}\">{$heading}</a>";
            $heading = "<h3>{$heading}</h3>";
          }

          if( $img != '' ){
            // if full width content layout
              // if 2 columns, 500px wide
              // if 3 columns, 304px wide
            // else
              // if 2 columns, 334px wide
              // if 3 columns, 213px wide

            $url = $img['sizes']['templateflexiblecolumns'];
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
