<?php 

/** 
Plugin Name: CE Newsticker
Plugin URI: http://www.codecstasy.com/ce-newsticker/
Description: CE Newsticker is a simple plugin to display news ticker on your website.
Version: 1.0
Author: codecstasy
Author URI: http://www.codecstasy.com/
License: GPL2,
Text Domain: ce-newsticker
*/

add_shortcode('ce_newsticker', 'ce_newsticker_shortcode');
function ce_newsticker_shortcode($atts, $content = null) { 
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
    ), $atts, 'ce_newsticker' ));

    ob_start();
    $query = new WP_Query( [ 
        'post_type' => 'post', 
        'posts_per_page' => 5,  
        'orderby' => 'date',
        'order' => 'DESC',
    ] );
    ?>
    <style>
        .ticker-wrapper .left{
            width: 10%; 
            float: left; 
            background: <?php echo $title_bg ?>; 
            color: <?php echo $title_color ?>; 
            font-size: <?php echo $title_font_size ?>;
            font-weight: <?php echo $title_font_weight ?>;
            padding: 8px;
        }
        .ticker-wrapper .right{
            width: 90%; 
            float: left; 
            background: <?php echo $content_bg ?>; 
            color: <?php echo $content_color ?>; 
            font-size: <?php echo $content_font_size ?>;
            font-weight: <?php echo $content_font_weight ?>;
            padding: 5px
        }
        marquee .dot{
            width: <?php echo $dot_size ?>; 
            height: <?php echo $dot_size ?>; 
            background: <?php echo $dot_bg ?>; 
            display: inline-block; 
            border-radius: <?php echo $dot_radius ?>; 
            margin-left: 5px;
        }
        marquee a{
            font-size: 20px;
            font-weight: inherit;
            /* margin-top: -15px; */
        }

        @media all and (max-width: 600px){
            .ticker-wrapper .left{
                width: 20%; 
            }
            .ticker-wrapper .right{
                width: 80%; 
                padding: 8px 0px 4px;
            }
        }
    </style>
    <div class="ticker-wrapper">
        <div class="left">
            <?php echo $title ?? 'News' ?>
        </div>
        <div class="right">
            <div>
                <marquee behavior="" direction="">
                    <?php while($query->have_posts()): $query->the_post() ?>
                        <div class="dot"></div>
                        <a style="color: <?php echo $content_color ?>; text-decoration: none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php endwhile; ?>
                </marquee>
            </div>
        </div>
    </div>
    
<?php 
    wp_reset_query();
    return ob_get_clean();
}

add_action('admin_menu', 'ce_newsticker_menu_page');
function ce_newsticker_menu_page(){
    add_menu_page('CE Newsticker', 'CE Newsticker', 'manage_options', 'ce-newsticker', 'ce_newsticker_menu_page_callback', 'dashicons-format-status', 6);
}

function ce_newsticker_menu_page_callback(){
    ?>
    <div class="wrap">
        <h1>CE Newsticker</h1>
        <p>CE Newsticker is a simple plugin to display news ticker on your website.</p>
        <p>Use the shortcode <code>[ce_newsticker]</code> to display the news ticker on your website.</p>
        <p>Use the shortcode <code>[ce_newsticker title="News" title_bg="red" title_color="white" title_font_size="20px" title_font_weight="normal" content_bg="#eee" content_color="white" content_font_size="20px" content_font_weight="normal" dot_bg="red" dot_size="18px" dot_radius="2px"]</code> to customize the news ticker.</p>
        
        
        <p>------ Default Attributes -------</p>

        <p>title = News</p>
        <p>title_bg = red</p>
        <p>title_color = white</p>
        <p>title_font_size = 20px</p>
        <p>title_font_weight = normal</p>
        <p>content_bg = #eee</p>
        <p>content_color = white</p>
        <p>content_font_size = 20px</p>
        <p>content_font_weight = normal</p>
        <p>dot_bg = red</p>
        <p>dot_size = 18px</p>
        <p>dot_radius = 2px</p>
    </div>
    <?php
}