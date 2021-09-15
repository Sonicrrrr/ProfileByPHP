<?php
session_start();
require_once "config.php";
$message ="";
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
        else {
            if (isset($_GET["password_curr"])) {

                $password_curr = $_GET["password_curr"];
                $sql = "SELECT password FROM users WHERE name = :name AND password = :password_curr ";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array(':name' => $_SESSION['name'], ':password_curr' => $password_curr));
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $sql = "UPDATE users SET password = :password_new WHERE name = :name";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(':password_new' => $pw_new, ':name' => $_SESSION['name']));
                    $message = "<font color=\"green\">The password has been changed!</font>";
                } else {
                    $message = "<font color=\"red\">The current password is not valid!</font>";
                }
            }
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

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="GET">
        <p><label for="password_curr">Current password:</label><br />
            <input type="password" id="password_curr" name="password_curr"></p>
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
