<?php
/**
 * update_slug_1953.php
 * Post ID 1953 のスラッグのみを更新する
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$endpoint = '/posts/' . $post_id;

$update_data = [
    'slug' => 'antigravity-setup'
];

echo "Updating slug for article ID $post_id to 'antigravity-setup'...\n";

$result = wp_api_request($endpoint, 'POST', $update_data);

if ($result['code'] === 200) {
    echo "Success! Slug updated successfully.\n";
    echo "New Link: " . $result['body']['link'] . "\n";
} else {
    echo "Error: Failed to update slug. HTTP Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
