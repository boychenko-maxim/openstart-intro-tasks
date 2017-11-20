<?php

include('displayErrors.php');
include('pdoHelper.php');

$pdo = getMysqlPDO('databaseSettings.php');

//prepareAndExecuteSql($pdo, "DROP TABLE Users");

prepareAndExecuteSql($pdo,
    "CREATE TABLE Users(
            user_id int AUTO_INCREMENT,
            name varchar(60) NOT NULL,
            passwordHash varchar(60) NOT NULL,
            PRIMARY KEY (user_id)
        )"
);

/*prepareAndExecuteSql($pdo,
    "INSERT INTO Users(name, password)
    VALUES
        ('max', '1')"
);*/

echo 'table Users created successfully!';
