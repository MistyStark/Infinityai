<?php
require_once __DIR__ . '/config.php';
$result = wp_api_request('/speech_balloon', 'GET');
file_put_contents(__DIR__ . '/balloon_list.json', $result['raw']);
echo "Balloons saved to balloon_list.json\n";
