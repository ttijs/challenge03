<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php

    include('connect.php');

    if (isset($_POST['submit'])) {

        $error = 0;
        if (!empty($_POST['email'])) {
            $email = $_POST['email'];
        } else {
            $error = 1;
        };
        if (!empty($_POST['firstname'])) {
            $firstname = $_POST['firstname'];
        } else {
            $error = 1;
        };
        if (!empty($_POST['lastname'])) {
            $lastname = $_POST['lastname'];
        } else {
            $error = 1;
        };

        if ($error === 0) {


            try {

                $sql = "INSERT INTO users (firstname, lastname, email) VALUES ('$firstname', '$lastname', '$email')";
                $conn->exec($sql);
                echo "<p>New record created successfully</p>";
            } catch (PDOException $e) {
                echo $sql . "<br>" . $e->getMessage();
            }

        } else {
             echo "FOUTje";
        }
    }


    if (isset($_GET['details'])) {

        echo "<hr>
            <h2>Details of user {$_GET['details']}</h2>
        ";

        # sql injection voorbeeld:
        # http://localhost/Module-08-PHP2/challenge03/?details=1%20OR%201=1
        # http://localhost/Module-08-PHP2/challenge03/?details=1 OR 1=1

        try {

            $sql = "SELECT * FROM users WHERE id = " . $_GET['details'];
            echo "<pre>";
            echo $sql;
            echo "</pre>";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($stmt->fetchAll() as $k => $v) {
                //print_r($v);
                //echo "firstname = " . $v['firstname'] . "<br>";
                echo 'firstname = ' . $v['firstname'] . '<br>';
                echo 'lastname = ' . $v['lastname'] . '<br>';
                echo 'email = ' . $v['email'] . '<br>';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }




    }


    echo "<hr>
    <h2>All users in table</h2>
    ";
    

    try {

        $sql = "SELECT id, firstname, lastname FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $userid = 1;
        echo "You are user: " . $userid . "<br>";
        // set the resulting array to associative

        echo "<ul>";

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        foreach ($stmt->fetchAll() as $k => $v) {
            //print_r($v);
            echo '<li>firstname = ' . $v['firstname'] . '';
            if ($userid == $v['id']) {
                echo ' - <a href="?details=' . $v['id'] . '">view details</a>';
            }
            echo "</li>";
        }
        echo "</ul>";


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }



    $conn = null;
?>

    <hr>
<h1>Add user</h1>
    <form action="" method="post">

        email: <input type="text" name="email"><br>
        firstname: <input type="text" name="firstname"><br>
        lastname: <input type="text" name="lastname"><br>
        <input type="submit" name="submit" value="Opslaan">

    </form>

</body>

</html>