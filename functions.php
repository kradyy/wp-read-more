<?php
function rm_register_shortcode()
{
    add_shortcode('read-more', 'rm_init');
}

add_action('init', 'rm_register_shortcode');

function rm_init($atts, $content = null)
{
    extract(
        shortcode_atts(
            array(
            'more_text' => __('Läs mer'),
            'less_text' => __('Läs mindre')
            ), $atts
        )
    );

    $rand = mt_srand(microtime() * 100000);
    
    $html = '
        <div class="readmore-div" id="readmore-div' . $rand . '" style="display: none;">' . do_shortcode($content) . '</div>
        <div class="readmore-container">
            <span>
                <a onclick="read_toggle(' . $rand . ', \'' . $more_text . '\', \'' . $less_text . '\'); return false;" class="read-link" id="readmore-link' . $rand . '" href="#">' . $more_text  . '</a>
            </span>
        </div>' . "\n";
 
    return $html;
}

function rm_filter_content($content, $word_limit = 80)
{
    $trimmed_text = wp_trim_words($content, $word_limit, '');

    $part1 = mb_strwidth($content);
    $part2 = mb_strwidth($trimmed_text);

    ob_start();

    if ($part1 != $part2) {
        echo $trimmed_text;
        $clipped_text = mb_strimwidth($content, $part2, $part1 - $part2, '');
        echo do_shortcode('[read-more]' . $clipped_text . '[/read-more]');
    } else {
        echo $content;
    }

    $ret = ob_get_contents();
    ob_end_clean();

    return $ret;
}
?>