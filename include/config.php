<?php
$host = 'sql111.infinityfree.com';
$user = 'if0_41874177';
$password = 'GCL4Nyh59eQ';
$database = 'if0_41874177_dmytro312';
$sqlFile = __DIR__ . '/../database/filmcatalog.sql';

mysqli_report(MYSQLI_REPORT_OFF);

function strip_database_statements($sql) {
    $lines = preg_split('/\R/', $sql);
    $filtered = [];

    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '') {
            $filtered[] = $line;
            continue;
        }

        if (preg_match('/^CREATE\s+DATABASE\b/i', $trimmed)) {
            continue;
        }

        if (preg_match('/^USE\s+`?[^`]+`?\s*;?$/i', $trimmed)) {
            continue;
        }

        $filtered[] = $line;
    }

    return implode("\n", $filtered);
}

function table_has_expected_text($conn) {
    $result = mysqli_query($conn, "SELECT title FROM menu ORDER BY sort_order ASC, id ASC LIMIT 1");
    if (!$result) {
        return false;
    }

    $row = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    $expectedTitle = "\u{0413}\u{043e}\u{043b}\u{043e}\u{0432}\u{043d}\u{0430}";
    return isset($row['title']) && trim($row['title']) === $expectedTitle;
}

function run_seed_import($conn, $sqlFile) {
    if (!file_exists($sqlFile)) {
        return false;
    }

    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        return false;
    }

    $sql = strip_database_statements($sql);

    if (!mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=0')) {
        return false;
    }

    if (!mysqli_multi_query($conn, $sql)) {
        mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=1');
        return false;
    }

    do {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
    } while (mysqli_more_results($conn) && mysqli_next_result($conn));

    mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=1');
    return true;
}

function bootstrap_filmcatalog($host, $user, $password, $database, $sqlFile) {
    $conn = @mysqli_connect($host, $user, $password, $database);
    if (!$conn) {
        return false;
    }

    if (!mysqli_set_charset($conn, 'utf8mb4')) {
        mysqli_close($conn);
        return false;
    }

    $needsSeed = false;
    $result = mysqli_query($conn, "SHOW TABLES LIKE 'menu'");
    if (!$result || mysqli_num_rows($result) === 0) {
        $needsSeed = true;
    } else {
        mysqli_free_result($result);
        if (!table_has_expected_text($conn)) {
            $needsSeed = true;
        }
    }

    if ($needsSeed && !run_seed_import($conn, $sqlFile)) {
        mysqli_close($conn);
        return false;
    }

    return $conn;
}

$conn = bootstrap_filmcatalog($host, $user, $password, $database, $sqlFile);

if ($conn instanceof mysqli) {
    mysqli_set_charset($conn, 'utf8mb4');
}
?>
