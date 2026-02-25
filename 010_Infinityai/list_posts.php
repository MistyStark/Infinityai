<?php
require_once __DIR__ . '/config.php';

echo "Fetching recent posts...\n";
$result = wp_api_request('/posts?per_page=20&status=publish,draft', 'GET');

if ($result['code'] === 200) {
    foreach ($result['body'] as $post) {
        echo "ID: " . $post['id'] . " | Title: " . $post['title']['rendered'] . " | Status: " . $post['status'] . "\n";
    }
} else {
    echo "Error: " . $res['raw'] . "\n";
}
