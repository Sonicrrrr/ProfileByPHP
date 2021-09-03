<?php
    require_once "config.php";
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
<style>
    body{
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 18px;
        line-height: 1.42857143;
    }
    h1{
        font-size: 36px;
        font-family: inherit;
        font-weight: 500;
        line-height: 1.42857143;
    }
    .container{
        width: 1100px;
        padding-right: 15px;
        padding-left: 15px;
        margin-left: auto;
        margin-right: auto;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Chuck Severance's Resume Registry</h1>
    <?php
        $sql = "SELECT first_name,last_name,headline,profile_id FROM Profile";
        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!isset($_SESSION['success']) && !isset($_SESSION['name'])) {
            echo('<p><a href="login.php">Please log in</a></p>');echo('<table border="1"' . "\n");
            if (count($rows) > 0) {
                echo('<table border="1"' . "\n");
                echo("<tr><th>Name</th><th>Headline</th></tr>");
                foreach ($rows as $row) {
                    echo("<tr><td>");
                    echo('<a href="view.php?profile_id='.$row['profile_id'].'">');
                    echo(htmlentities($row['first_name']))." ".(htmlentities($row['last_name'])).('</a>');
                    echo("</td><td>");
                    echo(htmlentities($row['headline']));
                    echo("</td><tr>\n");
                }
                echo('</table>');
            }
        }
        else{
            echo ('<p><a href="logout.php">Logout</a></p>');
            if(isset($_SESSION['success'])) {
                echo ('<p style="color:green";>') . $_SESSION['success'] . ("</p>\n");
                unset($_SESSION['success']);
            }
            if (count($rows) > 0) {
                echo('<table border="1"' . "\n");
                echo("<tr><th>Name</th><th>Headline</th><th>Action</th></tr>");
                foreach ($rows as $row) {
                    echo("<tr><td>");
                    echo('<a href="view.php?profile_id='.$row['profile_id'].'">');
                    echo(htmlentities($row['first_name']))." ".(htmlentities($row['last_name'])).('</a>');
                    echo("</td><td>");
                    echo(htmlentities($row['headline']));
                    echo("</td><td>");
                    echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a>');
                    echo(' <a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
                }
                echo('</table>');
            }
            echo('<p><a href="add.php">Add New Entry</a></p>');
        }

    ?>
</div>
</body>
</html>
