<!DOCTYPE html>

<!-- ANCHOR Signature

    ._________.
    | > \   < |
    | \\[T]// |
    |  \|O|/  |
    |   |Y|   |
    |  _|||_  |
    |_________|

 -->

<html lang="FR-fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="SIRJACQUES Vincent">
    <meta name="copyright" content="SIRJACQUES Vincent">
    <meta name="robots" content="index, follow">
    <meta name="rating" content="general">

    <!-- ANCHOR titre -->
    <title>Crud en php</title>
    <meta name="description" content="Exercice : https://www.copier-coller.com/un-crud-en-php/">

    <!-- ANCHOR icon de la page -->
    <!-- <link rel="shortcut icon" href="..." type="image/x-icon"> -->

    <!-- SECTION CSS -->

    <!-- ANCHOR CSS Icon -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">


    <!-- ANCHOR CSS framework -->
    <!-- <link rel="stylesheet" href="css/1_reset.css"> -->
    <!-- <link rel="stylesheet" href="css/2_normalize.css"> -->
    <link rel="stylesheet" href="./asset/bootstrap.css">

    <!-- ANCHOR css framework custom -->
    <!-- <link rel="stylesheet" href="./css/mode.css"> -->

    <!-- ANCHOR CSS Custom-->
    <link rel="stylesheet" href="./css/main.css">

    <!-- !SECTION CSS -->

    <!-- SECTION JS__head -->

    <!-- ANCHOR JS framework -->
    <script src="./asset/bootstrap.js" defer></script>

    <!-- ANCHOR JS custom -->
    <!-- <script src="./js/main.js" async></script> -->

    <!-- !SECTION JS__head -->

</head>

<body class="container">

    <!-- SECTION header -->
    <header class="row my-3">
        <h1>Crud en Php</h1>
    </header>
    <aside class="row">
        <a href="./page/add.php" class="btn btn-success col-2">Ajouter un user</a>
        <a href="#" class="btn btn-danger col-2 offset-1">Déconnexion</a>
        <?php
        // echo '<br>' . base64_decode($_GET["m"]);
        ?>
    </aside>
    <!-- !SECTION header -->

    <!-- SECTION main -->
    <main class="row my-3">
        <table class="table table-light table-striped text-center">
            <thead class="table-secondary">
                <th scope="col">Name</th>
                <th scope="col">First name</th>
                <th scope="col">Age</th>
                <th scope="col">Tel</th>
                <th scope="col">Email</th>
                <th scope="col">Pays</th>
                <th scope="col">Comment</th>
                <th scope="col">Métiers</th>
                <th scope="col">URL</th>
                <th scope="col">Edition</th>
            </thead>
            <tbody>
                <?php
                // var d'id MySQL
                $serverName = 'localhost';
                $userName = 'root';
                $passWord = '';
                $dbName = 'exo_crud_php';
                $dbTable = 'crud_table';
                $dsn = "mysql:host=$serverName";

                // autre var
                $date = date("Y");

                try {
                    // log à la DB
                    $conn = new PDO($dsn, $userName, $passWord);
                    // on def le mode d'erreur de PDO sur Exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // creation et utilisation d'une base de donné
                    $createDB = "CREATE DATABASE IF NOT EXISTS $dbName DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
                USE $dbName;";
                    $conn->exec($createDB);


                    // creation et utilisation de la table
                    $createTable = "
            CREATE TABLE IF NOT EXISTS $dbTable (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` varchar(250) NOT NULL,
            `firstname` varchar(250) NOT NULL,
            `age` varchar(10) NOT NULL,
            `tel` varchar(14) NOT NULL,
            `email` varchar(250) NOT NULL,
            `pays` varchar(250) NOT NULL,
            `comment` text NOT NULL,
            `metier1` varchar(250) DEFAULT NULL,
            `metier2` varchar(250) DEFAULT NULL,
            `metier3` varchar(250) DEFAULT NULL,
            `url` varchar(250) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
                    $conn->exec($createTable);

                    // affichage des articles
                    $requete = "SELECT * FROM $dbTable";
                    $stResult = $conn->query($requete);
                    if ($stResult === false) {
                        die("Erreur");
                    }

                    while ($row = $stResult->fetch(PDO::FETCH_ASSOC)) :
                        echo '
                        <tr>
                            <th scope="row">' . stripslashes($row['name']) . '</th>
                            <td>' . stripslashes($row['firstname']) . '</td>
                            <td>' . $date - substr(stripslashes($row['age']), 0, 4) . '</td>
                            <td>' . stripslashes($row['tel']) . '</td>
                            <td>' . stripslashes($row['email']) . '</td>
                            <td>' . stripslashes($row['pays']) . '</td>
                            <td>' . stripslashes($row['comment']) . '</td>
                            <td>' . stripslashes($row['metier1'] . ' / ' . $row['metier2'] . ' / ' . $row['metier3']) . '</td>
                            <td>' . stripslashes($row['url']) . '</td>
                            <td>
                            <a href="./page/read.php?id=' . $row['id'] . '" class="btn btn-light">Read</a>
                            <a href="./page/edit.php?id=' . $row['id'] . '" class="btn btn-success">Update</a>
                            <a href="./page/delete.php?id=' . $row['id'] . '" class="btn btn-danger">Delete</a>
                            </td>
                        <tr>
                        ';
                    endwhile;
                }

                // pour les erreurs de co à la base
                catch (PDOException $e) {
                    die("<p>Impossible de se connecter au serveur $serverName : " . $e->getMessage() . "</p>");
                }
                ?>
            </tbody>
        </table>
    </main>
    <!-- !SECTION main -->

    <!-- SECTION footer -->
    <footer>

    </footer>
    <!-- !SECTION footer -->
    <?php
    // On ferme la co
    $conn = null;
    ?>
</body>

</html>