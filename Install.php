<?php

function url_origin($s, $use_forwarded_host = false)
{
    $ssl      = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
    $sp       = strtolower($s['SERVER_PROTOCOL']);
    $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
    $port     = $s['SERVER_PORT'];
    $port     = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
    $host     = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
    $host     = isset($host) ? $host : $s['SERVER_NAME'] . $port;
    return $protocol . '://' . $host;
}

function full_url($s, $use_forwarded_host = false)
{
    return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}

$url = pathinfo(full_url($_SERVER));

$base_url = $url['dirname'] . "/";
echo $base_url;
?>

<!-- Header file -->>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Custom css -->
    <link rel="stylesheet" href="/Scripts/css/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Install Helpdesk System</title>
</head>
<!-- Start of body tag and creating conatiner -->

<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <div class="card text-center">
            <div class="card-header">Instalator systemu HelpDesk</div>
            <form action="">
                <div class="card-body">
                    <div class="">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="Title" name="Title" placeholder="Title" required>
                            <label for="Title">Nazwa lub adres serwera</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="Title" name="Title" placeholder="Title" required>
                            <label for="Title">Nazwa bazy danych</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="Title" name="Title" placeholder="Title" required>
                            <label for="Title">Nazwa użytkownika</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="Title" name="Title" placeholder="Title" required>
                            <label for="Title">Hasło</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" name="Contiune" value="Kontynuuj" class="btn btn-outline-primary">
                </div>
            </form>
        </div>
    </div>
    <footer class="footer mt-auto py-3">
        <div id="special-container">

        </div>
        <div class="border-bottom pb-3 mb-3"></div>
        <p id="random-text" class="text-center text-muted">&copy; 2023 HelpDesk System</p>
    </footer>
</body>

</html>