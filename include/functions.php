<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/seed_data.php';

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

function catalog_db_ready() {
    global $conn;
    return $conn instanceof mysqli;
}

function catalog_seed_categories_map() {
    $map = [];
    foreach (catalog_seed_data()['categories'] as $category) {
        $map[(int)$category['id']] = $category;
    }
    return $map;
}

function catalog_merge_category_name(array $items) {
    $categories = catalog_seed_categories_map();
    foreach ($items as &$item) {
        $categoryId = isset($item['category_id']) ? (int)$item['category_id'] : 0;
        if (!isset($item['category_name']) && isset($categories[$categoryId])) {
            $item['category_name'] = $categories[$categoryId]['name'];
        }
    }
    unset($item);
    return $items;
}

function catalog_like_match($haystack, $needle) {
    $haystack = (string)$haystack;
    $needle = trim((string)$needle);
    if ($needle === '') {
        return true;
    }
    if (function_exists('mb_stripos')) {
        return mb_stripos($haystack, $needle, 0, 'UTF-8') !== false;
    }
    return stripos($haystack, $needle) !== false;
}

function get_menu() {
    if (!catalog_db_ready()) {
        return catalog_seed_data()['menu'];
    }

    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM menu ORDER BY sort_order ASC, id ASC");
    if (!$result) {
        return catalog_seed_data()['menu'];
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_categories() {
    if (!catalog_db_ready()) {
        return catalog_seed_data()['categories'];
    }

    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM categories ORDER BY id ASC");
    if (!$result) {
        return catalog_seed_data()['categories'];
    }

    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_news($search = '') {
    $search = trim($search);

    if (!catalog_db_ready()) {
        $items = catalog_merge_category_name(catalog_seed_data()['news']);
        if ($search === '') {
            return $items;
        }

        return array_values(array_filter($items, function ($item) use ($search) {
            $haystack = implode(' ', [
                $item['header'] ?? '',
                $item['content'] ?? '',
                $item['director'] ?? '',
                $item['country'] ?? '',
            ]);
            return catalog_like_match($haystack, $search);
        }));
    }

    global $conn;
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
    if (!$result) {
        return catalog_merge_category_name(catalog_seed_data()['news']);
    }

    return catalog_merge_category_name(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

function get_post() {
    return get_news();
}

function get_featured_items($limit = 3) {
    $limit = (int)$limit;
    if ($limit <= 0) {
        $limit = 3;
    }

    if (!catalog_db_ready()) {
        $items = array_values(array_filter(catalog_merge_category_name(catalog_seed_data()['news']), function ($item) {
            return !empty($item['featured']);
        }));
        usort($items, function ($a, $b) {
            if ((float)$a['rating'] === (float)$b['rating']) {
                return (int)$b['id'] <=> (int)$a['id'];
            }
            return (float)$b['rating'] <=> (float)$a['rating'];
        });
        return array_slice($items, 0, $limit);
    }

    global $conn;
    $sql = "SELECT news.*, categories.name AS category_name
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            WHERE news.featured = 1
            ORDER BY news.rating DESC, news.id DESC
            LIMIT $limit";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return [];
    }

    return catalog_merge_category_name(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

function get_post_by_id($post_id) {
    if (!catalog_db_ready()) {
        foreach (catalog_merge_category_name(catalog_seed_data()['news']) as $item) {
            if ((int)$item['id'] === (int)$post_id) {
                return $item;
            }
        }
        return null;
    }

    global $conn;
    $post_id = mysqli_real_escape_string($conn, $post_id);
    $sql = "SELECT news.*, categories.name AS category_name
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            WHERE news.id = $post_id
            LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return null;
    }

    $row = mysqli_fetch_assoc($result);
    return $row ? catalog_merge_category_name([$row])[0] : null;
}

function get_post_by_category($category_id) {
    if (!catalog_db_ready()) {
        $items = array_values(array_filter(catalog_merge_category_name(catalog_seed_data()['news']), function ($item) use ($category_id) {
            return (int)$item['category_id'] === (int)$category_id;
        }));
        usort($items, function ($a, $b) {
            $dateCmp = strcmp((string)$b['datatime'], (string)$a['datatime']);
            if ($dateCmp !== 0) {
                return $dateCmp;
            }
            return (int)$b['id'] <=> (int)$a['id'];
        });
        return $items;
    }

    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $sql = "SELECT news.*, categories.name AS category_name
            FROM news
            LEFT JOIN categories ON news.category_id = categories.id
            WHERE news.category_id = $category_id
            ORDER BY news.datatime DESC, news.id DESC";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return [];
    }

    return catalog_merge_category_name(mysqli_fetch_all($result, MYSQLI_ASSOC));
}

function get_category_title($category_id) {
    if (!catalog_db_ready()) {
        foreach (catalog_seed_data()['categories'] as $category) {
            if ((int)$category['id'] === (int)$category_id) {
                return $category;
            }
        }
        return null;
    }

    global $conn;
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $sql = "SELECT * FROM categories WHERE id = $category_id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        return null;
    }

    return mysqli_fetch_assoc($result);
}

function delete_new($post_id) {
    if (!catalog_db_ready()) {
        return false;
    }

    global $conn;
    $post_id = mysqli_real_escape_string($conn, $post_id);
    $sql = "DELETE FROM news WHERE id = $post_id";
    return mysqli_query($conn, $sql);
}

function get_episodes_by_post_id($post_id) {
    if (!catalog_db_ready()) {
        $items = array_values(array_filter(catalog_seed_data()['episodes'], function ($episode) use ($post_id) {
            return (int)$episode['post_id'] === (int)$post_id;
        }));
        usort($items, function ($a, $b) {
            if ((int)$a['season_number'] !== (int)$b['season_number']) {
                return (int)$a['season_number'] <=> (int)$b['season_number'];
            }
            if ((int)$a['episode_number'] !== (int)$b['episode_number']) {
                return (int)$a['episode_number'] <=> (int)$b['episode_number'];
            }
            return (int)$a['id'] <=> (int)$b['id'];
        });
        return $items;
    }

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
