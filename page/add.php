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
    <link rel="stylesheet" href="../asset/bootstrap.css">

    <!-- ANCHOR css framework custom -->
    <!-- <link rel="stylesheet" href="./css/mode.css"> -->

    <!-- ANCHOR CSS Custom-->
    <link rel="stylesheet" href="../css/main.css">

    <!-- !SECTION CSS -->

    <!-- SECTION JS__head -->

    <!-- ANCHOR JS framework -->
    <script src="../asset/bootstrap.js" defer></script>

    <!-- ANCHOR JS custom -->
    <!-- <script src="./js/main.js" async></script> -->

    <!-- !SECTION JS__head -->

</head>

<body class="container">
    <br>
    <?php
    // var d'id MySQL
    $serverName = 'localhost';
    $userName = 'root';
    $passWord = '';
    $dbName = 'exo_crud_php';
    $dbTable = 'crud_table';
    $dsn = "mysql:host=$serverName;dbname=$dbName";
    $test = true;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // var metier default
        $metier1 = null;
        $metier2 = null;
        $metier3 = null;

        // v??rification
        foreach ($_POST as $key => $value) {
            if (empty($value)) {
                echo ('<div class="alert alert-danger alert-dismissible"><span>Erreur : champ ' . $key . ' est vide.</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $test = false;
                break;
            }
            if ($key == 'email' && !filter_var(trim($value, " \n\r\t\v\x00...\x1F"), FILTER_VALIDATE_EMAIL)) {
                echo ('<div class="alert alert-danger alert-dismissible"><span>Erreur : champ ' . $key . ' est invalide.</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>');
                $test = false;
                break;
            }
            // trim retire des elements en d??but et fin de la string
            switch ($key) {
                case 'name':
                    $name = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'firstname':
                    $firstname = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'age':
                    $age = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'tel':
                    $tel = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'pays':
                    $pays = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'metier1':
                    $metier1 = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'metier2':
                    $metier2 = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'metier3':
                    $metier3 = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'url':
                    $url = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                case 'comment':
                    $comment = htmlentities(addslashes(trim($value, " \n\r\t\v\x00...\x1F")), ENT_QUOTES);
                    break;
                default:
                    break;
            }
        }

        // var du post
        $email = $_POST['email'];

        if ($test) {
            try {
                // log ?? la DB
                $conn = new PDO($dsn, $userName, $passWord);
                // on def le mode d'erreur de PDO sur Exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // insertion de donn??es
                $sth = $conn->prepare("
        INSERT IGNORE INTO $dbTable(name, firstname, age, tel, email, pays, comment, metier1, metier2, metier3, url) 
        VALUES(:name, :firstname, :age, :tel, :email, :pays, :comment, :metier1, :metier2, :metier3, :url)
        ");
                $params = [':name', ':firstname', ':age', ':tel', ':email', ':pays', ':comment', ':metier1', ':metier2', ':metier3', ':url'];
                $vars = [$name, $firstname, $age, $tel, $email, $pays, $comment, $metier1, $metier2, $metier3, $url];
                foreach ($params as $key => $value) {
                    $sth->bindParam($value, $vars[$key]);
                }
                $sth->execute();
                $msg = '<div class="alert alert-success alert-dismissible"><span>Votre inscription a ??t?? valid??.</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                echo $msg;
                // header('Location:../index.php?m=' . urlencode(base64_encode($msg)));
            }

            // pour les erreurs de co ?? la base
            catch (PDOException $e) {
                die("<p>Impossible de se connecter au serveur $serverName : " . $e->getMessage() . "</p>");
            }
        }
    }
    ?>
    <!-- SECTION header -->
    <header class="row my-3">
        <h1 class="text-center">Ajouter un contact</h1>
    </header>

    <!-- !SECTION header -->

    <!-- SECTION main -->
    <main class="row my-3">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="container">
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="name">Name :</label>
                <input class="col-md-5" type="text" name="name" id="name" placeholder="Entrez votre nom ...">
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="firstname">First name :</label>
                <input class="col-md-5" type="text" name="firstname" id="firstname" placeholder="Entrez votre pr??nom ...">
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="age">Date de naissance :</label>
                <input class="col-md-5" type="date" name="age" id="age" placeholder="Entrez votre age ...">
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="email">Email :</label>
                <input class="col-md-5" type="email" name="email" id="email" placeholder="Entrez votre email ...">
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="tel">Phone :</label>
                <input class="col-md-5" type="text" name="tel" id="tel" placeholder="00 00 00 00 00">
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="pays">Pays :</label>
                <select class="col-md-5" name="pays" id="pays">
                    <optgroup label="A">
                        <option value="AF">Afghanistan</option>
                        <option value="ZA">Afrique du Sud</option>
                        <option value="AL">Albanie</option>
                        <option value="DZ">Alg??rie</option>
                        <option value="DE">Allemagne</option>
                        <option value="MK">Ancienne R??publique yougoslave de Mac??doine</option>
                        <option value="AD">Andorre</option>
                        <option value="AO">Angola</option>
                        <option value="AI">Anguilla</option>
                        <option value="AQ">Antarctique</option>
                        <option value="AG">Antigua-et-Barbuda</option>
                        <option value="AN">Antilles n??erlandaises</option>
                        <option value="SA">Arabie saoudite</option>
                        <option value="AR">Argentine</option>
                        <option value="AM">Arm??nie</option>
                        <option value="AW">Aruba</option>
                        <option value="AU">Australie</option>
                        <option value="AT">Autriche</option>
                        <option value="AZ">Azerba??djan</option>
                    </optgroup>
                    <optgroup label="B">
                        <option value="BS">Bahamas</option>
                        <option value="BH">Bahre??n</option>
                        <option value="BD">Bangladesh</option>
                        <option value="BB">Barbade</option>
                        <option value="BE">Belgique</option>
                        <option value="BZ">Belize</option>
                        <option value="BJ">B??nin</option>
                        <option value="BM">Bermudes</option>
                        <option value="BT">Bhoutan</option>
                        <option value="BY">Bi??lorussie</option>
                        <option value="BO">Bolivie</option>
                        <option value="BA">Bosnie-et-Herz??govine</option>
                        <option value="BW">Botswana</option>
                        <option value="BR">Br??sil</option>
                        <option value="BN">Brunei Darussalam</option>
                        <option value="BG">Bulgarie</option>
                        <option value="BF">Burkina Faso</option>
                        <option value="BI">Burundi</option>
                    </optgroup>
                    <optgroup label="C">
                        <option value="KH">Cambodge</option>
                        <option value="CM">Cameroun</option>
                        <option value="CA">Canada</option>
                        <option value="CV">Cap-Vert</option>
                        <option value="CL">Chili</option>
                        <option value="CN">Chine</option>
                        <option value="CY">Chypre</option>
                        <option value="CO">Colombie</option>
                        <option value="KM">Comores</option>
                        <option value="CG">Congo</option>
                        <option value="CR">Costa Rica</option>
                        <option value="CI">C??te d'Ivoire</option>
                        <option value="HR">Croatie</option>
                        <option value="CU">Cuba</option>
                    </optgroup>
                    <optgroup label="D">
                        <option value="DK">Danemark</option>
                        <option value="DJ">Djibouti</option>
                        <option value="DM">Dominique</option>
                    </optgroup>
                    <optgroup label="E">
                        <option value="EG">??gypte</option>
                        <option value="SV">El Salvador</option>
                        <option value="AE">??mirats arabes unis</option>
                        <option value="EC">??quateur</option>
                        <option value="ER">??rythr??e</option>
                        <option value="ES">Espagne</option>
                        <option value="EE">Estonie</option>
                        <option value="FM">??tats f??d??r??s de Micron??sie</option>
                        <option value="US">??tats-Unis</option>
                        <option value="ET">??thiopie</option>
                    </optgroup>
                    <optgroup label="F">
                        <option value="FJ">Fidji</option>
                        <option value="FI">Finlande</option>
                        <option value="FR" selected>France</option>
                    </optgroup>
                    <optgroup label="G">
                        <option value="GA">Gabon</option>
                        <option value="GM">Gambie</option>
                        <option value="GE">G??orgie</option>
                        <option value="GS">G??orgie du Sud-et-les ??les Sandwich du Sud</option>
                        <option value="GH">Ghana</option>
                        <option value="GI">Gibraltar</option>
                        <option value="GR">Gr??ce</option>
                        <option value="GD">Grenade</option>
                        <option value="GL">Groenland</option>
                        <option value="GP">Guadeloupe</option>
                        <option value="GU">Guam</option>
                        <option value="GT">Guatemala</option>
                        <option value="GN">Guin??e</option>
                        <option value="GQ">Guin??e ??quatoriale</option>
                        <option value="GW">Guin??e-Bissau</option>
                        <option value="GY">Guyane</option>
                        <option value="GF">Guyane fran??aise</option>
                    </optgroup>
                    <optgroup label="H">
                        <option value="HT">Ha??ti</option>
                        <option value="HN">Honduras</option>
                        <option value="HK">Hong Kong</option>
                        <option value="HU">Hongrie</option>
                    </optgroup>
                    <optgroup label="I">
                        <option value="BV">Ile Bouvet</option>
                        <option value="CX">Ile Christmas</option>
                        <option value="NF">??le Norfolk</option>
                        <option value="PN">??le Pitcairn</option>
                        <option value="AX">Iles Aland</option>
                        <option value="KY">Iles Cayman</option>
                        <option value="CC">Iles Cocos (Keeling)</option>
                        <option value="CK">Iles Cook</option>
                        <option value="FO">??les F??ro??</option>
                        <option value="HM">??les Heard-et-MacDonald</option>
                        <option value="FK">??les Malouines</option>
                        <option value="MP">??les Mariannes du Nord</option>
                        <option value="MH">??les Marshall</option>
                        <option value="UM">??les mineures ??loign??es des ??tats-Unis</option>
                        <option value="SB">??les Salomon</option>
                        <option value="TC">??les Turques-et-Ca??ques</option>
                        <option value="VG">??les Vierges britanniques</option>
                        <option value="VI">??les Vierges des ??tats-Unis</option>
                        <option value="IN">Inde</option>
                        <option value="ID">Indon??sie</option>
                        <option value="IQ">Iraq</option>
                        <option value="IE">Irlande</option>
                        <option value="IS">Islande</option>
                        <option value="IL">Isra??l</option>
                        <option value="IT">Italie</option>
                    </optgroup>
                    <optgroup label="J">
                        <option value="LY">Jamahiriya arabe libyenne</option>
                        <option value="JM">Jama??que</option>
                        <option value="JP">Japon</option>
                        <option value="JO">Jordanie</option>
                    </optgroup>
                    <optgroup label="K">
                        <option value="KZ">Kazakhstan</option>
                        <option value="KE">Kenya</option>
                        <option value="KG">Kirghizistan</option>
                        <option value="KI">Kiribati</option>
                        <option value="KW">Kowe??t</option>
                    </optgroup>
                    <optgroup label="L">
                        <option value="LS">Lesotho</option>
                        <option value="LV">Lettonie</option>
                        <option value="LB">Liban</option>
                        <option value="LR">Lib??ria</option>
                        <option value="LI">Liechtenstein</option>
                        <option value="LT">Lituanie</option>
                        <option value="LU">Luxembourg</option>
                    </optgroup>
                    <optgroup label="M">
                        <option value="MO">Macao</option>
                        <option value="MG">Madagascar</option>
                        <option value="MY">Malaisie</option>
                        <option value="MW">Malawi</option>
                        <option value="MV">Maldives</option>
                        <option value="ML">Mali</option>
                        <option value="MT">Malte</option>
                        <option value="MA">Maroc</option>
                        <option value="MQ">Martinique</option>
                        <option value="MU">Maurice</option>
                        <option value="MR">Mauritanie</option>
                        <option value="YT">Mayotte</option>
                        <option value="MX">Mexique</option>
                        <option value="MC">Monaco</option>
                        <option value="MN">Mongolie</option>
                        <option value="MS">Montserrat</option>
                        <option value="MZ">Mozambique</option>
                        <option value="MM">Myanmar</option>
                    </optgroup>
                    <optgroup label="N">
                        <option value="NA">Namibie</option>
                        <option value="NR">Nauru</option>
                        <option value="NP">N??pal</option>
                        <option value="NI">Nicaragua</option>
                        <option value="NE">Niger</option>
                        <option value="NG">Nig??ria</option>
                        <option value="NU">Niu??</option>
                        <option value="NO">Norv??ge</option>
                        <option value="NC">Nouvelle-Cal??donie</option>
                        <option value="NZ">Nouvelle-Z??lande</option>
                    </optgroup>
                    <optgroup label="O">
                        <option value="OM">Oman</option>
                        <option value="UG">Ouganda</option>
                        <option value="UZ">Ouzb??kistan</option>
                    </optgroup>
                    <optgroup label="P">
                        <option value="PK">Pakistan</option>
                        <option value="PW">Palaos</option>
                        <option value="PA">Panama</option>
                        <option value="PG">Papouasie-Nouvelle-Guin??e</option>
                        <option value="PY">Paraguay</option>
                        <option value="NL">Pays-Bas</option>
                        <option value="PE">P??rou</option>
                        <option value="PH">Philippines</option>
                        <option value="PL">Pologne</option>
                        <option value="PF">Polyn??sie fran??aise</option>
                        <option value="PR">Porto Rico</option>
                        <option value="PT">Portugal</option>
                        <option value="TW">Province chinoise de Taiwan</option>
                    </optgroup>
                    <optgroup label="Q">
                        <option value="QA">Qatar</option>
                    </optgroup>
                    <optgroup label="R">
                        <option value="SY">R??publique arabe syrienne</option>
                        <option value="CF">R??publique centrafricaine</option>
                        <option value="KR">R??publique de Cor??e</option>
                        <option value="MD">R??publique de Moldavie</option>
                        <option value="CD">R??publique d??mocratique du Congo</option>
                        <option value="DO">R??publique dominicaine</option>
                        <option value="IR">R??publique islamique d'Iran</option>
                        <option value="KP">R??publique populaire d??mocratique de Cor??e</option>
                        <option value="LA">R??publique Populaire du Laos</option>
                        <option value="CZ">R??publique tch??que</option>
                        <option value="TZ">R??publique-Unie de Tanzanie</option>
                        <option value="RE">R??union</option>
                        <option value="RO">Roumanie</option>
                        <option value="GB">Royaume-Uni</option>
                        <option value="RU">Russie</option>
                        <option value="RW">Rwanda</option>
                    </optgroup>
                    <optgroup label="S">
                        <option value="EH">Sahara occidental</option>
                        <option value="KN">Saint-Christophe-et-Ni??v??s</option>
                        <option value="SM">Saint-Marin</option>
                        <option value="PM">Saint-Pierre-et-Miquelon</option>
                        <option value="VA">Saint-Si??ge (Cit?? du Vatican)</option>
                        <option value="VC">Saint-Vincent-et-les Grenadines</option>
                        <option value="SH">Sainte-H??l??ne</option>
                        <option value="LC">Sainte-Lucie</option>
                        <option value="WS">Samoa</option>
                        <option value="AS">Samoa am??ricaines</option>
                        <option value="ST">Sao Tom??-et-Principe</option>
                        <option value="SN">S??n??gal</option>
                        <option value="CS">Serbie-et-Mont??n??gro</option>
                        <option value="SC">Seychelles</option>
                        <option value="SL">Sierra Leone</option>
                        <option value="SG">Singapour</option>
                        <option value="SK">Slovaquie</option>
                        <option value="SI">Slov??nie</option>
                        <option value="SO">Somalie</option>
                        <option value="SD">Soudan</option>
                        <option value="LK">Sri Lanka</option>
                        <option value="SE">Su??de</option>
                        <option value="CH">Suisse</option>
                        <option value="SR">Suriname</option>
                        <option value="SJ">Svalbard et Jan Mayen</option>
                        <option value="SZ">Swaziland</option>
                    </optgroup>
                    <optgroup label="T">
                        <option value="TJ">Tadjikistan</option>
                        <option value="TD">Tchad</option>
                        <option value="IO">Territoire britannique de l'oc??an Indien</option>
                        <option value="TF">Territoire Francais du Sud</option>
                        <option value="PS">Territoires palestiniens occup??s</option>
                        <option value="TH">Tha??lande</option>
                        <option value="TL">Timor oriental</option>
                        <option value="TG">Togo</option>
                        <option value="TK">Tokelau</option>
                        <option value="TO">Tonga</option>
                        <option value="TT">Trinit??-et-Tobago</option>
                        <option value="TN">Tunisie</option>
                        <option value="TM">Turkm??nistan</option>
                        <option value="TR">Turquie</option>
                        <option value="TV">Tuvalu</option>
                    </optgroup>
                    <optgroup label="U">
                        <option value="UA">Ukraine</option>
                        <option value="UY">Uruguay</option>
                    </optgroup>
                    <optgroup label="V">
                        <option value="VU">Vanuatu</option>
                        <option value="VE">V??n??zu??la</option>
                        <option value="VN">Vietnam</option>
                    </optgroup>
                    <optgroup label="W">
                        <option value="WF">Wallis-et-Futuna</option>
                    </optgroup>
                    <optgroup label="Y">
                        <option value="YE">Y??men</option>
                    </optgroup>
                    <optgroup label="Z">
                        <option value="ZM">Zambie</option>
                        <option value="ZW">Zimbabwe</option>
                    </optgroup>
                </select>
            </div>
            <p class="row mb-3 px-1"><span class="col-md-2 offset-md-2 text-md-end">M??tier :</span></p>
            <div class="row mb-3 px-1 fs-7">
                <div class="col-3 col-md-1 offset-md-4">
                    <label class="text-md-end" for="metier1">DEV :</label>
                    <input type="checkbox" name="metier1" id="metier1" value="dev" checked>
                </div>
                <div class="col-4 col-md-1">
                    <label class="text-md-end" for="metier2">R??seau :</label>
                    <input type="checkbox" name="metier2" id="metier2" value="reseau">
                </div>
                <div class="col-4 col-md-2">
                    <label class="text-md-end" for="metier3">Int??grateur :</label>
                    <input type="checkbox" name="metier3" id="metier3" value="integr">
                </div>
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="url">Url :</label>
                <input class="col-md-5" type="text" name="url" id="url" placeholder="example.com">
            </div>
            <div class="row mb-3 px-1">
                <label class="col-md-2 offset-md-2 text-md-end" for="comment">Comment :</label>
                <textarea class="col-md-5" name="comment" id="comment" cols="30" rows="10" placeholder="Entrez votre commentaire ..."></textarea>
            </div>
            <div class="row mb-3 px-1">
                <button type="submit" class="btn btn-success col-3 col-md-2 offset-1 offset-md-3">Envoyer</button>
                <a href="../index.php" class="btn btn-secondary col-3 col-md-2 offset-4 offset-md-2">Retour</a>
            </div>
        </form>

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