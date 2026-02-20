<?php
/**
 * api_wrapper.php
 * WordPressの最新記事をJSON形式で提供するAPIラッパー
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 1. 設定ファイルを読み込む
$config_file = dirname(__DIR__) . '/mcp-servers.json';
if (!file_exists($config_file)) {
    http_response_code(500);
    echo json_encode(['error' => 'mcp-servers.json not found']);
    exit;
}

$config_data = json_decode(file_get_contents($config_file), true);
$wp_config = $config_data['mcpServers']['infinityai']['env'] ?? null;

if (!$wp_config) {
    http_response_code(500);
    echo json_encode(['error' => 'WordPress configuration not found']);
    exit;
}

$api_url = $wp_config['WP_API_URL'];
$username = $wp_config['WP_API_USERNAME'];
$password = $wp_config['WP_API_PASSWORD'];

// WordPress REST API (posts) のエンドポイントを構築
$posts_endpoint = str_replace('/mcp/v1', '/wp/v2/posts', $api_url);
$query_url = $posts_endpoint . '?per_page=3';

// 2. cURLで記事を取得
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $query_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    http_response_code($http_code);
    echo json_encode([
        'error' => 'Failed to fetch articles',
        'http_code' => $http_code,
        'response' => json_decode($response, true)
    ]);
    exit;
}

// 3. 結果をそのままJSONとして出力
echo $response;
