<?php
session_start();
require_once "config.php";
?>
<html>
<head>
</head>
<body>
<div class="container">
    <h1>Search </h1>
    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="GET">
        <label for="name">Search for a profile</label>
        <input id="name" type="text" name="name" size="25">
        <button type="submit" name="action" value="search">Search</button>
        <table>
            <tbody>
            <tr height="30" align="center">
                <td><b>firstname</b></td>
                <td><b>lastname</b></td>
                <td><b>Headline</b></td>
                <td><b>Email</b></td>
            </tr>
            <?php
            if(isset($_GET["name"])) {
                $name = $_GET["name"];
                $sql = "SELECT * FROM Profile WHERE first_name LIKE '%" . $name . "%'";
                $stmt = $pdo->query($sql);
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//                $name = '%'.$_GET["name"].'%';
//                $sql = "SELECT * FROM Profile WHERE first_name LIKE :title";
//                $stmt = $pdo->prepare($sql);
//                $stmt->execute(array(':name' => $name));
//                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($rows == TRUE) {
                    foreach ($rows as $row) {
                        echo('<tr height="30"><td>');
                        echo($row['first_name']);
                        echo('</td height="30"><td>');
                        echo($row['last_name']);
                        echo('</td><td align="center">');
                        echo($row["headline"]);
                        echo('</td><td>');
                        echo($row["email"]);
                        echo('</td><td align="center">');
                        echo('</td></tr>');
                    }
                } else {
                    echo('<tr height="30">
                                <td colspan="5" width="580">No name were found!</td>
                                </tr>');
                }
            }
            ?>
            </tbody>
        </table>
    </form>
    <input type=button value="Go back" onClick="document.location.href='index.php'">
</div>
</body>
</html>