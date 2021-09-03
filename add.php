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
    if(isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary'])){
        if(strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1){
            $_SESSION['error'] = "All fields are required";
            header('Location: add.php');
            return;

        }
        elseif(strpos($_POST['email'],'@') == false){
            $_SESSION['error'] = "Email address must contain @";
            header('Location : add.php');
            return;

        }
        else{
            $stmt = $pdo->prepare('INSERT INTO Profile(user_id,first_name,last_name,email,headline,summary) VALUES (:uid,:fn,:ln,:em,:he,:su)');
            $stmt->execute(array(
                ':uid' => $_SESSION['user_id'],
                ':fn' => $_POST['first_name'],
                ':ln' => $_POST['last_name'],
                ':em' => $_POST['email'],
                ':he' => $_POST['headline'],
                ':su' => $_POST['summary']
            ));
            $_SESSION['success']="Profile added";
            header("Location:index.php");
            return;
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
                echo ('<h1 style="font-size:36px;line-height: 1.1;font-weight: 500;">Adding Profile for ');
                echo ($_SESSION['name']);
                echo ("</h1>");
            }
            if(isset($_SESSION['error'])){
                echo ('<p style="color:red;">').$_SESSION['error'].("</p>\n");
                unset($_SESSION['error']);
            }

        ?>
        <form method="POST" action="add.php">
            <p
                <label>First Name :</label>
                <input type="text" name="first_name" size="60"><br>
            </p>
            <p>
                <label>Last Name :</label>
                <input type="text" name="last_name" size="60"><br>
            </p>
            <p>
                <label>Email :</label>
                <input type="text" name="email" size="30"><br>
            </p>
            <p>
                <Label>Headline :</Label><br>
                <input type="text" name="headline" size="80"><br>
            </p>
            <p>
                <label>Summary :</label><br>
                <textarea name="summary" rows="8" cols="80" style="width: 780px;height: 165px;"></textarea>
            </p>
            <p>
                <input type="submit" value="Add">
                <input type="submit" name="cancel" value="Cancel">
            </p>
        </form>

    </div>
</body>
</html>
