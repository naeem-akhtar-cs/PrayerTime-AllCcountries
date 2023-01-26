<?php
require_once __DIR__ . '/PrayerTimeFaq.php';

function faqParaShortCode($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case((array) $atts, CASE_LOWER);

    $defaultValue = shortcode_atts(
        array(
            'country' => 'PAK',
            'city' => 'Lahore',
            'method' => 4,
        ),
        $atts,
        $tag
    );

    $prayerTimefaq = prayerTimeFaq($defaultValue["country"], $defaultValue["city"], $defaultValue["method"]);
    return $prayerTimefaq;
}
