<?php
require_once __DIR__ . '/upload_media.php';

$filename = 'guide_step_2.png';
$path = __DIR__ . '/0020_/0010_Image/' . $filename;

echo "Retrying upload for: $filename\n";
$res = upload_to_wp($path, 'Test Upload');

echo "HTTP Code: " . $res['code'] . "\n";
echo "Response:\n" . $res['raw'] . "\n";
