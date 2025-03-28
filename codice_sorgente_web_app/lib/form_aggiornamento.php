<?php 
  ini_set ("display_errors", "On");
  ini_set("error_reporting", E_ALL);
  include_once ('funzioni.php'); 
  session_start();
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>servizio aggiornamento utenti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>

</head>
    <body>
        <?php
        ini_set("display_errors", "0");
        ini_set("error_reporting", "0");
        // se non vi e' una sessione valida aperta (presumibilmente in seguito ad un logout)
        // torno alla pagina di login
        if(!isset($_SESSION['user']) || $_SESSION['tipo_utente'] <> 'segreteria'){
            session_unset();
            $utente = null;
            header("Location:../index.php");
        } else {
            $utente = $_SESSION['user'];
        }

        if(isset($_GET['back'])){
            header("Location: aggiorna_utenti.php");
        }

        if (isset($_GET['user'])) {
            $dati = preleva_dati_utente($_GET['user']);
            $_SESSION['userold'] = $_GET['user'];
            if($dati['tipo_utente'] == 'studente'){ 
                $dati2 = preleva_dati_studente($_GET['user']); ?>
                <div class="container pt-1 pb-3 mt-5 border">
                <h3 class="text-center">Form aggiornamento utenti</h3>
                </br>
                <p class="text">Modifica i campi che si desidera modificare per l'utente <?php echo($_GET['user']) ?></p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" value="<?php echo $dati['username']?>" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="cdl" class="form-label">corso_di_laurea</label>
                        <input type="text" value="<?php echo $dati2['corso_di_laurea']?>" class="form-control" id="cdl" name="cdl">
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" value="<?php echo $dati2['nome']?>"class="form-control" id="nome" name="nome">
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">cognome</label>
                        <input type="text" value="<?php echo $dati2['cognome']?>"class="form-control" id="cognome" name="cognome">
                    </div>
                    <div class="mb-3">
                        <label for="e_mail" class="form-label">e-mail</label>
                        <input type="text" value="<?php echo $dati2['e_mail']?>" class="form-control" id="e_mail" name="e_mail">
                    </div>
                    <button type="submit" class="btn btn-primary">Invia</button>
                </form>
                </div>
            <?php
            }

            if($dati['tipo_utente'] == 'docente'){
                $dati2 = preleva_dati_docente($_GET['user']);?>
                <div class="container pt-1 pb-3 mt-5 border">
                <h3 class="text-center">Form aggiornamento utenti</h3>
                </br>
                <p class="text">Modifica i campi che si desidera modificare per l'utente <?php echo($_GET['user']) ?></p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" value="<?php echo $dati['username']?>" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" value="<?php echo $dati2['nome']?> "class="form-control" id="nome" name="nome">
                    </div>
                    <div class="mb-3">
                        <label for="cognome" class="form-label">cognome</label>
                        <input type="text" value="<?php echo $dati2['cognome']?>" class="form-control" id="cognome" name="cognome">
                    </div>
                    <div class="mb-3">
                        <label for="e_mail" class="form-label">e-mail</label>
                        <input type="text" value="<?php echo $dati2['e_mail']?>" class="form-control" id="e_mail" name="e_mail">
                    </div>

                    <button type="submit" class="btn btn-primary">Invia</button>
                </form>
                </div>
            <?php
            }
        }

        // se cdl non e' inserito l'usertype e' docente
        if(!isset($_POST['cdl']) && isset($_POST['username']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['e_mail'])){

            $esito = aggiorna_docente($_SESSION['userold'], $_POST['username'], $_POST['nome'], $_POST['cognome'], $_POST['e_mail']);

            switch($esito){

                case null:?>
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                    <div class="p-3 mb-3 text-bg-danger rounded-1">errore nell'aggiornamento</div>
                    </div>
                    <?php break;
                
                case "successo": ?>
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                    <div class="p-3 mb-3 text-bg-success rounded-1">aggiornamento riuscito</div>
                    </div>
                    <?php break;

                default: ?>
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                    <div class="p-3 mb-3 text-bg-danger rounded-1"><?php echo($esito) ?></div>
                    </div>
                    <?php break;
                }
            unset($_SESSION['userold']); 

            //   se cdl e' inserito si tratta di uno studente
        } else if(isset($_POST['cdl']) && isset($_POST['username']) && isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['e_mail'])){

            $esito = aggiorna_studente($_SESSION['userold'], $_POST['username'], $_POST['cdl'], $_POST['nome'], $_POST['cognome'], $_POST['e_mail']);

            switch($esito){

                case null:?>
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                    <div class="p-3 mb-3 text-bg-danger rounded-1">errore nell'aggiornamento</div>
                    </div>
                    <?php break;
                
                case "successo": ?>
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                    <div class="p-3 mb-3 text-bg-success rounded-1">aggiornamento riuscito</div>
                    </div>
                    <?php break;

                default: ?>
                    <div class="d-flex align-items-center justify-content-center" style="height: 150px;">
                    <div class="p-3 mb-3 text-bg-danger rounded-1"><?php echo($esito) ?></div>
                    </div>
                    <?php break;
                }
                unset($_SESSION['userold']); 
            } ?>
            
        <div class="d-flex mt-3 align-items-center justify-content-center">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" >        
                <button type="submit" id="back" name="back" class="btn btn-danger">torna alla pagina di selezione</button>
            </form>
        </div>
    
        <?php 