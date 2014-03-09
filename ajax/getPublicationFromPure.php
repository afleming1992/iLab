<?php
    $uuid = $_GET[ 'uuid' ];

    header('Content-Type: text/xml');
    echo file_get_contents('https://pureapps2.hw.ac.uk/ws/rest/publication?uuids.uuid='.$uuid.'&rendering=xml_long');
