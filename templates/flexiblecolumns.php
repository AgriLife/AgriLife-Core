<?php
/**
 * Template Name: Flexible Columns
 */


if ( !get_field( 'show_page_title' ) ){
  remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

// Queue styles
add_action( 'wp_enqueue_scripts', 'fc_register_styles' );
add_action( 'wp_enqueue_scripts', 'fc_enqueue_styles' );

// Queue JavaScript as needed
if(array_key_exists('rows', get_fields())){
  $rowtypes = array();

  foreach( get_fields()['rows'] as $field ){
    $rowtypes[] = $field['acf_fc_layout'];
  }
  if( in_array('publications', $rowtypes) ){

    add_action( 'wp_enqueue_scripts', 'fc_register_lightboxjs' );
    add_action( 'wp_footer', 'fc_enqueue_lightboxjs' );

  }
  if( in_array('accordion', $rowtypes) ){

    add_action( 'wp_enqueue_scripts', 'fc_register_accordionjs' );
    add_action( 'wp_footer', 'fc_enqueue_accordionjs' );

  }
}

// Register asset functions
function fc_register_styles() {

  wp_register_style(
    'flexible-column-styles',
    AG_CORE_DIR_URL . 'css/flexiblecolumns.css',
    array(),
    '',
    'screen'
  );

}

function fc_enqueue_styles(){

  wp_enqueue_style( 'flexible-column-styles' );

}

function fc_register_lightboxjs() {

  wp_register_script( 'fc_template_lightbox_script',
    AG_CORE_DIR_URL . 'js/flexiblecolumns_lightbox.js',
    false,
    true
  );

}

function fc_enqueue_lightboxjs() {

  wp_enqueue_script( 'fc_template_lightbox_script' );

}

function fc_register_accordionjs() {

  wp_register_script( 'fc_template_accordion_script',
    AG_CORE_DIR_URL . 'js/flexiblecolumns_accordion.js',
    false,
    true
  );

}

function fc_enqueue_accordionjs() {

  wp_enqueue_script( 'fc_template_accordion_script' );

}

// Display content
add_action( 'genesis_entry_content', 'fc_repeating_content' );

function fc_repeating_content()
{

  if ( get_field( 'rows' ) && have_rows( 'rows' ) ) { ?>
    <div class="rows"><?php

    while( have_rows( 'rows' ) ): the_row();
      $row = get_row();
      $rowname = $row['acf_fc_layout'];
      $rowclass = 'flexiblecolumns row';
      if( $rowname == 'buttons' )
        $rowclass .= ' collapse';

      // Create the row wrapper
      $content = sprintf('<div class="%s"', $rowclass);

      // Additional row HTML attributes
      if( $rowname == 'columns' && ( !array_key_exists( 'field_59107c430b640', $row ) || strpos( $row['field_59107c430b640'], 'summary' ) !== false ) ){

        $text_align_field = get_sub_field('type') != 'cells_summary' ? 'text_alignment' : 'cells_text_alignment';

        $content .= sprintf( ' style="text-align: %s;"', get_sub_field( $text_align_field ) );

      } else if( $rowname == 'buttons' ){

        $content .= sprintf( ' style="text-align: %s; font-size: %srem;"', get_sub_field('text_alignment'), get_sub_field('font_size') );

      }

      $content .= '>';

      // Output content based on row type
      if( $rowname == 'contact_info' ){

        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns"><p class="vcard"><span class="fn">%s</span><br><a href="mailto:%s" class="email">%s</a><br><span class="tel">%s</span></p></div>', get_sub_field('name'), get_sub_field('email'), get_sub_field('email'), get_sub_field('phone') );

      } else if( $rowname == 'buttons' ){

        $subfield = get_sub_field( 'content' );
        $count = count( $subfield );
        $cols = (12 - 12 % $count) / $count;

        foreach( $subfield as $button ){

          $color = '';
          if( array_key_exists('color', $button) && $button['color'] != 'default'){
            $color = $button['color'] . '-button ';
          }

          $content .= sprintf( '<div class="small-12 medium-%s large-%s columns"><a class="button %sfc-button" style="%s" href="%s">%s</a></div>', $cols, $cols, $color, 'max-width:100%;', $button['link'], $button['text'] );

        }

        $content .= '<script type="text/javascript">' . file_get_contents(AG_CORE_DIR_PATH . 'js/flexiblecolumns_buttons.js') . '</script>';

      } else if( $rowname == 'full_width' ){

        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns">%s</div>',
          get_sub_field('content')
        );

      } else if( $rowname == 'columns' ){

        // Get the type of content to render, if present
        $columntype = get_sub_field('type');

        // Get number of columns
        $countname = 'count';
        if( $columntype && ( $columntype == 'cells_summary' || $columntype == 'cells_full' ) )
          $countname = 'cells_per_row';

        $count = (int)get_sub_field( $countname );

        // Add the row title
        $title = get_sub_field( 'columns_title' );
        if ( $title ){
          $content .= '<div class="small-12 medium-12 large-12 columns"><h2>' . $title . '</h2></div></div><div class="flexiblecolumns row">';
        }

        // Get the type of content to render

        if( $columntype == 'full' ){

          // Full content in two columns
          $leftcol = (int)get_sub_field('column_widths');
          $content .= sprintf( '<div class="small-12 medium-%s large-%s columns">%s</div>', $leftcol, $leftcol, get_sub_field('column_one') );
          $content .= sprintf( '<div class="small-12 medium-%s large-%s columns">%s</div>', 12 - $leftcol, 12 - $leftcol, get_sub_field('column_two') );

        } else if( $columntype == 'cells_summary' ){

          // Cells addon, summaries
          $content .= '<div>';

          foreach(get_sub_field('cells_content') as $key=>$cell){

            $cellindex = $key%$count;
            $cellsinrow = get_sub_field('cells_per_row');
            $cols = $cellsinrow == 2 ? get_sub_field('cells_widths') : 4;
            if($cellsinrow == 2 && $cellindex == 1)
              $cols = 12 - $cols;

            $heading = $cell['heading'];
            $img = $cell['image_'.$cellsinrow.'col'];
            $desc = $cell['description'];
            $link = $cell['link'];
            $linkopen = $linkclose = '';

            // Initialize new row
            if( $key > 0 && $cellindex == 0 ){
              // first cell of new row
              $content .= sprintf('<script type="text/javascript">%s</script></div><div>',
                file_get_contents(AG_CORE_DIR_PATH . 'js/flexiblecolumns_headings.js')
              );
            }

            if( $link != '' ){
              $linkopen = '<a href="' . $link . '" style="display:block">';
              $linkclose = '</a>';
            }

            if( $heading != '' ){
              $heading = '<h3 class="summary-heading"><span>' . $heading . '</span></h3>';
            }

            if( $img != '' ){
              $sizename = 'template-flexcolumns-' . $count;
              $img = sprintf( '<img src="%s" alt="%s"/>', $img['sizes'][$sizename], $img['alt'] );
              if( $link != '' )
                $linkopen = str_replace('<a ', '<a class="flexible-columns-image-link" ', $linkopen);
              if( $desc != '' )
                $linkclose .= '<br>';
            }

            $content .= sprintf( '<div class="small-12 medium-%s large-%s columns summary">%s%s%s%s%s</div>', $cols, $cols, $linkopen, $heading, $img, $linkclose, $desc );
          }

          $content .= '</div>';

        } else if( $columntype == 'cells_full' ){

          // Cells addon, full wysiwyg
          $content .= '<div>';

          foreach(get_sub_field('cells_content') as $key=>$cell){

            $cellindex = $key%$count;
            $cellsinrow = get_sub_field('cells_per_row');
            $cols = $cellsinrow == 2 ? get_sub_field('cells_widths') : 4;
            if($cellsinrow == 2 && $cellindex == 1)
              $cols = 12 - $cols;

            // Initialize new row
            if( $key > 0 && $cellindex == 0 ){
              // first cell of new row
              $content .= '</div><div>';
            }

            $content .= sprintf( '<div class="small-12 medium-%s large-%s columns summary">%s</div>', $cols, $cols, $cell['cell'] );
          }

          $content .= '</div>';

        } else {

          // Summarized content with headings, images, and/or descriptions
          $headings = get_sub_field( 'headings' )[0];
          if($count == 6){
            $headings = array_merge( $headings, get_sub_field( 'headings_456' )[0] );
          }
          $descriptions = get_sub_field( 'descriptions' )[0];
          if($count == 6){
            $descriptions = array_merge( $descriptions, get_sub_field( 'descriptions_456' )[0] );
          }
          $links = get_sub_field( 'links' )[0];
          if($count == 6){
            $links = array_merge( $links, get_sub_field( 'links_456' )[0] );
          }
          $image_sub_field = get_sub_field( 'images' )[0];
          if($count == 6){
            $image_sub_field = array_merge( $image_sub_field, get_sub_field( 'images_456' )[0] );
          }
          $images = array();

          // Remove unused fields
          if($image_sub_field){
            if($count == 2){
              $images['image1of2'] = $image_sub_field['image1of2'];
              $images['image2of2'] = $image_sub_field['image2of2'];
            } else if($count == 3){
              $images['image1of3'] = $image_sub_field['image1of3'];
              $images['image2of3'] = $image_sub_field['image2of3'];
              $images['image3of3'] = $image_sub_field['image3of3'];
            } else if($count == 6){
              $images['image1of6'] = $image_sub_field['image1of3'];
              $images['image2of6'] = $image_sub_field['image2of3'];
              $images['image3of6'] = $image_sub_field['image3of3'];
              $images['image4of6'] = $image_sub_field['image4of6'];
              $images['image5of6'] = $image_sub_field['image5of6'];
              $images['image6of6'] = $image_sub_field['image6of6'];
            }
          }

          // Arrange values by cell
          $row = array();
          for( $i = 0; $i < $count; $i++ ){
            $row[] = array(
              'heading' => gettype($headings) == 'array' ? array_shift($headings) : '',
              'columnimage' => gettype($images) == 'array' ? array_shift($images) : '',
              'description' => gettype($descriptions) == 'array' ? array_shift($descriptions) : '',
              'link' => gettype($links) == 'array' ? array_shift($links) : ''
            );
          }

          // Determine the number of Foundation columns per cell
          $cols = (12 - 12 % $count) / $count;

          // Add each cell's content to output
          foreach( $row as $cell ){

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
              $heading = '<h3 class="summary-heading"><span>' . $heading . '</span></h3>';
            }

            if( $img != '' ){
              $sizename = $count !== 6 ? 'template-flexcolumns-' . $count : 'template-flexcolumns-3';
              $img = sprintf( '<img src="%s" alt="%s"/>', $img['sizes'][$sizename], $img['alt'] );
              if( $link != '' )
                $linkopen = str_replace('<a ', '<a class="flexible-columns-image-link" ', $linkopen);
              if( $desc != '' )
                $linkclose .= '<br>';
            }

            $content .= sprintf( '<div class="small-12 medium-%s large-%s columns summary">%s%s%s%s%s</div>', $cols, $cols, $linkopen, $heading, $img, $linkclose, $desc );

          }

          // Add script that sets equal height for column titls
          $content .= '<script type="text/javascript">' . file_get_contents(AG_CORE_DIR_PATH . 'js/flexiblecolumns_headings.js') . '</script>';

        }

      } else if( $rowname == 'accordion' ){

        $title = preg_replace( '/<(\/)?p>/', '<$1span>', get_sub_field( 'accordion_title' ) );
        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns af-accordion"><a class="accordion-title" href="#" style="display: block;">%s</a><div class="accordion-content">%s</div></div>', $title, get_sub_field( 'accordion_content') );

      } else if( $rowname == 'publications' ){

        // Add top content
        $title = get_sub_field( 'publications_title' );
        $description = get_sub_field( 'publications_description' );

        $content .= sprintf( '<div class="small-12 medium-12 large-12 columns"><h2>%s</h2><p>%s</p></div>',
          $title, $description );

        // Add publications
        $content .= '<div class="small-12 medium-12 large-12 columns publications"><ul>';

        while( has_sub_field('publications') ){

          $title = get_sub_field( 'publication_title' );
          $description = get_sub_field( 'publication_description' );
          $overlay = get_sub_field( 'publication_overlay' );
          $content .= sprintf( '<li><a class="open" href="javascript:;"><span class="title">%s</span><br /><span class="description">%s</span></a><div class="overlay"><a class="close" href="javascript:;" aria-label="Close"><span aria-hidden="true">×</span></a><div class="wrap"><div class="inner">%s</div><a class="close" href="javascript:;" aria-label="Close"><span aria-hidden="true">×</span></a></div></div></li>',
            $title, $description, $overlay );

        }

        $content .= '</ul></div>';

      }

      $content .= '</div>';

      echo $content;

      ?><?php

    endwhile; ?>
    </div><?php
  }
}
genesis();
