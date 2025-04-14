<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Databases</title>
</head>
<body>
    <h1>Databases</h1>
    <?php
    error_reporting(1);
    include("sql/connect.php");
    $connection = $connection_mysql;
    $database = $database_mysql;

    $query = "show databases";
    $result = mysqli_query($connection, $query);
    $count = mysqli_num_rows($result);

    for ($i = 1; $i <= $count; $i++){
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($row["Database"] != "mysql" && $row["Database"] != "information_schema" && $row["Database"] != "performance_schema" && $row["Database"] != "sys"){
            echo("<a href='?database=".$row["Database"]."' name='".$row["Database"]."'>".$row["Database"]."</a><br>");
            if (isset($_GET["database"])){
                $_SESSION["database"] = $_GET["database"];
                header("Location: tables.php");
            }
        }
    }
    ?>
</body>
</html>