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
            <div class="card-header">Instalator systemu HelpDesk | Serwer i baza danych</div>
            <form name="installServerForm" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="card-body">
                    <div class="">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="Host" name="Host" placeholder="Host" required>
                            <label for="Host">Nazwa serwisu</label>
                            <p class="card-text text-start"><small class="text-muted">Host</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="DBName" name="DBName" placeholder="DBName" required>
                            <label for="DBName">Nazwa bazy danych</label>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="User" name="User" placeholder="User" required>
                            <label for="User">Nazwa użytkownika</label>
                            <p class="card-text text-start"><small class="text-muted">Nazwa użytkownika używana do logowania się do bazy danych</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="password" class="form-control" id="Password" name="Password" placeholder="Password" required>
                            <label for="Password">Hasło</label>
                            <p class="card-text text-start"><small class="text-muted">Hasło użytkownika używane do logowania się do bazy danych</small></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="form-floating">
                            <input type="Text" class="form-control" id="Prefix" name="Prefix" placeholder="Prefix">
                            <label for="Prefix">Prefix</label>
                            <p class="card-text text-start"><small class="text-muted">Prefix dla tabel</small></p>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" name="InstallServer" value="Kontynuuj" class="btn btn-outline-primary">
                </div>
            </form>
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