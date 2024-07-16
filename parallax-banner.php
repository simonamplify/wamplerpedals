<?php 


// echo get_stylesheet_directory_uri() . '/parallax-banner.html';
// require_once(get_stylesheet_directory_uri() . '/parallax-banner.html');

echo '
<div class="fpParallax">
    <picture class="parallaxBg">
        <source media="(min-width: 1081px)"
            srcset="
                /wp-content/uploads/2024/03/parallax-ls.jpg 1920w,
                /wp-content/uploads/2024/03/parallax-ls-1536x864.jpg 1536w,
                /wp-content/uploads/2024/03/parallax-ls-1280x720.jpg 1280w
            "
            width="1920"
            height="1080"
        />
        <source media="(max-width: 1080px)"
            srcset="
                /wp-content/uploads/2024/03/parallax-pt.jpg 1080w,
                /wp-content/uploads/2024/03/parallax-pt-980x1120.jpg 980w,
                /wp-content/uploads/2024/03/parallax-pt-768x878.jpg 768w,
                /wp-content/uploads/2024/03/parallax-pt-480x548.jpg 480w
            "
            width="1080"
            height="1234"
        />
        <img 
            alt="Parallax Background"
            src="/wp-content/uploads/2024/03/parallax-ls.jpg"
            width="1920"
            height="1080" 
        />
    </picture>
    <picture class="parallaxBg">
        <source media="(min-width: 1081px)"
            srcset="
                /wp-content/uploads/2024/03/parallax-ls-reveal.jpg 1920w,
                /wp-content/uploads/2024/03/parallax-ls-reveal-1536x864.jpg 1536w,
                /wp-content/uploads/2024/03/parallax-ls-reveal-1280x720.jpg 1280w
            "
            width="1920"
            height="1080"
        />
        <source media="(max-width: 1080px)"
            srcset="
                /wp-content/uploads/2024/03/parallax-pt-reveal.jpg 1080w,
                /wp-content/uploads/2024/03/parallax-pt-reveal-980x1120.jpg 980w,
                /wp-content/uploads/2024/03/parallax-pt-reveal-768x878.jpg 768w,
                /wp-content/uploads/2024/03/parallax-pt-reveal-480x548.jpg 480w
            "
            width="1080"
            height="1234"
        />
        <img 
            alt="Parallax Background"
            src="/wp-content/uploads/2024/03/parallax-ls-reveal.jpg"
            width="1920"
            height="1080" 
            class="reveal"
        />
    </picture>
    <div class="product">
        <img 
        alt="Ego 76"
        src="/wp-content/uploads/2024/06/mofetta-top.png"
        srcset="
            /wp-content/uploads/2024/06/mofetta-top.png 720w,
            /wp-content/uploads/2024/06/mofetta-top-480x480.png 480w,
            /wp-content/uploads/2024/06/mofetta-top-100x100.png 100w
        "
        width="720"
        height="720"
        class="paraProduct"
    />
    </div>
    <div class="shape bg3"></div>
    <div class="shape bg2"></div>
    <div class="shape bg1"></div>
    <div class="hero heroHeader">
        <div class="wrapper">
            <h1>Wampler EGO 76</h1>
          	<p>Brian Wampler\'s take on FET style studio compression doesn\'t just squash your signal - it enhances it.</p>
            <div class="et_pb_button_module_wrapper et_pb_module">
                <a class="et_pb_button et_pb_bg_layout_light" href="/products/distortion-overdrive/mofetta/">Find out more</a>
            </div>
        </div>
    </div>
</div>
';

?>