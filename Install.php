<?php
session_start();

const configFile = "Configuration/Config.php";
if (!isset($_SESSION["Step"])) {
    $_SESSION["Step"] = 0;
}

if (isset($_POST["InstallServer"]) && $_SESSION["Step"] == 1) {
    $_SESSION["Step"] = 2;
}

if (isset($_POST["InstallBaseData"]) && $_SESSION["Step"] == 4) {
    $_SESSION["Step"] = 5;
}

switch ($_SESSION["Step"]) {
    case 1:
        GenerateInstallForm();
        break;

    case 2:
        SaveConfig();
        break;

    case 3:
        ImportDataBase();
        break;

    case 4:
        GenerateInstallDataForm();
        break;

    case 5:
        ImportDataFromForm();
        break;

    case 6:
        InsertAdminAccountToDataBase();
        break;

    case 7:
        FinishInstallationProcess();
        break;

    default:
        echo "<h2>Instalator aplikacji</h2>";
        echo "<h3>Postępuj zgodnie z instrukcjami</h3>";
        if (file_exists(configFile)) {
            if (is_writable(configFile)) {
                $_SESSION["Step"] = 1;
                echo "<p>Rozpoczynanie instalacji!</p>";
                echo '<script>
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    </script>';
            } else {
                echo "<p>Zmień uprawnienia do pliku <code>" . configFile . "</code><br>np. <code>chmod o+w " . configFile . "</code></p>";
                echo "<p><button class=`btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
            }
        } else {
            echo "<p>Stwórz plik <code>" . configFile . "</code><br>np. <code>touch " . configFile . "</code><br>Po czym odśwież strone</p>";
            echo "<p><button class=`btn btn-info' onClick='window.location.href=window.location.href'>Odśwież stronę</button></p>";
        }

        break;
}

function GenerateInstallForm()
{
    include("Configuration/InstallationResources/InstallServer.php");
}

function SaveConfig()
{
    $file = fopen(configFile, "w");
    $prefix = "";
    if ($_POST['Prefix'] != "") {
        $prefix = $_POST['Prefix'] . "_";
    }
    $config = "<?php
                \$host=\"" . $_POST['Host'] . "\";
                \$user=\"" . $_POST['User'] . "\";
                \$password=\"" . $_POST['Password'] . "\";
                \$database=\"" . $_POST['DBName'] . "\";
                \$prefix=\"" . $prefix . "\";
                \$link = mysqli_connect(\$host, \$user, \$password, \$database);\n";

    if (!fwrite($file, $config)) {
        print "Nie mogę zapisać do pliku ($file)";
        exit;
    }
    fclose($file);
    $_SESSION["Step"] = 3;
    echo "<p>Plik konfiguracyjny utworzony. Strona zostanie odświeżona!</p>";
    echo "<script>
            setTimeout(function() {
                location.reload();
            }, 2500);
        </script>";
}

function ImportDataBase()
{
    echo "<p>Tworzenie bazy danych ...</p>";

    if (file_exists("DataBase/Sql.php")) {
        include("Configuration/Config.php");
        include("DataBase/Sql.php");

        echo "Tworzę tabele bazy: " . $database . ".<br>\n";
        mysqli_select_db($link, $database) or die(mysqli_error($link));
        for ($i = 0; $i < count($create); $i++) {
            echo "<p>" . $i . ". <code>" . $create[$i] . "</code></p>\n";
            mysqli_query($link, $create[$i]);
        }
        echo "<p>Baza została utworzona! Strona zostanie odświeżona</p>";
        echo "<script>
            setTimeout(function() {
                location.reload();
            }, 2500);
        </script>";
        $_SESSION["Step"] = 4;
    } else {
        echo "<p>Skrypt do tworzenia bazy nie istnieje!<br> Upewnij się że plik znajduje się w folderze: <code>DataBase</code></p>";
    }
}


function GenerateInstallDataForm()
{
    include("Configuration/InstallationResources/InstallData.php");
}

function ImportDataFromForm()
{
    $config = "\n# konfiguracja aplikacji\n
        \$baseUrl=\"" . $_POST['BaseUrl'] . "\";
        \$applicationName=\"" . $_POST['ApplicationName'] . "\";
        \$dateOfCreation=\"" . $_POST['DateOfCreation'] . "\";
        \$version=\"" . $_POST['Version'] . "\";
        \$companyName=\"" . $_POST['CompanyName'] . "\";
        \$companyStreet=\"" . $_POST['CompanyStreet'] . "\";
        \$companyCity=\"" . $_POST['CompanyCity'] . "\";
        \$companyPhone=\"" . $_POST['CompanyPhone'] . "\";
        ";
    if (is_writable(configFile)) {
        if (!$uchwyt = fopen(configFile, 'a')) {
            echo "Nie mogę otworzyć pliku (" . configFile . ")";
            exit;
        }
        if (fwrite($uchwyt, $config) == FALSE) {
            echo "Nie mogę zapisać do pliku (" . configFile . ")";
            exit;
        }
        echo "Sukces, zapisano (<code>konfigurację</code>) do pliku (" . configFile . "). Strona zostanie odświeżona";
        fclose($uchwyt);
        $_SESSION["Step"] = 6;
        echo "<script>
            setTimeout(function() {
                location.reload();
            }, 2500);
        </script>";
    } else {
        echo "Plik " . configFile . " nie jest zapisywalny! <br> Zmień uprawnienia i odśwież stronę!";
    }
}

function InsertAdminAccountToDataBase()
{
    include("Configuration/Config.php");

    $passwordHash = password_hash($_POST["Password"], PASSWORD_DEFAULT);
    $createDate = date('Y-m-d H:i:s');

    $insert[] = "INSERT INTO `" . $prefix . "Departments` (`Name`) VALUES ('" . $_POST["Department"] . "')";
    $insert[] .= "INSERT INTO `" . $prefix . "Users`(
        `Email`,
        `Password`,
        `FirstName`,
        `LastName`,
        `Role`,
        `Status`,
        `DepartmentId`,
        `CreatedOn`
    )
    VALUES(
        '" . $_POST["Email"] . "',
        '" . $passwordHash . "',
        '" . $_POST["FirstName"] . "',
        '" . $_POST["LastName"] . "',
        'Admin',
        '1',
        '1',
        '" . $createDate . "'
    )";

    mysqli_select_db($link, $database) or die(mysqli_error($link));
    for ($i = 0; $i < count($insert); $i++) {
        echo "<p>" . $i . ". <code>" . $insert[$i] . "</code></p>\n";
        mysqli_query($link, $insert[$i]);
    }

    echo "<p>Utworzono konto administratora! Strona zostanie odświeżona</p>";
    echo "<script>
            setTimeout(function() {
                location.reload();
            }, 2500);
        </script>";
    $_SESSION["Step"] = 7;
}

function FinishInstallationProcess()
{
    include("Configuration/InstallationResources/InstallFinish.php");
    session_destroy();
}
