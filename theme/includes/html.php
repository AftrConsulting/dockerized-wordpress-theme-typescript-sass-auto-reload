<?php

/**
 * Returns if is dev environement.
 */
function is_dev() {
	return in_array($_SERVER['HTTP_HOST'], [ 'localhost', '127.0.0.1', 'localhost:8181' ]);
}

/**
 * Returns the head of the application.
 */
function get_head() { ?>
    <meta charset="<?php bloginfo('charset');?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php get_analytics(); ?>
    <?php if (is_singular() && pings_open(get_queried_object())): ?>
      <link rel="pingback" href="<?php bloginfo('pingback_url');?>">
    <?php endif;?>
    <script type='application/ld+json'><?php include(dirname(__FILE__) . '/../data/local.json'); ?></script>
    <?php if (is_dev()): ?>
        <script src="http://0.0.0.0:9000/main.js"></script>
        <link rel="stylesheet" type="text/css" href="http://0.0.0.0:9000/main.css" />
    <?php else: ?>
        <script src='<?=(get_template_directory_uri() . "/dist/main.js?ver=" . filemtime(dirname(__FILE__) . '/../dist/main.js'));?>' async></script>
        <style><?php include(dirname(__FILE__) . '/../dist/main.css'); ?></style>
    <?php endif;?>
    <?php wp_head();
}

/**
 * Returns the analytics of the application.
 */
function get_analytics() {
    if(is_dev() || current_user_can('administrator')) return;

    ?>
        <script>
            (function(w, d, s, l, i) {
                w[l] = w[l] || [];
                w[l].push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });
                var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s),
                    dl = l != 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '{CODE}');
        </script>
    <?php
}