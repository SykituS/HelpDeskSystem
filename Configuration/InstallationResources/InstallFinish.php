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
            <div class="card-header">Instalator systemu HelpDesk | Zakończono</div>
            <div class="card-body">
                <div class="card-text">Pomyślnie ukończono instalację aplikacji</div>
                <div class="card-text">Do zalogowania się proszę uzyć utworzonego przed chwilą konta administratora: <?php echo $_POST["Email"] ?></div>
                <div class="card-text">
                    Po zamknięciu tej strony można usunąć następujące pliki: <br>
                    Plik: <code>Install.php</code><br>
                    Folder: <code>InstallationResources</code> znajdujący się w folderze <code>Configuration</code>
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php" class="btn btn-outline-primary">Zakończ instalacje i przejdź do aplikacji</a>
            </div>
        </div>
    </div>
</body>
<footer class="footer mt-auto py-3">
    <div id="special-container">

    </div>
    <div class="border-bottom pb-3 mb-3"></div>
    <p id="random-text" class="text-center text-muted">&copy; 2023 HelpDesk System</p>
</footer>

</html>