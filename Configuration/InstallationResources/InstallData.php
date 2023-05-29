<?php

function urlOrigin( $s, $use_forwarded_host = false )
{
    $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
    $sp       = strtolower( $s['SERVER_PROTOCOL'] );
    $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
    $port     = $s['SERVER_PORT'];
    $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
    $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
    $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function fullUrl( $s, $use_forwarded_host = false )
{
    return urlOrigin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
}

$url = pathinfo(fullUrl( $_SERVER ));

$baseUrl = $url['dirname']."/";

?>

<!-- Header file -->>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous" data-bs-no-jquery="true"></script>

    <!-- JQuery 3.6.0 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Flastpicker css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">

    <!-- Flastpicker js -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
    <title>Install Helpdesk System</title>
</head>
<!-- Start of body tag and creating conatiner -->

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <div class="card text-center">
            <form name="installBaseDataForm" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="card-header">Instalator systemu HelpDesk | Dane aplikacji</div>
                <div class="card-body">
                    <div class="">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="ApplicationName" name="ApplicationName" placeholder="ApplicationName" required>
                            <label for="ApplicationName">Nazwa serwisu</label>
                            <p class="card-text text-start"><small class="text-muted">Nazwa aplikacji</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="BaseUrl" name="BaseUrl" value="<?php echo $baseUrl; ?>" placeholder="BaseUrl" required>
                            <label for="BaseUrl">Adres serwisu</label>
                            <p class="card-text text-start"><small class="text-muted">Adres domenowy</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="DateOfCreation" name="DateOfCreation" placeholder="DateOfCreation" value="<?php echo date('Y-m-d H:i:s'); ?>" required>
                            <label for="DateOfCreation">Data powstania</label>
                            <p class="card-text text-start"><small class="text-muted">Data powstania serwisu</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="Version" name="Version" placeholder="Version" required>
                            <label for="Version">Wersja</label>
                            <p class="card-text text-start"><small class="text-muted">Wersja aplikacji</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="CompanyName" name="CompanyName" placeholder="CompanyName">
                            <label for="CompanyName">Nazwa firmy</label>
                            <p class="card-text text-start"><small class="text-muted"></small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="CompanyStreet" name="CompanyStreet" placeholder="CompanyStreet">
                            <label for="CompanyStreet">Ulica</label>
                            <p class="card-text text-start"><small class="text-muted">Adres firmy (ulica)</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="CompanyCity" name="CompanyCity" placeholder="CompanyCity">
                            <label for="CompanyCity">Miasto, kod</label>
                            <p class="card-text text-start"><small class="text-muted">Adres firmy (Miast, kod)</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="CompanyPhone" name="CompanyPhone" placeholder="CompanyPhone">
                            <label for="CompanyPhone">Numer telefonu</label>
                            <p class="card-text text-start"><small class="text-muted">Numer telefonu firmowego</small></p>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card text-center mt-2">
            <div class="card-header">Konto administratora</div>
            <div class="card-body">
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Text" class="form-control" id="FirstName" name="FirstName" placeholder="FirstName" required>
                        <label for="FirstName">Imię</label>
                        <p class="card-text text-start"><small class="text-muted"></small></p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Text" class="form-control" id="LastName" name="LastName" placeholder="LastName" required>
                        <label for="LastName">Nazwisko</label>
                        <p class="card-text text-start"><small class="text-muted"></small></p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Text" class="form-control" id="Department" name="Department" placeholder="Department" required>
                        <label for="Department">Nazwa oddziału</label>
                        <p class="card-text text-start"><small class="text-muted">Nazwa oddziału dla administratora</small></p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Text" class="form-control" id="Email" name="Email" placeholder="Email" required>
                        <label for="Email">Adres email</label>
                        <p class="card-text text-start"><small class="text-muted"></small></p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating">
                        <input type="Password" class="form-control" id="Password" name="Password" placeholder="Password" required>
                        <label for="Password">Hasło</label>
                        <p class="card-text text-start"><small class="text-muted"></small></p>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="form-floating input-group">
                        <input type="Password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" placeholder="ConfirmPassword" required>
                        <label for="ConfirmPassword">Potwierdz hasło</label>
                        <p class="card-text text-start"><small class="text-muted"></small></p>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <input type="submit" name="InstallBaseData" value="Kontynuuj" class="btn btn-outline-primary">
            </div>
        </div>
        </form>
    </div>
</body>
<footer class="footer mt-auto py-3">
    <div id="special-container">

    </div>
    <div class="border-bottom pb-3 mb-3"></div>
    <p id="random-text" class="text-center text-muted">&copy; 2023 HelpDesk System</p>
</footer>

</html>