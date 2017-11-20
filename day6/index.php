<?php

include 'pdoHelper.php';

require __DIR__ . '/vendor/autoload.php';

use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;

$csv = 'importCSV';
$xlsx = 'importXLSX';
$result = '';
$uploaddir = '/var/www/uploads/day6/';

$pdo = getMysqlPDO('databaseSettings.php');

if (isset($_FILES[$csv]) || isset($_FILES[$xlsx])) {
    if (isset($_FILES[$csv])) {
        $importFile = $_FILES[$csv];
        $fileType = Type::CSV;
    } else {
        $importFile = $_FILES[$xlsx];
        $fileType = Type::XLSX;
    }

    $uploadfile = $uploaddir . basename($importFile['name']);

    if (move_uploaded_file($importFile['tmp_name'], $uploadfile)) {
        $result = "Файл корректен и был успешно загружен.\n";
        $reader = ReaderFactory::create($fileType); // for CSV files

        $reader->open($uploadfile);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $values = array_values($row);
                $idValue = 0;
                array_unshift($values, $idValue);
                $values =  implode("', '", $values);
                $values = "'" . $values . "'";
                $statement = prepareAndExecuteSql($pdo, "INSERT IGNORE INTO InventoryNumbers VALUES ($values)");
            }
        }

        $reader->close();
    } else {
        $result = "Возможная атака с помощью файловой загрузки!\n";
    }

}

$csv = 'exportCSV';
$xlsx = 'exportXLSX';

if (isset($_GET[$csv]) || isset($_GET[$xlsx])) {
    if (isset($_GET[$csv])) {
        $fileName = 'data.csv';
        $fileType = Type::CSV;
    } else {
        $fileName = 'data.xlsx';
        $fileType = Type::XLSX;
    }

    $writer = WriterFactory::create($fileType);
    $writer->openToBrowser($fileName); // stream data directly to the browser

    $statement = prepareAndExecuteSql($pdo, "SELECT * FROM InventoryNumbers");

    while (($row = $statement->fetch(PDO::FETCH_ASSOC)) !== false) {
        $values = array_values($row);
        //print_r($values);
        $idExcluded = array_slice($values, 1);
        //echo "<hr>";
        //print_r($idExcluded);
        //echo "<hr>";
        //echo "<hr>";
        $writer->addRow($idExcluded); // add a row at a time
    }

    $writer->close();
    exit;
}

$statement = prepareAndExecuteSql($pdo, "SELECT * FROM InventoryNumbers");

$table = "<table>";
$table .= "<tr><td>id</td></tr>";
while (($row = $statement->fetchObject()) !== false) {
    $table .= "<tr>";

    foreach ($row as $cell) {
        $table .= "<td>$cell</td>";
    }

    $table .= "</tr>";
}
$table .= "</table>";
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf8">
    <title>День 6</title>
    <style>
        form {
            width: 300px;
        }
        fieldset {
            display: inline-block;
            float: left;
        }
        table {
            border-collapse: collapse;
        }
        td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <fieldset>
        <legend>импорт</legend>
        <form enctype="multipart/form-data" method="POST" action="index.php">
            <fieldset>
                <legend>.csv</legend>
                Выберите csv-файл:
                <input type="file" accept="text/csv" name="importCSV">
                <input type="submit" value="Импортировать csv-файл">
            </fieldset>
        </form>
        <br>
        <form enctype="multipart/form-data" method="POST" action="index.php">
            <fieldset>
                <legend>.xlsx</legend>
                Выберите xlsx-файл:
                <input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="importXLSX">
                <input type="submit" value="Импортировать xlsx-файл">
            </fieldset>
        </form>
    </fieldset>
    <fieldset>
        <legend>экспорт</legend>
        <form action="index.php">
            <input type="submit" name="exportCSV" value="Экспортировать в .csv">
        </form>
        <br>
        <form action="index.php">
            <input type="submit" name="exportXLSX" value="Экспортировать в .xlsx">
        </form>
    </fieldset>
    <p>Содержимое базы данных:</p>
    <div><?=$table?></div>
    <br>
    <div><?=$result?></div>
</body>
</html>