<?php
/**
 * Template Name: Flexible Columns
 */

  
if ( !get_field( 'show_page_title' ) ){
  remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

add_action( 'wp_enqueue_scripts', 'fc_register_js' );
add_action( 'wp_footer', 'fc_enqueue_js' );

function fc_register_js() {

  wp_register_script( 'fc_template_script',
    AG_CORE_DIR_URL . '/js/flexiblecolumns.js',
    false,
    true
  );

}

function fc_enqueue_js() {

  wp_enqueue_script( 'fc_template_script' );

}

add_action( 'genesis_entry_content', 'fc_repeating_content' );

function fc_repeating_content()
{

  if ( get_field( 'rows' ) && have_rows( 'rows' ) ) { ?>
    <div class="rows"><?php

    $layout = get_post_meta(get_the_ID())['_genesis_layout'][0];

    while( have_rows( 'rows' ) ): the_row();

      $rowname = get_row()['acf_fc_layout'];
      $rowclass = $rowname != 'buttons' ? 'row' : 'row collapse';
      $content = sprintf('<div class="%s"', $rowclass);

      if( $rowname == 'columns' ){
        $content .= sprintf( ' style="text-align: %s;"', get_sub_field('text_alignment') );
      } else if( $rowname == 'buttons' ){
        $content .= sprintf( ' style="text-align: %s; font-size: %srem;"', get_sub_field('text_alignment'), get_sub_field('font_size') );
      }

      $content .= '>';

      if( $rowname == 'contact_info' ){

        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns"><p class="vcard"><span class="fn">%s</span><br><a href="mailto:%s" class="email">%s</a><br><span class="tel">%s</span></p></div>', get_sub_field('name'), get_sub_field('email'), get_sub_field('email'), get_sub_field('phone') );

      } else if( $rowname == 'buttons' ){

        $subfield = get_sub_field( 'content' );
        $count = count( $subfield );
        $cols = (12 - 12 % $count) / $count;
        
        foreach( $subfield as $button ){
          $content .= sprintf( '<div class="small-12 medium-%s large-%s columns"><a class="button" style="%s" href="%s">%s</a></div>', $cols, $cols, 'max-width:100%;', $button['link'], $button['text'] );
        }

        $content .= '<script type="text/javascript">' . file_get_contents(AG_CORE_DIR_PATH . 'js/flexiblecolumns_buttons.js') . '</script>';

      } else if( $rowname == 'full_width' ){

        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns">%s</div>', get_sub_field('content') );

      } else if( $rowname == 'columns' ){

        $subfield = get_sub_field( 'content' );
        $count = count( $subfield );
        $cols = (12 - 12 % $count) / $count;

        foreach( $subfield as $cell ){
          $heading = $cell['heading'];
          $img = $cell['columnimage'];
          $desc = $cell['description'];
          $link = $cell['link'];
          $linkopen = $linkclose = '';

          if( $link != '' ){
            $linkopen = '<a href="' . $link . '" style="display:block">';
            $linkclose = '</a>';
          }

          if( $heading != '' ){
            $heading = '<h3><span>' . $heading . '</span></h3>';
          }

          if( $img != '' ){
            $img = sprintf( '<img src="%s" alt="%s"/>', $img['sizes']['templateflexiblecolumns'], $img['alt'] );
            if( $desc != '' )
              $linkclose .= '<br>';
          }

          $content .= sprintf( '<div class="small-12 medium-%s large-%s columns">%s%s%s%s%s</div>', $cols, $cols, $linkopen, $heading, $img, $linkclose, $desc );

        }

        $content .= '<script type="text/javascript">' . file_get_contents(AG_CORE_DIR_PATH . 'js/flexiblecolumns_headings.js') . '</script>';

      } else if( $rowname == 'accordion' ){

        $title = preg_replace( '/<(\/)?p>/', '<$1span>', get_sub_field( 'accordion_title' ) );
        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns af-accordion"><a class="accordion-title" href="#" style="display: block;">%s</a><div class="accordion-content">%s</div></div>', $title, get_sub_field( 'accordion_content') );

      }

      $content .= '</div>';

      echo $content;

      ?><?php

    endwhile; ?>
    </div><?php
  }
}

genesis();
