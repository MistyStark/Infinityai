<?php
/**
 * check_theme.php
 */

require_once __DIR__ . '/config.php';

$endpoint = '/themes?status=active';
echo "Checking active theme...\n";

$result = wp_api_request($endpoint, 'GET');

if ($result['code'] === 200) {
    if (!empty($result['body'])) {
        foreach ($result['body'] as $theme) {
            echo "Active Theme: " . $theme['name'] . " (Slug: " . $theme['stylesheet'] . ")\n";
        }
    } else {
        echo "No active theme found in the response (might need higher permissions).\n";
    }
} else {
    echo "Error: Failed to fetch themes. HTTP Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
