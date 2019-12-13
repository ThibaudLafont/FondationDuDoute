<?php
// Autoload
require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

// Init
$db_host = '';
$db_user = '';
$db_pass = '';
$pdo = new PDO('mysql:host=' . $db_host . ';dbname=fondation;charset=utf8', $db_user, $db_pass);

// Fetch
$sql = 'select * from website';
$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Proceed
foreach ($data as $website) {
    // Define name parts
    $parts = explode(' ', $website['artist_first_name']);
    $firstName = array_shift($parts);
    $lastName = implode(' ', $parts);

    // Update row
    $sql = 'UPDATE website SET artist_first_name=:first_name, artist_last_name=:last_name WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'first_name' => $firstName,
        'last_name' => $lastName,
        'id' => $website['id']
    ]);
}