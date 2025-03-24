<?php 
  ini_set ("display_errors", "On");
  ini_set("error_reporting", E_ALL);
  include_once ('lib/funzioni.php'); 
  session_start();

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>piattaforma universitaria segreteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

  </head>
    <body>

        <?php

         // se l'utente fa logout, inizializza la sessione
        if(isset($_GET) && isset($_GET['log']) && $_GET['log'] == 'del'){
            // unset($_SESSION['user']);
            session_unset();
            $utente=null;

        }
        
        // se non vi e' una sessione valida aperta (presumibilmente in seguito ad un logout)
        // torno alla pagina di login
        if(!isset($_SESSION['user']) || $_SESSION['tipo_utente'] <> 'segreteria'){
            session_unset();
            $utente = null;
            header("Location:index.php");
        } else {
            $utente = $_SESSION['user'];
        }

        // se utente e' loggato, prepara link per logout
        if(isset($utente)){
        $logout_link=$_SERVER['PHP_SELF']."?log=del";
        ?>

        <div class="container mt-5">
          <div class="alert alert-primary" role="alert">
            <?php
                $dati = preleva_dati_segreteria($utente)
                
            ?>  
                <!-- stampa messaggio di benvenuto, e link di logout -->
                <?php echo("Benvenuto $utente"); ?> <br> 
                <a href ="<?php echo($logout_link); ?>" class="alert-link"> Logout </a>
          </div>
        </div>
        
        <!-- corpo con i dati -->
        <div class="container pt-3">
            <h3 class="text">- I tuoi dati</h3>
            <div class="container border">
                <div class="row">        
                        <div class="col p-2">
                            
                                Nome: <?php echo($dati["nome"])?>
                                <br>
                                Cognome: <?php echo($dati["cognome"])?>
                                <br>
                                ID: <?php echo($dati["id"])?>
                            
                        </div>
                        <div class="col">
                            Servizi utente: <br>
                            <a href ="<?php echo("lib/cambio_password.php"); ?>" class="link-primary"> cambia password</a>
                        </div>
                </div>
            </div>
        </div>
        <?php
        } 
        ?>
        <div class="container mt-5">
          <h3> - operazioni</h3>
          <nav class="navbar navbar-expand-lg bg-body-tertiary">
              <div class="container-fluid">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                      <li class="nav-item">
                      <a class="nav-link" href="segreteria.php">Home</a>
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown" aria-expanded="false">gestione utenti</a>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="lib/inserisci_utenti.php">inserisci utente</a></li>
                              <li><a class="dropdown-item" href="lib/rimuovi_utenti.php">rimuovi utente</a></li>
                              <li><a class="dropdown-item" href="lib/aggiorna_utenti.php">aggiorna utente</a></li>
                          </ul>
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown" aria-expanded="false">gestione corsi di laurea</a>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="lib/inserisci_corso.php">inserisci corso</a></li>
                              <li><a class="dropdown-item" href="lib/aggiorna_corso.php">aggiorna corso</a></li>
                          </ul>
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown" aria-expanded="false">gestione insegnamenti</a>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="lib/inserisci_insegnamento.php">inserisci insegnamento</a></li>
                              <li><a class="dropdown-item" href="lib/aggiorna_insegnamento.php">aggiorna insegnamento</a></li>
                              <li><a class="dropdown-item" href="lib/inserisci_propedeuticita.php">inserisci propedeuticita</a></li>
                              <li><a class="dropdown-item" href="lib/rimuovi_propedeuticita.php">rimuovi propedeuticita</a></li>
                          </ul>
                      </li>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle"  role="button" data-bs-toggle="dropdown" aria-expanded="false">carriere studenti</a>
                          <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="lib/carriere_complete_seg.php">carriere complete studenti</a></li>
                              <li><a class="dropdown-item" href="lib/carriere_valide_seg.php">carriere valide studenti</a></li>
                          </ul>
                      </li>
                  </ul>
              </div>
          </nav>
      </div> 
    </body>
</html>