<?php
/**
 * Template Name: Landing Page 2
 */

/** Notes:
 * This template relies on two image sizes:
 * 1. Landing Template Slider: 1024 x 576
 *    This size must be set on the Soliloquy Slider's settings page
 * 2. Landing Template Thumbnail: 483 x 272
 *    Uploaded images must be this size or larger.
*/

// Remove post content
remove_action( 'genesis_entry_content', 'genesis_do_post_content' );

add_action( 'genesis_entry_content', 'template_slider' );

add_action( 'genesis_entry_content', 'higher_content' );

add_action( 'genesis_entry_content', 'repeating_content' );

add_action( 'genesis_entry_content', 'lower_content' );

add_action( 'wp_enqueue_scripts', 'register_template_styles' );

add_action( 'wp_enqueue_scripts', 'enqueue_template_styles' );

if ( !get_field('show_heading') ) {
    remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
    remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
}

/**
 * Registers all styles used within the template
 */
function register_template_styles(){
    wp_register_style(
        'landing-template',
        AG_CORE_DIR_URL . 'css/landing-template.css',
        array(),
        '',
        'screen'
    );
}

function enqueue_template_styles(){
    wp_enqueue_style( 'landing-template' );
}

function template_slider()
{
    if ( get_field( 'show_slider' ) && function_exists( 'soliloquy_slider' ) ) {
        $slider_object = get_field( 'select_slider' );
        $slider = $slider_object->post_name;
        soliloquy_slider( $slider );
    }
}

function higher_content()
{
    if ( get_field( 'main_content' ) ) { ?>
        <div class="row higher-content">
            <section id="content" role="main">
                <?php echo get_field( 'main_content' ); ?>
            </section><!-- /end #content -->
        </div>
        <?php
    }
}

function repeating_content()
{
    if ( get_field( 'repeating_content' ) && have_rows( 'repeating_content' ) ) { ?>
        <div class="row repeating-content"><?php
        while( have_rows( 'repeating_content' ) ): the_row();
            $left = array_shift(get_sub_field('left'));
            $right = array_shift(get_sub_field('right'));
            $imgpattern = '/.(jpeg|jpg|png|gif)$/i';
            $imgreplacement = '-483x272.$1'; ?>
            <div class="row">
                <div class="small-12 medium-6 large-6 columns"><?php
                if( $left ){
                    if( $left['image'] ){ ?>
                    <div class="image text-center"><img src="<?php echo preg_replace($imgpattern, $imgreplacement, $left['image']); ?>"></div><?php
                    }
                    if( $right['description'] ){ ?>
                    <div class="description medium-only-text-justify large-only-text-justify"><?php echo $left['description']; ?></div><?php
                    }
                } ?>
                </div>
                <div class="small-12 medium-6 large-6 columns"><?php
                if( $right ){
                    if( $right['image'] ){ ?>
                    <div class="image text-center"><img src="<?php echo preg_replace($imgpattern, $imgreplacement, $right['image']); ?>"></div><?php
                    }
                    if( $right['description'] ){ ?>
                    <div class="description medium-only-text-justify large-only-text-justify"><?php echo $right['description']; ?></div><?php
                    }
                } ?>
                </div>
            </div><?php
        endwhile; ?>
        </div><?php
    }
}

function lower_content(){
    if ( get_field( 'lower_content' ) ) { ?>
        <div class="row lower-content"><?php echo get_field( 'lower_content' ); ?></div><?php
    }
}

genesis();