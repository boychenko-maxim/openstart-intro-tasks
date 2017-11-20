<?php
function getMysqlPDO($databaseSettingsPath)
{
    $databaseSettings = include($databaseSettingsPath);
    $pdo = new PDO(
        sprintf(
            'mysql:host=%s;dbname=%s;port=%s;charset=%s',
            $databaseSettings['host'],
            $databaseSettings['databaseName'],
            $databaseSettings['port'],
            $databaseSettings['charset']
        ),
        $databaseSettings['username'],
        $databaseSettings['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
function prepareAndExecuteSql($pdo, $sql)
{
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement;
}