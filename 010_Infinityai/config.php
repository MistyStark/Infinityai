<?php
/**
 * config.php
 * WordPress API 連携の共通設定とヘルパー関数
 */

function get_wp_config() {
    $config_file = __DIR__ . '/../mcp-servers.json';
    if (!file_exists($config_file)) {
        return null;
    }

    $config_data = json_decode(file_get_contents($config_file), true);
    return $config_data['mcpServers']['infinityai']['env'] ?? null;
}

function wp_api_request($endpoint_suffix, $method = 'GET', $data = null) {
    $wp_config = get_wp_config();
    if (!$wp_config) {
        return ['error' => 'Configuration not found', 'code' => 500];
    }

    $api_url = $wp_config['WP_API_URL'];
    $username = $wp_config['WP_API_USERNAME'];
    $password = $wp_config['WP_API_PASSWORD'];

    // エンドポイントの構築 (mcp/v1 を基準に置換)
    $base_endpoint = str_replace('/mcp/v1', '/wp/v2', $api_url);
    $url = $base_endpoint . $endpoint_suffix;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
    } elseif ($method === 'PUT') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        }
    }

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'code' => $http_code,
        'body' => json_decode($response, true),
        'raw'  => $response
    ];
}
