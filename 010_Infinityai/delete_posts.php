<?php
require_once __DIR__ . '/config.php';

$ids_to_delete = [1985, 1948];

foreach ($ids_to_delete as $id) {
    echo "Deleting post ID: $id ...\n";
    // force=true to skip the trash and permanently delete (optional, but cleaner for requested deletion)
    $result = wp_api_request("/posts/$id?force=true", 'DELETE');

    if ($result['code'] === 200) {
        echo "Success: Post $id deleted permanently.\n";
    } else {
        echo "Error deleting post $id. Code: {$result['code']}\n";
        echo "Response: {$result['raw']}\n";
    }
}
