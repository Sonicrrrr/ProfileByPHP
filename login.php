<?php
    session_start();
    require_once "config.php";
    $salt = 'XyZzy12*_';
    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
    if(isset($_POST['cancel'])){
       header("Location: index.php");
       return;
    }
    if(isset($_POST['email']) || isset($_POST['pass'])){
        if(strlen($_POST['email']) >= 1 && strlen($_POST['pass']) >= 1 && strpos($_POST['email'],'@') == true) {
            $check = hash('md5', $salt.$_POST['pass']);

            $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');

            $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row !== false ) {
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_id'] = $row['user_id'];
                error_log("Login success" . $_POST['email']);
                header("Location: index.php");
                return;
            } else {
                $_SESSION['error'] = "Incorrect password";
                error_log("Login fail" . $_POST['email'] . $check);
                header("Location:login.php");
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
    <h1 style="font-family: inherit;font-weight: 500;line-height: 1.1">PLease Log In</h1>
    <?php
        if(isset($_SESSION['error'])){
            echo ('<p style="color:red;">').htmlentities($_SESSION['error']).("</p>\n");
            unset($_SESSION['error']);
        }
    ?>
    <form method="POST" action="login.php">
        <label for="email"><strong>Email</strong></label>
        <input type="text" name="email" id="email"><br>
        <label for="password"><strong>Password</strong></label>
        <input type="password" name="pass" id="password"><br>
        <input type="submit" onclick="return doValidate();" value="Login">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <script>
        function doValidate(){
            console.log("Validating...");
            try{
                at = document.getElementById('email').value;
                pw = document.getElementById('password').value;
                console.log("Validating addr="+at+" pw="+pw);
                if(pw == null || pw.length < 1 || at.length < 1 || at == null){
                    alert("Both fields must be filled out");
                    return false;
                }
                else if(at.indexOf('@') == -1){
                    alert("Invalid email address");
                    return false;
                }
                return true;
            }catch (e) {
                return false;
            }
            return false;
        }
    </script>
</div>
</body>
</html>

