<?php
/**
 * fetch_articles.php
 * WordPressの最新記事を3件取得するスクリプト
 */

// 1. 設定ファイルを読み込む
$config_file = __DIR__ . '/mcp-servers.json';
if (!file_exists($config_file)) {
    die("Error: mcp-servers.json not found.\n");
}

$config_data = json_decode(file_get_contents($config_file), true);
$wp_config = $config_data['mcpServers']['infinityai']['env'] ?? null;

if (!$wp_config) {
    die("Error: WordPress configuration not found in mcp-servers.json.\n");
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
    die("Error: Failed to fetch articles. HTTP Code: $http_code\nResponse: $response\n");
}

$posts = json_decode($response, true);

// 3. 結果を表示
echo "--- Latest 3 Articles ---\n";
foreach ($posts as $post) {
    echo "Title: " . $post['title']['rendered'] . "\n";
    echo "Date:  " . $post['date'] . "\n";
    echo "Link:  " . $post['link'] . "\n";
    echo "-------------------------\n";
}
