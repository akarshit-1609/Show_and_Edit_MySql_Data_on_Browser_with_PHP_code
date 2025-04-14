<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tables</title>
</head>
<body>
    <h1>Tables</h1>
    <?php
    error_reporting(1);
    include("sql/connect.php");
    $connection = $connection_mysql;
    $database = $database_mysql;

    $query = "show tables";
    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);

    for ($i = 1; $i <= $count; $i++){
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo("<a href='table_data.php?table=".$row["Tables_in_$database"]."' name='".$row["Tables_in_$database"]."'>".$row["Tables_in_$database"]."</a><br>");
    }
    ?>
</body>
</html>