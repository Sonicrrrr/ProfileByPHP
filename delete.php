<?php
    session_start();
    require_once "config.php";
    if(isset($_POST['cancel'])){
        header("Location:index.php");
        return;
    }
    if(isset($_POST['delete']) && isset($_POST['profile_id'])){
        $sql = "DELETE FROM Profile WHERE profile_id = :pid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(":pid" => $_POST['profile_id']));
        $_SESSION['success'] = 'Profile deleted';
        header('Location: index.php');
        return;
    }
?>
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
<?php
    if(isset($_SESSION['name']) && isset($_SESSION['user_id'])){
        $stmt = $pdo->prepare("SELECT first_name,last_name FROM Profile WHERE profile_id = :pid");
        $stmt->execute(array(':pid' => $_GET['profile_id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $fn = htmlentities($row['first_name']);
    $ln = htmlentities($row['last_name']);
?>
    <div class="container">
        <h1>Deleting Profile</h1>
        <p>First Name : <?php echo $fn ?></p>
        <p>Last Name : <?php echo $ln ?></p>
        <form method="POST" action="<?php echo($_SERVER["SCRIPT_NAME"]);?>">
            <input
                    type="hidden"
                    name="profile_id"
                    value="<?php echo $_GET['profile_id'] ?>"
            >
            <input type="submit" name="delete" value="Delete">
            <input type="submit" name="cancel" value="Cancel">
        </form>
    </div>
</body>
</html>
