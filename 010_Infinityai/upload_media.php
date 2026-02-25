<?php
/**
 * upload_media.php
 * ローカルの画像をWordPressのメディアライブラリにアップロードする
 */

require_once __DIR__ . '/config.php';

function upload_to_wp($file_path, $title) {
    if (!file_exists($file_path)) {
        return ['error' => "File not found: $file_path", 'code' => 404];
    }

    $wp_config = get_wp_config();
    $username = $wp_config['WP_API_USERNAME'];
    $password = $wp_config['WP_API_PASSWORD'];
    $api_url = str_replace('/mcp/v1', '/wp/v2', $wp_config['WP_API_URL']);
    
    $file_content = file_get_contents($file_path);
    $filename = basename($file_path);
    
    // mime_content_type が使えない環境への対策
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $mime_map = [
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif'
    ];
    $mime_type = $mime_map[$extension] ?? 'application/octet-stream';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url . '/media');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $file_content);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Disposition: attachment; filename=\"$filename\"",
        "Content-Type: $mime_type",
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'code' => $http_code,
        'body' => json_decode($response, true),
        'raw'  => $response
    ];
}

// メイン処理 (例として実行)
/*
$images = [
    '0010_Antigravity.png',
    '0020_Download.png',
    '0030_ChooseSetupFlow.png',
    '0040_Theme.png',
    '0050_Agent.png'
];

$results = [];
foreach ($images as $img) {
    $path = __DIR__ . '/0020_/0010_Image/' . $img;
    echo "Uploading: $img ...\n";
    $res = upload_to_wp($path, $img);
    if ($res['code'] === 201) {
        $results[$img] = $res['body']['source_url'];
        echo "Success: " . $res['body']['source_url'] . "\n";
    } else {
        echo "Error: " . $res['raw'] . "\n";
    }
}
*/
