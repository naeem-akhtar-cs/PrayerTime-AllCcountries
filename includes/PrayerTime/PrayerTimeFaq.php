<?php

function prayerTimeFaq($country, $cityname, $method)
{
    $accessExternalResource = new AccessExternalResource();
    $response = $accessExternalResource->getPrayerTime($country, $cityname, $method);
    $currentDay = $accessExternalResource->getCurrentTime($response['data'][0]["meta"]["timezone"]);

    list($month, $day, $year) = explode("/", date("m/d/Y"));

    if ($currentDay != null) {
        $day = $currentDay;
    }

    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Fajr"], $matches1);
    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Sunrise"], $matches2);
    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Dhuhr"], $matches3);
    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Asr"], $matches4);
    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Maghrib"], $matches5);
    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Isha"], $matches6);
    preg_match('/[0-9][0-9]:[0-5][0-9]/', $response['data'][(int) $day - 1]["timings"]["Midnight"], $matches7);

    $dayTimes = [
        "fajar" => date("h:i A", strtotime($matches1[0])),
        "sunrise" => date("h:i A", strtotime($matches2[0])),
        "dhuhr" => date("h:i A", strtotime($matches3[0])),
        "asr" => date("h:i A", strtotime($matches4[0])),
        "maghrib" => date("h:i A", strtotime($matches5[0])),
        "isha" => date("h:i A", strtotime($matches6[0])),
        "midnight" => date("h:i A", strtotime($matches7[0])),
    ];

    $prayerTimeFaq = "";
    $prayerTimeFaq .= "<h4>1. What is Fajr time in {$cityname}?</h4>";
    $prayerTimeFaq .= "<p>Fajr time in {$cityname} starts at " . $dayTimes["fajar"] . " and ends at sunrise at " . $dayTimes["sunrise"] . ". Fajr has total of 4 rakats: 2 sunnah and 2 Farz.</p>";

    $prayerTimeFaq .= "<h4>2. What is Dhuhr (Zuhr) time in {$cityname}?</h4>";
    $prayerTimeFaq .= "<p>Dhuhr (Zuhr) time in {$cityname} starts at " . $dayTimes["dhuhr"] . " and ends at " . $dayTimes["asr"] . " just before Asr. It has 12 rakats: 4 Sunnah, 4 Farz, 2 Sunnah, and 2 Nafl.</p>";

    $prayerTimeFaq .= "<h4>3. What is Asr time in {$cityname}?</h4>";
    $prayerTimeFaq .= "<p>Asr time in {$cityname} starts at " . $dayTimes["asr"] . " and ends at " . $dayTimes["maghrib"] . ". Asr has a total of 8 rakats: 4 Sunnah and 4 Nafl.</p>";

    $prayerTimeFaq .= "<h4>4. What is Maghrib time in {$cityname}?</h4>";
    $prayerTimeFaq .= "<p>Maghrib time in {$cityname} starts at " . $dayTimes["maghrib"] . " and ends at " . $dayTimes["isha"] . ". Maghrib has a total of 7 rakats: 3 Farz, 2 Sunnah, and 2 Nafl. </p>";

    $prayerTimeFaq .= "<h4>5. What is Isha time in {$cityname}?</h4>";
    $prayerTimeFaq .= "<p>Isha time in {$cityname} starts at " . $dayTimes["isha"] . " and ends at " . $dayTimes["midnight"] . ". Isha has total of 17 rakats: 4 Sunnah, 4 Fard, 2 Sunnah, 2 Nafl, 3 Witr, and 2 Nafl.</p>";

    return $prayerTimeFaq;
}
