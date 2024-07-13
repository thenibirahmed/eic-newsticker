<?php 

/** 
Plugin Name: EIC Newsticker
Plugin URI: http://www.eleganceincode.com/
Description: EIC (Elegance In Code) Newsticker is a plugin to display news ticker on your website. Lastest 5 posts will be displayed ann will be linked to their post.
Version: 1.0
Author: Nibir Ahmed
Author URI: http://nibirahmed.com/
License: GPL2,
Text Domain: eic-newsticker
*/

add_shortcode('eic_newsticker', 'eic_newsticker_shortcode');
function eic_newsticker_shortcode($atts, $content = null) { 
    extract(shortcode_atts( array(
        'title' => 'News',
        'title_bg' => 'red',
        'title_color' => 'white',
        'title_font_size' => '20px',
        'title_font_weight' => 'normal',
        'content_bg' => '#eee',
        'content_color' => 'white',
        'content_font_size' => '20px',
        'content_font_weight' => 'normal',
        'dot_bg' => 'red',
        'dot_size' => '18px',
        'dot_radius' => '2px',
    ), $atts, 'eic_newsticker' ));

    ob_start();
    $query = new WP_Query( [ 
        'post_type' => 'post', 
        'posts_per_page' => 5,  
        'orderby' => 'date',
        'order' => 'DESC',
    ] );
    ?>
    <style>
        .ticker-wrapper{
            display: flex; 
            width: 100%;
            align-items: center;
        }
        .ticker-wrapper .left{
            width: 10%; 
            background: <?php echo esc_html($title_bg) ?>; 
            color: <?php echo esc_html($title_color) ?>; 
            font-size: <?php echo esc_html($title_font_size) ?>;
            font-weight: <?php echo esc_html($title_font_weight) ?>;
            padding-left: 10px;
        }
        .ticker-wrapper .right{
            width: 100%;
            background: <?php echo esc_html($content_bg) ?>; 
            color: <?php echo esc_html($content_color) ?>; 
            font-size: <?php echo esc_html($content_font_size) ?>;
            font-weight: <?php echo esc_html($content_font_weight) ?>;
        }
        .ticker-wrapper marquee .single-post{
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .ticker-wrapper marquee{
            display: flex;
            align-items: center;
        }
        marquee .dot{
            width: <?php echo esc_html($dot_size) ?>; 
            height: <?php echo esc_html($dot_size) ?>; 
            background: <?php echo esc_html($dot_bg) ?>; 
            border-radius: <?php echo esc_html($dot_radius) ?>; 
            margin-left: 5px;
            display: inline-block;
            vertical-align: middle;
        }
        marquee a{
            font-size: 20px;
            font-weight: inherit;
            vertical-align: middle;
        }
        @media all and (max-width: 600px){
            .ticker-wrapper .left{
                width: 20%; 
            }
        }
    </style>
    <div class="ticker-wrapper">
        <div class="left">
            <?php echo esc_html($title) ?? _e('News') ?>
        </div>
        <div class="right">
            <div>
                <marquee>
                    <?php while($query->have_posts()): $query->the_post() ?>
                        <div class="dot"></div>
                        <a style="color: <?php echo esc_html($content_color) ?>; text-decoration: none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php endwhile; ?>
                </marquee>
            </div>
        </div>
    </div>
    
<?php 
    wp_reset_query();
    return ob_get_clean();
}

add_action('admin_menu', 'eic_newsticker_menu_page');
function eic_newsticker_menu_page(){
    add_menu_page(__('EIC Newsticker'), __('EIC Newsticker'), 'manage_options', 'eic-newsticker', 'eic_newsticker_menu_page_callback', 'dashicons-format-status', 80);
}

function eic_newsticker_menu_page_callback(){
    ?>
        <div class="wrap">
            <h1><?php _e('EIC Newsticker') ?></h1>
            <p><?php _e('EIC Newsticker is a simple plugin to display news ticker on your website.') ?></p>
            <p><?php _e('Use the shortcode <code>[eic_newsticker]</code> to display the news ticker on your website.') ?></p>
            <p><?php _e('Use the shortcode to customize the news ticker.') ?><br><br>
                <code>
                    [eic_newsticker <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; title="News" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; title_bg="red" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; title_color="white" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; title_font_size="20px" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; title_font_weight="normal" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; content_bg="#eee" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; content_color="white" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; content_font_size="20px" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; content_font_weight="normal" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; dot_bg="red" dot_size="18px" <br>
                        &nbsp;&nbsp;&nbsp;&nbsp; dot_radius="2px" <br>
                    ]
                </code> 
            </p>
            
            
            <h3>------ Default Attributes -------</h3>
            <ul>
                <li>title = News</li>
                <li>title_bg = red</li>
                <li>title_color = white</li>
                <li>title_font_size = 20px</li>
                <li>title_font_weight = normal</li>
                <li>content_bg = #eee</li>
                <li>content_color = white</li>
                <li>content_font_size = 20px</li>
                <li>content_font_weight = normal</li>
                <li>dot_bg = red</li>
                <li>dot_size = 18px</li>
                <li>dot_radius = 2px</li>
            </ul>
        </div>
    <?php
}