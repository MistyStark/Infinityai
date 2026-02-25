<?php
/**
 * robust_fix_mittan.php
 * もっと確実に「④ Configure Your Editor」を差し込む
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$title = "Antigravityのインストール・初期設定手順";

// バックアップを取得
$base_content = file_get_contents(__DIR__ . '/backup_1953.txt');

// 1. タイトルの修正
$updated_content = str_replace('3つの初期設定', '4つの初期設定', $base_content);

// 2. セクション ④ の作成
$section_item_4 = '
<li><strong>④ Configure Your Editor（エディターの詳細設定やで）</strong>:
    <p>基本的にはデフォルトのままで「Next」をポチッと押せば問題あらへんけど、それぞれの意味をはんなりと説明しておくわな。🍵</p>
    <ul>
        <li><strong>Keybindings（キー操作のモード）</strong>: 文字入力や操作のスタイルをどないするか決めるんや。
            <p><strong>Normal（おすすめ度100億点満点！）</strong>: いつものVS Codeと同じような感覚で使える画面や。迷わずこれを選んでな。</p>
            <p><strong>Vim</strong>: これはエンジニア特有の、ちょっと特殊なキー操作モードや。自信がない人は避けたほうが無難やで。</p>
        </li>
        <li><strong>Extensions（拡張機能のインストール）</strong>: Antigravityをもっと便利に使いこなすための、秘密の道具セットや！
            <p><strong>Install 7 Extensions</strong>: Pythonとか主要なプログラミング言語に対応するための機能が自動で入るんや。これでAIがもっと賢く、正確に動いてくれるようになるで。</p>
        </li>
        <li><strong>Command Line（起動ツールのインストール）</strong>: パソコンの黒い画面（ターミナル）から、パパっとコマンド一つでAntigravityを呼び出せるようにする魔法の設定や。
            <p><strong>Install</strong>: ここはチェックを入れたままにするのが正解やで。</p>
        </li>
    </ul>
    <p>全部の設定を確認したら、右下の<strong>「Next」</strong>ボタンをはんなりとクリックして次へ進もか！🚀</p>
</li>
';

// 3. 確実に差し込むために、Agent設定の後の </ul> の直前（または直後）を狙う
// ステップ3のヘッダーの直前にある </ul> を狙うのが一番安全
$anchor = '<h4>3. 日本語化の手順</h4>';
$parts = explode($anchor, $updated_content);

if (count($parts) === 2) {
    // ステップ3の直前に「</ul>」があるはずなので、その手前に ④ を差し込む
    // ただし、画像が </ul> の外にある場合もあるので、直前の </ul> を探す
    $search_ul_end = '</ul>';
    $last_ul_pos = strrpos($parts[0], $search_ul_end);
    
    if ($last_ul_pos !== false) {
        $before_ul_end = substr($parts[0], 0, $last_ul_pos);
        $after_ul_end = substr($parts[0], $last_ul_pos);
        $parts[0] = $before_ul_end . $section_item_4 . $after_ul_end;
        echo "Found UL end and inserted section 4.\n";
    } else {
        // ULが見つからない場合は、単純にステップ3の前に置く
        $parts[0] .= $section_item_4;
        echo "Warning: UL end not found, appending to parts[0].\n";
    }
    
    $updated_content = implode($anchor, $parts);
} else {
    echo "Fatal Error: Step 3 anchor not found!\n";
    exit(1);
}

echo "Updating article ID: $post_id ...\n";

$post_data = [
    'title'   => $title,
    'content' => $updated_content,
    'status'  => 'publish'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "Success! Article updated.\n";
} else {
    echo "Error: " . $result['code'] . "\n" . $result['raw'] . "\n";
}
