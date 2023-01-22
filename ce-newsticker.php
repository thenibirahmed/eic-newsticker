<?php 

/** 
Plugin Name: CE Newsticker
Plugin URI: http://www.codecstasy.com/ce-newsticker/
Description: CE Newsticker is a simple plugin to display news ticker on your website.
Version: 1.0
Author: codecstasy
Author URI: http://www.codecstasy.com/
License: GPL2
*/



add_shortcode('ce_newsticker', 'ce_newsticker_shortcode');
function ce_newsticker_shortcode($atts, $content = null) { 
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
            background: red; 
            color: white; 
            padding: 8px;
        }
        .ticker-wrapper .right{
            width: 90%; 
            float: left; 
            background: #eee; 
            color: white; 
            padding: 5px
        }
        marquee .dot{
            width: 18px; 
            height: 18px; 
            background: red; 
            display: inline-block; 
            border-radius: 2px; 
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
            }
        }
    </style>
    <div class="ticker-wrapper">
        <div class="left">
            শিরনামঃ 
        </div>
        <div class="right">
            <div>
                <marquee behavior="" direction="">
                    <?php while($query->have_posts()): $query->the_post() ?>
                        <div class="dot"></div>
                        <a style="color: black; text-decoration: none" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    <?php endwhile; ?>
                </marquee>
            </div>
        </div>
    </div>
    
<?php }
