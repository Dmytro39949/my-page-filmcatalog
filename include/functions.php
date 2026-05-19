<?php
require_once __DIR__ . '/config.php';

function esc($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function short_text($text, $length = 180) {
    $text = trim(strip_tags((string)$text));
    if (function_exists('mb_strlen') && mb_strlen($text, 'UTF-8') > $length) {
        return mb_substr($text, 0, $length, 'UTF-8') . '...';
    }
    if (!function_exists('mb_strlen') && strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

function get_menu() {
    global $conn;
    $sql = "SELECT * FROM menu ORDER BY sort_order ASC, id ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_categories() {
    global $conn;
    $sql = "SELECT * FROM categories ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_news($search = '') {
    global $conn;
    $search = trim($search);

    if ($search !== '') {
        $safe = mysqli_real_escape_string($conn, $search);
        $sql = "SELECT news.*, categories.name AS category_name
                FROM news
                LEFT JOIN categories ON news.category_id = categories.id
                WHERE news.header LIKE '%$safe%'
                   OR news.content LIKE '%$safe%'
                   OR news.director LIKE '%$safe%'
                   OR news.country LIKE '%$safe%'
                ORDER BY news.datatime DESC, news.id DESC";
    } else {
        $sql = "SELECT news.*, categories.name AS category_name
                FROM news
                LEFT JOIN categories ON news.category_id = categories.id
                ORDER BY news.datatime DESC, news.id DESC";
    }

    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_post() {
    return get_news();
}

function get_featured_items($limit = 3) {
    global $conn;
    $limit = (int)$limit;
    if ($limit <= 0) $limit = 3;

    $sql = "SELECT news.*, categories.name AS category_name
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            WHERE news.featured = 1
            ORDER BY news.rating DESC, news.id DESC
            LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_post_by_id($post_id) {
    global $conn;
    $post_id = mysqli_real_escape_string($conn, $post_id);

    $sql = "SELECT news.*, categories.name AS category_name
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            WHERE news.id = $post_id
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function get_post_by_category($category_id) {
    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);

    $sql = "SELECT news.*, categories.name AS category_name
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            WHERE news.category_id = $category_id
            ORDER BY news.datatime DESC, news.id DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_category_title($category_id) {
    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);

    $sql = "SELECT * FROM categories WHERE id = $category_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function delete_new($post_id) {
    global $conn;
    $post_id = mysqli_real_escape_string($conn, $post_id);
    $sql = "DELETE FROM news WHERE id = $post_id";
    return mysqli_query($conn, $sql);
}

function get_episodes_by_post_id($post_id) {
    global $conn;
    $post_id = (int)$post_id;

    $check = mysqli_query($conn, "SHOW TABLES LIKE 'episodes'");
    if (!$check || mysqli_num_rows($check) === 0) {
        return [];
    }

    $sql = "SELECT * FROM episodes
            WHERE post_id = $post_id
            ORDER BY season_number ASC, episode_number ASC, id ASC";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return [];
    }
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function youtube_to_embed_url($url) {
    $url = trim((string)$url);
    if ($url === '') return '';

    if (strpos($url, 'youtube.com/embed/') !== false) {
        return $url;
    }

    $videoId = '';
    $parts = parse_url($url);
    if (!empty($parts['host']) && strpos($parts['host'], 'youtu.be') !== false) {
        $videoId = trim($parts['path'] ?? '', '/');
    } elseif (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
        $videoId = $query['v'] ?? '';
    }

    if ($videoId === '') return $url;
    return 'https://www.youtube.com/embed/' . htmlspecialchars($videoId, ENT_QUOTES, 'UTF-8');
}

function admin_is_logged_in() {
    return isset($_SESSION['login'], $_SESSION['password']) && $_SESSION['login'] === 'admin' && $_SESSION['password'] === '123';
}
?>
