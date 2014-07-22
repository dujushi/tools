<?php
/**
 * Usage: php db.php ini_file_name sql
 * Sample: php db.php account 'sp_helptext sp_user_info'
 */
if ($argc == 1) {
    die('Usage: php db.php ini_file_name sql');
}

$ini = parse_ini_file($argv[1] . '.ini');
extract($ini);

try {
    $dbh = new PDO($dsn, $user, $password);
} catch (Exception $e) {
    die("Unable to connect: " . $e->getMessage());
}

$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
$sth = $dbh->prepare($argv[2]);
$sth->execute();
$result = $sth->fetchAll();
if ($result && strpos(strtolower($argv[2]), 'sp_helptext') !== false) {
    foreach ($result as $value) {
        echo current($value);
    }   
} else {
    print_r($result);
}
