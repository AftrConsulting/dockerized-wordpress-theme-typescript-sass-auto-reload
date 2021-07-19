<?php

/**
 * Returns the images.
 * @param $params.
 */
function get_image(array $params): void {
    if (!isset($params['imageId']) || $params['imageId'] === 0) return;

    $imageId = $params['imageId'];
    $title   = $params['title'] ?? '';
    $class   = $params['class'] ?? '';
    $size    = $params['size'] ?? 'full';

    $image   = wp_get_attachment_image_src($imageId, $size);
    $alt     = esc_html(get_post_meta($imageId, '_wp_attachment_image_alt', true));
    $src     = $image[0];
    $width   = (int) $image[1];
    $height  = (int) $image[2];
    $ratio   = get_image_ratio($width, $height);
    $webp    = get_webp_from_url($src);

    ?>
        <div data-src='<?=$src;?>' data-src-webp='<?=$webp;?>' data-alt='<?=$alt;?>' title='<?=$title;?>' class='<?=$class;?> img'></div>
    <?php
}

/**
 * Returns the images from src.
 * @param $params.
 */
function get_image_from_url(array $params): void {
    if (!isset($params['src']) || $params['src'] === 0) return;

    $src   = $params['src'];
    $title = $params['title'] ?? '';
    $class = $params['class'] ?? '';

    $alt   = $params['alt'] ?? '';
    $webp  = get_webp_from_url($src);

    ?>
        <div data-src='<?=$src;?>' data-src-webp='<?=$webp;?>' data-alt='<?=$alt;?>' title='<?=$title;?>' class='<?=$class;?> img'></div>
    <?php
}

/**
 * Returns the webp from a url.
 * @param {string} $src - The src
 */
function get_webp_from_url(string $src): string {
    $webp = '';

    if ($src) {
        $uploads = wp_get_upload_dir();
        $path = str_replace($uploads['baseurl'], $uploads['basedir'], $src);
        $path = substr_replace($path , 'webp', strrpos($path , '.') + 1);

        if (file_exists($path)) {
            $webp = substr_replace($src , 'webp', strrpos($src , '.') + 1);
        }
    }

    return $webp;
}

/**
 * Returns the image ratio.
 * @param $width
 * @param $height
 */
function get_image_ratio(int $width, int $height): string {
    return $width / $height * 100 . '%';
}

/** ==================================================================================================
 * Get the content with images
 */
function get_the_content_images($content) {
    preg_match_all('/<img[^>]+>/i',$content, $result); 
  
    $newContent = preg_replace_callback('/<img[^>]+>/i', function($matches) {
        $metadata = ((array)simplexml_load_string($matches[0]))["@attributes"];

        $class    = $metadata['class'];
        $src      = $metadata['src'];
        $width    = $metadata['width'];
        $height   = $metadata['height'];
        $alt      = esc_html($metadata['alt']);
        $webp     = get_webp_from_url($src);
        $ratio    = $height / ($width / 100);

        ob_start();

        ?>
            <div class="<?=$class;?>">
                <div style="max-width:<?=$width;?>px" class='articleImgContainerContainer'>
                    <div class='articleImgContainer' style="width:100%;padding-top:<?=$ratio;?>%">
                        <div>
                            <div data-src='<?=$src;?>' data-src-webp='<?=$webp;?>' data-alt='<?=$alt;?>' class="img"></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php

        return ob_get_clean();
    }, $content);

    return $newContent;
}