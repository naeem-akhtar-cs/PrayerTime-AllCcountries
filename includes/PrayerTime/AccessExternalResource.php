<?php

class AccessExternalResource
{
    public function getPrayerTime($country, $cityname, $method)
    {
        try {
            list($month, $day, $year) = explode("/", date("m/d/Y"));
            $curl = curl_init();

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => "http://api.aladhan.com/v1/calendarByCity?city={$cityname}&country={$country}&method={$method}&month={$month}&year={$year}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                )
            );

            $response = curl_exec($curl);
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            if ($statusCode != 200) {
                return null;
            }
            curl_close($curl);
            $response = json_decode($response, true);
            return $response;
        } catch (\Throwable$th) {
            return null;
        }
    }

    public function getCurrentTime($timeZone)
    {
        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://api.aladhan.com/v1/currentDate?zone={$timeZone}",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $response = json_decode($response, true);

            list($day, $month, $year) = explode("-", $response["data"]);

            return $day;
        } catch (\Throwable$th) {
            return null;
        }
    }
}
