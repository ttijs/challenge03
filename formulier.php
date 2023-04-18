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

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "test";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO users (firstname, lastname, email) VALUES ('$firstname', '$lastname', '$email')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "FOUTje";
        }
    }

    ?>


    <form action="" method="post">

        email: <input type="text" name="email"><br>
        firstname: <input type="text" name="firstname"><br>
        lastname: <input type="text" name="lastname"><br>
        <input type="submit" name="submit" value="Verstuur">

    </form>

</body>

</html>