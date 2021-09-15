<?php
session_start();
require_once "config.php";
$message ="";
$salt = 'XyZzy12*_';
if(!isset($_SESSION['name'])){
    header("Location: index.php");
}
if(isset($_GET['password_new']) && isset($_GET['password_conf']) && isset($_GET['action'])){
    $pw_new = $_GET['password_new'];
    $pw_conf = $_GET['password_conf'];
    if($pw_new == ""){
        $message = ('<p style="color:red">Please enter a new password...</p>');
    }
    else{
        if($pw_conf !== $pw_new){
            $message = ('<p style="color:red">The Password don\'t match</p>');
        }
        else{
            $name = $_SESSION['name'];
            $sql = "UPDATE users SET password = :pw_new WHERE name = :name";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':pw_new' => $pw_new, ':name' => $_SESSION['name']));
            $message = '<p style="color:green;">The password has been changed!</p>';
            header("location: index.php");
        }
    }
}
?>
<html>
<head>
</head>
<body>
<div id="main">

    <h1>Change Password</h1>

    <p>Change your password.</p>

    <form action=""<?php echo($_SERVER["SCRIPT_NAME"]);?>"" method="GET">
        <p><label for="password_new">New password:</label><br />
            <input type="password" id="password_new" name="password_new"></p>

        <p><label for="password_conf">Re-type new password:</label><br />
            <input type="password" id="password_conf" name="password_conf"></p>

        <button type="submit" name="action" value="change">Change</button>

    </form>

    <br />
    <?php
    echo $message;
    ?>

</div>
</body>
</html>
