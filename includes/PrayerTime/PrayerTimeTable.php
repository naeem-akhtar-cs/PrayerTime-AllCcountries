<?php

require_once __DIR__ . '/AccessExternalResource.php';

function getDayTable($data, $tableStyle, $cityname)
{
    $dayTable = "<h3>Today {$cityname} Prayer Times</h3>";
    $dayTable .= "
    <div name='prayerTime'>
      <div name='prayerTimeStyle'>
        <style type='text/css'>
          $tableStyle
    </style>
    </div>
    <div name='prayerTimeTable'>
      <table>
        <tr>
          <td>Fajr</td>
          <td>" . $data["fajar"] . "</td>
        </tr>
        <tr>
          <td>Sunrise</td>
          <td>" . $data["sunrise"] . "</td>
        </tr>
        <tr>
          <td>Dhuhr (Zuhr)</td>
          <td>" . $data["dhuhr"] . "</td>
        </tr>
        <tr>
          <td>Asr</td>
          <td>" . $data["asr"] . "</td>
        </tr>
        <tr>
          <td>Maghrib</td>
          <td>" . $data["maghrib"] . "</td>
        </tr>
        <tr>
          <td>Isha</td>
          <td>" . $data["isha"] . "</td>
        </tr>
      </table>
    </div>
    </div>";

    return $dayTable;
}

function getMonthtableRows($monthTimes)
{
    $monthRows = "<h3>Prayer time of whole month</h3>";

    for ($i = 0; $i < count($monthTimes); $i++) {

        $dayName = date('D', $monthTimes[$i]['date']['timestamp']) . ", " . ($i + 1);

        preg_match('/[0-9][0-9]:[0-5][0-9]/', $monthTimes[$i]["timings"]['Fajr'], $matches);
        $fajar = date("h:i A", strtotime($matches[0]));

        preg_match('/[0-9][0-9]:[0-5][0-9]/', $monthTimes[$i]["timings"]['Sunrise'], $matches);
        $sunrise = date("h:i A", strtotime($matches[0]));

        preg_match('/[0-9][0-9]:[0-5][0-9]/', $monthTimes[$i]["timings"]['Dhuhr'], $matches);
        $dhuhr = date("h:i A", strtotime($matches[0]));

        preg_match('/[0-9][0-9]:[0-5][0-9]/', $monthTimes[$i]["timings"]['Asr'], $matches);
        $asr = date("h:i A", strtotime($matches[0]));

        preg_match('/[0-9][0-9]:[0-5][0-9]/', $monthTimes[$i]["timings"]['Maghrib'], $matches);
        $maghrib = date("h:i A", strtotime($matches[0]));

        preg_match('/[0-9][0-9]:[0-5][0-9]/', $monthTimes[$i]["timings"]['Isha'], $matches);
        $isha = date("h:i A", strtotime($matches[0]));

        $monthRows .= "
        <tr>
          <td>
            $dayName
          </td>
          <td>
            $fajar
          </td>
          <td>
            $sunrise
          </td>
          <td>
            $dhuhr
          </td>
          <td>
            $asr
          </td>
          <td>
            $maghrib
          </td>
          <td>
            $isha
          </td>
        </tr>
        ";
    }
    return $monthRows;
}

function getMonthTable($data, $tableStyle)
{
    $monthRows = getMonthtableRows($data);
    return "
    <div name='prayerTime'>
      <div name='prayerTimeStyle'>
        <style type='text/css'>
          $tableStyle
    </style>
    </div>
    <div id='prayerTimeTable'>
      <table>

      <tr>
          <th>Day</th>
          <th>Fajr</th>
          <th>Sunrise</th>
          <th>Dhuhr</th>
          <th>Asr</th>
          <th>Maghrib</th>
          <th>Isha</th>
      </tr>
      " . $monthRows . "
      </table>
    </div>
    </div>";

}

function getStartingParagraph($data, $cityname, $geogDate, $islamicDate)
{
    $startingPara = "";
    $startingPara .= "<p>Today, {$geogDate}, {$cityname} prayer times are Fajr Time " . $data['fajar'] . ", Dhuhr (Zuhr) Time " . $data['dhuhr'] . ", Asr Time " . $data['asr'] . ", Maghrib Time " . $data['maghrib'] . " & Isha Time " . $data['isha'] . ". These timings are based on the Islamic date of {$islamicDate}.</p>";
    return $startingPara;
}

function prayerTimeTable($country, $cityname, $method)
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

    $geogDate = $response['data'][(int) $day - 1]['date']['readable'];
    $islamicDate = $response['data'][(int) $day - 1]['date']['hijri']['month']['en'] . " " . $response['data'][(int) $day - 1]['date']['hijri']['day'] . ", " . $response['data'][(int) $day - 1]['date']['hijri']['year'];

    $dayTimes = [
        "fajar" => date("h:i A", strtotime($matches1[0])),
        "sunrise" => date("h:i A", strtotime($matches2[0])),
        "dhuhr" => date("h:i A", strtotime($matches3[0])),
        "asr" => date("h:i A", strtotime($matches4[0])),
        "maghrib" => date("h:i A", strtotime($matches5[0])),
        "isha" => date("h:i A", strtotime($matches6[0])),
    ];

    $tableStyle = file_get_contents(__DIR__ . '/style.css');
    $startingParagraph = getStartingParagraph($dayTimes, $cityname, $geogDate, $islamicDate);
    $dayTable = getDayTable($dayTimes, $tableStyle, $cityname);
    $monthTable = getMonthTable($response["data"], $tableStyle);

    return $startingParagraph . $dayTable . $monthTable;
}
