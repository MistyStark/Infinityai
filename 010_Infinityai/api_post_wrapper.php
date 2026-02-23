<?php
/**
 * api_post_wrapper.php
 * WebからWordPressに記事を投稿するためのラッパー
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$title = $input['title'] ?? null;
$content = $input['content'] ?? null;

if (!$title || !$content) {
    http_response_code(400);
    echo json_encode(['error' => 'Title and content are required']);
    exit;
}

$post_data = [
    'title'   => $title,
    'content' => $content,
    'status'  => 'publish'
];

$result = wp_api_request('/posts', 'POST', $post_data);

http_response_code($result['code']);
echo $result['raw'];
