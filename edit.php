<?php
session_start();
require_once "config.php";
if(!isset($_SESSION['name']) || strlen($_SESSION['name']) < 1){
    die('Name parameter missing');
}
if(isset($_POST['cancel'])){
    header("Location: index.php");
    return;
}
if(isset($_POST['save'])){
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
        if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
            $_SESSION['error'] = "All fields are required";
            header("Location: edit.php?profile_id=".$_POST['profile_id']);
            return;

        }
        elseif(strpos($_POST['email'],'@') == false){
            $_SESSION['error'] = "Email address must contain @";
            header("Location: edit.php?profile_id=".$_POST['profile_id']);
            return;
        }
        else{
            $stmt = $pdo->prepare('UPDATE Profile SET first_name=:fn, last_name=:ln, email=:em, headline = :he, summary = :su WHERE profile_id=:pid');
            $stmt->execute(array(
                ':pid' => $_POST['profile_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary']
            ));
            $_SESSION['success']="Profile update";
            header("Location:index.php");
            return;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        body{
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;

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
    <?php
    if($_SESSION['name']){
        echo ('<h1 style="font-size:36px;line-height: 1.1;font-weight: 500;">Editing Profile for ');
        echo ($_SESSION['name']);
        echo ("</h1>");
    }
    if(isset($_SESSION['error'])){
        echo ('<p style="color:red;">').$_SESSION['error'].("</p>\n");
        unset($_SESSION['error']);
    }

    ?>
    <form method="POST" action="edit.php">
        <?php
            $stmt = $pdo->prepare("SELECT profile_id,first_name,last_name,email,headline,summary FROM Profile WHERE profile_id=:pid");
            $stmt->execute(array(':pid' => $_GET['profile_id']));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $fn = htmlentities($row['first_name']);
            $ln = htmlentities($row['last_name']);
            $em = htmlentities($row['email']);
            $hl = htmlentities($row['headline']);
            $sm = htmlentities($row['summary']);
            $profile_id=$row['profile_id'];
        ?>
        <p
        <label>First Name :</label>
        <input type="text" name="first_name" size="60" value="<?= $fn ?>"><br>
        </p>
        <p>
            <label>Last Name :</label>
            <input type="text" name="last_name" size="60" value="<?= $ln ?>" ><br>
        </p>
        <p>
            <label>Email :</label>
            <input type="text" name="email" size="30" value="<?= $em ?>"><br>
        </p>
        <p>
            <Label>Headline :</Label><br>
            <input type="text" name="headline" size="80" value="<?= $hl ?>"><br>
        </p>
        <p>
            <label>Summary :</label><br>
            <textarea name="summary" rows="8" cols="80"><?= $sm ?></textarea>
        </p>
        <p>
            <input type="submit" name="save" value="Save">
            <input type="submit" name="cancel" value="Cancel">
        </p>
        <input type="hidden" name="profile_id" value="<?= $profile_id ?>">
    </form>

</div>
</body>
</html>
