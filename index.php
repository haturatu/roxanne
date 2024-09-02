<?php
$directory = './'; 

if (!is_dir($directory)) {
    die("指定されたディレクトリは存在しません。");
}

$files = scandir($directory);

// 除外ファイルとエントリー
$files = array_diff($files, array('.', '..', 'index.php', 'style.css'));

// HTML
echo "<!DOCTYPE html>";
echo "<html lang='ja'>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "<title>Files</title>";
echo "<link rel='stylesheet' href='style.css'>";
echo "</head>";
echo "<body>";

echo "<div class='container'>";
echo "<h1>Index of: " . htmlspecialchars($directory) . "</h1>";
echo "<ul>";

// リスト表示
foreach ($files as $file) {
    $fullPath = $directory . '/' . $file;
    if (is_dir($fullPath)) {
        echo "<li class='directory'><a href='" . htmlspecialchars($file) . "/'>" . htmlspecialchars($file) . "/</a></li>";
    } else {
        $size = filesize($fullPath);
        $sizeFormatted = formatSize($size);
        echo "<li class='file'><a href='" . htmlspecialchars($file) . "'>" . htmlspecialchars($file) . "</a> <span class='size'>(" . $sizeFormatted . ")</span></li>";
    }
}

echo "</ul>";
echo "</div>";
echo "</body>";
echo "</html>";

function formatSize($bytes) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    return round($bytes, 2) . ' ' . $units[$pow];
}
?>

