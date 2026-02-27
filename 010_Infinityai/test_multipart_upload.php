<?php
/**
 * 20260227_102000_v001_multipart_upload.php
 * multipart/form-data形式でのアップロード試行 (WAF回避策)
 */

require_once __DIR__ . '/config.php';

function upload_multipart($file_path, $title) {
    if (!file_exists($file_path)) {
        return ['error' => "File not found: $file_path", 'code' => 404];
    }

    $wp_config = get_wp_config();
    $username = $wp_config['WP_API_USERNAME'];
    $password = $wp_config['WP_API_PASSWORD'];
    $api_url = str_replace('/mcp/v1', '/wp/v2', $wp_config['WP_API_URL']);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url . '/media');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    // PHP 5.5+ 形式
    $cfile = new CURLFile($file_path, 'image/png', basename($file_path));
    $post_data = [
        'file' => $cfile,
        'title' => $title,
        'caption' => 'Verification Image',
        'status' => 'publish'
    ];
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36"
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

$file = 'D:\\100_MyFolderD\\000_TeamMisty\\010_Infinityai\\0020_Assets\\0010_Image\\070_GoogleAccount.png';
echo "Multipart Upload Attempt...\n";
$res = upload_multipart($file, '070_GoogleAccount_V2');

if ($res['code'] === 201) {
    echo "========================================\n";
    echo "🍵 Success! NEW URL: " . $res['body']['source_url'] . "\n";
    echo "========================================\n";
} else {
    echo "Critical Error: HTTP Code: " . $res['code'] . "\n";
    echo "Response: " . $res['raw'] . "\n";
}
