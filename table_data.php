<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MYSQL Data</title>
    <link rel="stylesheet" href="css/table.css">
</head>
<body>
    <?php
    error_reporting(1);
    include("sql/connect.php");
    $connection = $connection_mysql;
    $table = $_GET["table"];

    $query_table = "show tables like '$table'";
    $result_table = mysqli_query($connection, $query_table);
    $table_count = mysqli_num_rows($result_table);

    if ($table_count == 1){
        $query_column = "describe $table";
        $result_column = mysqli_query($connection, $query_column);
        $column = array();
        $datatype = array();
        $primary_key = 0;

        $query = "select * from $table";
        $result = mysqli_query($connection, $query);
        $count = mysqli_num_rows($result);

    ?>
    <table>
        <tr>
    
    <?php
        while($column_fetch = mysqli_fetch_array($result_column, MYSQLI_ASSOC)){
            array_push($column, $column_fetch['Field']);

            if (str_contains($column_fetch['Type'], "int") || str_contains($column_fetch['Type'], "double")){
                array_push($datatype, "number");
            } else if (str_contains($column_fetch['Type'], "char")){
                array_push($datatype, "text");
            } else {
                array_push($datatype, "text");
            }

            if ($column_fetch['Key'] == "PRI"){
                $primary_key = $column_fetch['Field'];
            }
            
            echo("
                <th>".$column_fetch['Field']."</th>
            ");
        }

        if ($count != 0){
    ?>
            <th>Update</th>
            <th>Delete</th>
        </tr>
    
    <?php
        for ($i = 1; $i <= $count; $i++){
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            echo("<tr><form method='post'>");
                for ($j = 0; $j < count($column); $j++){
                    echo("<td class='td_".$i."'><input type='".$datatype[$j]."' class='input_".$i."' name='".$j."' value='".$row[$column[$j]]."' required><a class='display_".$i."'>".$row[$column[$j]]."</a></td>");
                    echo("<script>
                        document.getElementsByClassName('td_".$i."')[".$j."].addEventListener('click', (e) => {
                        document.getElementsByClassName('input_".$i."')[".$j."].style.display = 'block';
                        document.getElementsByClassName('display_".$i."')[".$j."].style.display = 'none';
                        document.getElementsByClassName('td_".$i."')[".$j."].style.border = 'none';
                    });
                    </script>");
                }
                echo("  <td class='button'><input type='submit' class='update' name='update' value='Update'></td>
                        <td class='button'><input type='submit' class='delete' name='delete' value='Delete'></td>
                        ");
            echo("</form></tr>");
        }
    } else {
        echo("</tr>");
    }

    echo("</table><table id='insert_form'><tr><form method='post'>");
            for ($j = 0; $j < count($column); $j++){
                echo("<td><input type='".$datatype[$j]."' class='' name='".$j."' placeholder='".$column[$j]."' required></td>");
            }
            echo("<td><input type='submit' name='insert' value='Create'></td>");
    echo("</form></tr></table>");
    ?>
    <div id="insert">+</div>

    <?php
    } else {
        echo("<a style='color:#f00;'>Table Not Found.</a><br>");
    }

    if(isset($_POST["insert"])){
        $query_insert = "insert into $table values (";
        for ($c = 0; $c < count($column); $c++){
            if ($c == 0){
                if ($datatype[$c] == "number"){
                    $query_insert = $query_insert.$_POST[$c];
                } else {
                    $query_insert = $query_insert."'".$_POST[$c]."'";
                }
            } else {
                if ($datatype[$c] == "number"){
                    $query_insert = $query_insert.",".$_POST[$c];
                } else {
                    $query_insert = $query_insert.",'".$_POST[$c]."'";
                }
            }
        }
        $query_insert = $query_insert.")";
        if (mysqli_query($connection, $query_insert)){
            echo("<a style='color:#080;'>Data Create Succesfully.</a><br>");
        } else {
            echo("<a style='color:#f00;'>Can't Create.</a><br>");
        }
    }
    if(isset($_POST["update"])){
        $query_update = "update $table set ";
        for ($u = 0; $u < count($column); $u++){
            if ($u == 0){
                if ($datatype[$u] == "number"){
                    $query_update = $query_update.$column[$u]."=".$_POST[$u];
                } else {
                    $query_update = $query_update.$column[$u]."='".$_POST[$u]."'";
                }
            } else {
                if ($datatype[$u] == "number"){
                    $query_update = $query_update.", ".$column[$u]."=".$_POST[$u];
                } else {
                    $query_update = $query_update.", ".$column[$u]."='".$_POST[$u]."'";
                }
            }
        }
        $query_update = $query_update." where ";
        if ($primary_key != 0){
            for ($u = 0; $u < count($column); $u++){
                if($column[$u] == $primary_key){
                    if ($datatype[$u] == "number"){
                        $query_update = $query_update.$primary_key."=".$_POST[$u];
                    } else {
                        $query_update = $query_update.$primary_key."='".$_POST[$u]."'";
                    }
                }
            }
        } else {
            if ($datatype[0] == "number"){
                $query_update = $query_update.$column[0]."=".$_POST[0];
            } else {
                $query_update = $query_update.$column[0]."='".$_POST[0]."'";
            }
        }
        if (mysqli_query($connection, $query_update)){
            echo("<a style='color:#080;'>Data Update Succesfully.</a><br>");
        } else {
            echo("<a style='color:#f00;'>Can't Update.</a><br>");
        }

    }
    if(isset($_POST["delete"])){
        $query_delete = "delete from $table where ";
        if ($primary_key != 0){
            for ($d = 0; $d < count($column); $d++){
                if($column[$d] == $primary_key){
                    if ($datatype[$d] == "number"){
                        $query_delete = $query_delete.$primary_key."=".$_POST[$d];
                    } else {
                        $query_delete = $query_delete.$primary_key."='".$_POST[$d]."'";
                    }
                }
            }
        } else {
            if ($datatype[0] == "number"){
                $query_delete = $query_delete.$column[0]."=".$_POST[0];
            } else {
                $query_delete = $query_delete.$column[0]."='".$_POST[0]."'";
            }      
        }
        if (mysqli_query($connection, $query_delete)){
            echo("<a style='color:#f40;'>Data Delete Succesfully.</a><br>");
            echo("<script>
                        alert('Data Delete Succesfully.');
                </script>");
        } else {
            echo("<a style='color:#f00;'>Can't Delete.</a><br>");
        }
    }
    ?>

    <script src="js/script.js"></script>
</body>
</html>