<?php
function getSensorData($start, $end)
{
    $db = getDatabase();
    $statement = $db->prepare("SELECT date, temperature, humidity FROM dht_log WHERE date >= ? AND date <= ?");
    $statement->execute([$start, $end]);
    return $statement->fetchAll();
}
function saveDhtData($temperature, $humidity)
{
    $db = getDatabase();
    $currentDate = date("Y-m-d H:i:s");
    $statement = $db->prepare("INSERT INTO dht_log(date, temperature, humidity) VALUES (?, ?, ?)");
    return $statement->execute([$currentDate, $temperature, $humidity]);
}
function getVarFromEnvironmentVariables($key)
{
    if (defined("_ENV_CACHE")) {
        $vars = _ENV_CACHE;
    } else {
        $file = "env.php";
        if (!file_exists($file)) {
            throw new Exception("The environment file ($file) does not exists. Please create it");
        }
        $vars = parse_ini_file($file);
        define("_ENV_CACHE", $vars);
    }
    if (isset($vars[$key])) {
        return $vars[$key];
    } else {
        throw new Exception("The specified key (" . $key . ") does not exist in the environment file");
    }
}

function getDatabase()
{
    $password = getVarFromEnvironmentVariables("MYSQL_PASSWORD");
    $user = getVarFromEnvironmentVariables("MYSQL_USER");
    $dbName = getVarFromEnvironmentVariables("MYSQL_DATABASE_NAME");
    $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
    $database->query("set names utf8;");
    $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $database;
}
