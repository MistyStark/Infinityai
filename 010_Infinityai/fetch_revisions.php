<?php
require_once __DIR__ . '/config.php';

$post_id = 1953;
echo "Fetching revisions for post $post_id...\n";
$result = wp_api_request("/posts/$post_id/revisions", 'GET');

if ($result['code'] === 200) {
    if (empty($result['body'])) {
        echo "No revisions found.\n";
    } else {
        // [0] is usually the latest (the one I just made), [1] is the previous
        $latest_rev = $result['body'][0] ?? null;
        $prev_rev = $result['body'][1] ?? null;
        
        if ($prev_rev) {
            echo "--- Previous Revision Found ---\n";
            echo "Title: " . $prev_rev['title']['rendered'] . "\n";
            echo "Content:\n" . $prev_rev['content']['rendered'] . "\n";
            
            // ファイルに保存しておく
            file_put_contents(__DIR__ . '/backup_1953.txt', $prev_rev['content']['rendered']);
            echo "\nSaved content to backup_1953.txt\n";
        } else {
            echo "No previous revision found in the list.\n";
            print_r($result['body']);
        }
    }
} else {
    echo "Error fetching revisions. Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
