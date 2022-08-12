<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . "/../../../../core/php/core.inc.php";

if (!jeedom::apiAccess(init('apikey'), 'philipsHue')) {
    echo __('Vous n\'etes pas autorisé à effectuer cette action', __FILE__);
    die();
}

if (init('test') != '') {
    echo 'OK';
    die();
}
$result = json_decode(file_get_contents("php://input"), true);
foreach ($result['bridge'] as $i => $datas) {
    $data = array('data' => array());
    foreach (json_decode($datas, true) as $info) {
        $data['data'][] = $info['data'][0];
    }
    log::add('philipsHue', 'debug', 'Received message for bridge : ' . $i . ' => ' . json_encode($data));
    philipsHue::syncState($i, $data);
}
