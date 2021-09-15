<?php
    session_start();
    require_once "config.php";

?>
<!DOCTYPE html>
<html>
<head></head>
<body>
    <div class="container">
        <h1>Profile information</h1>
        <?php
        if($_GET['profile_id']){
            $stmt = $pdo->prepare('SELECT first_name,last_name,email,headline,summary FROM Profile WHERE profile_id = :pid');
            $stmt->execute(array(':pid' => $_GET['profile_id']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        echo("<p>First Name :".($row['first_name'])."</p>\n");
        echo("<p>Last Name :".($row['last_name'])."</p>\n");
        echo("<p>Email :".($row['email'])."</p>\n");
        echo("<p>Headline :<br>".($row['headline'])."</p>\n");
        echo("<p>Summary :<br>".($row['summary'])."</p>\n");
//        echo("<p>First Name :".htmlentities($row['first_name'])."</p>\n");
//        echo("<p>Last Name :".htmlentities($row['last_name'])."</p>\n");
//        echo("<p>Email :".htmlentities($row['email'])."</p>\n");
//        echo("<p>Headline :<br>".htmlentities($row['headline'])."</p>\n");
//        echo("<p>Summary :<br>".htmlentities($row['summary'])."</p>\n");
        ?>
        <p><a href="index.php">Done</a></p>
    </div>
</body>
</html>
