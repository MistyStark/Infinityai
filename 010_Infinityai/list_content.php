<?php
require_once __DIR__ . '/config.php';

echo "--- Posts ---\n";
$posts = wp_api_request('/posts?per_page=10', 'GET');
if (isset($posts['body'])) {
    foreach ($posts['body'] as $post) {
        echo $post['id'] . ': ' . $post['title']['rendered'] . ' (' . $post['link'] . ")\n";
    }
}

echo "\n--- Pages ---\n";
$pages = wp_api_request('/pages?per_page=10', 'GET');
if (isset($pages['body'])) {
    foreach ($pages['body'] as $page) {
        echo $page['id'] . ': ' . $page['title']['rendered'] . ' (' . $page['link'] . ")\n";
    }
}
