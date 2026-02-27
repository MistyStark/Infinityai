<?php
/**
 * upload_070.php
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

$file_path = 'D:\100_MyFolderD\000_TeamMisty\010_Infinityai\0020_Assets\0010_Image\070_GoogleAccount.png';
$title = '070_GoogleAccount';

echo "Uploading: $file_path ...\n";
$res = upload_to_wp($file_path, $title);

if ($res['code'] === 201) {
    echo "Success! URL: " . $res['body']['source_url'] . "\n";
} else {
    echo "Error: HTTP Code: " . $res['code'] . "\n";
    echo "Response: " . $res['raw'] . "\n";
}
