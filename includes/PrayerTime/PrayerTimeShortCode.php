<?php
require_once __DIR__ . '/PrayerTimeTable.php';

function prayerTimeShortCode($atts = [], $content = null, $tag = '')
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

    $prayerTimeView = prayerTimeTable($defaultValue["country"], $defaultValue["city"], $defaultValue["method"]);
    return $prayerTimeView;
}
