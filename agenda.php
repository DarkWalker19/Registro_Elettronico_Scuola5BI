<?php
    require_once "utils/utils.php";

    is_user_logged();

    function assenza_diag($id='', $date='', $motiv='', $state=''){
        if(!isset($id) || !isset($date) || !isset($state)) error("PHP_insufficient_assenza_diag_params");
        
        $READONLY = check_role("admin") || $state == "In attesa" || $state == "Accettato" ? "readonly" : "";
        $CANUPDATE = check_role("admin") || check_role("parent") || $_SESSION['adult'];

        $formAction = "/updateAssenza.php";

        $modalName = $id . "Modal";

        $btnText = "Apri";
        $title = "Assenza";
        
        // Text before form
        $body = '<p>Assenza del: <b>' . $date . '</b></p>';
        $body .= '<br>';

        // Id Evento
        $body .= '
                <input type="hidden" id="id" name="id" value="' . $id . '" required>';

        // Motivazione
        $body .= '
                <label for="motivation">Motivazione</label><br>
                <textarea cols="50" rows="4" id="motivation" name="motivation" required ' . $READONLY . '>' . $motiv . '</textarea><br>';
        
        $approve = check_role('admin') && $state == "In attesa" ?
                    '<br>
                    <input type="radio" id="approve" name="m" value="a">
                    <label for="m">Accetta</label><br>
                    <input type="radio" id="deny" name="m" value="d">
                    <label for="m">Rifiuta</label><br>'
                    : '';
        
        $footer = $state == "In attesa" && !check_role("admin") ||
                            check_role('admin') && $state == "Accettato" || 
                            check_role('admin') && $state == "Rifiutato" || 
                            check_role('admin') && $state == "Da giustificare" || 
                            $CANUPDATE && $state == "Accettato" || 
                            !$CANUPDATE ? 
                                '<button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>'
                                :
                                '<button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                                <input type="submit" value="Invia" class="btn btn-primary">';

        $diag = '
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $modalName . '">
                ' . $btnText . '
            </button>            
            <form method="POST" action="' . $formAction . '">
                <div class="modal fade" id="' . $modalName . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalName . 'Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="' . $modalName . 'Label">' . $title . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            ' . $body . '
                            ' . $approve . '
                        </div>
                        <div class="modal-footer">
                        ' . $footer . '
                        </div>
                    </div>
                    </div>
                </div>
            </form>';
        return $diag;
    }

    function ritardo_diag($id='', $date='', $hour='', $motiv='', $state=''){ 
        if(!isset($id) || !isset($date) || !isset($hour) || !isset($state)) error("PHP_insufficient_assenza_diag_params");

        $READONLY = check_role("admin") || $state == "In attesa" || $state == "Accettato" ? "readonly" : "";
        $CANUPDATE = check_role("admin") || check_role("parent") || $_SESSION['adult'];

        $formAction = "/updateRitardo.php";

        $modalName = $id . "Modal";

        $btnText = "Apri";
        $title = "Ritardo";

        // Text before form
        $body = '<p>Entrata alle: <b>' . $hour . '</b> del <b>' . $date . '</b></p>';
        $body .= '<br>';

        // Id Evento
        $body .= '
                <input type="hidden" id="id" name="id" value="' . $id . '" required>';

        // Motivazione
        $body .= '
                <label for="motivation">Motivazione</label><br>
                <textarea cols="50" rows="4" id="motivation" name="motivation" required ' . $READONLY . '>' . $motiv . '</textarea><br>';
        
        $approve = check_role('admin') && $state == "In attesa" ?
                    '<br>
                    <input type="radio" id="approve" name="m" value="a">
                    <label for="m">Accetta</label><br>
                    <input type="radio" id="deny" name="m" value="d">
                    <label for="m">Rifiuta</label><br>'
                    : '';
        
        $footer = $state == "In attesa" && !check_role("admin") ||
                    check_role('admin') && $state == "Accettato" || 
                    check_role('admin') && $state == "Rifiutato" || 
                    check_role('admin') && $state == "Da giustificare" ||
                    $CANUPDATE && $state == "Accettato" || 
                    !$CANUPDATE ? 
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>'
                        :
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <input type="submit" value="Invia" class="btn btn-primary">';

        $diag = '
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $modalName . '">
                ' . $btnText . '
            </button>            
            <form method="POST" action="' . $formAction . '">
                <div class="modal fade" id="' . $modalName . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalName . 'Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="' . $modalName . 'Label">' . $title . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            ' . $body . '
                            ' . $approve . '
                        </div>
                        <div class="modal-footer">
                        ' . $footer . '
                        </div>
                    </div>
                    </div>
                </div>
            </form>';
        return $diag;
    }

    function uscita_diag($id='', $date='', $hour='', $motiv='', $state=''){ 
        if(!isset($id) || !isset($date) || !isset($hour) || !isset($state)) error("PHP_insufficient_assenza_diag_params");

        $MIN_H = '8:00';
        $MAX_H = '16:00';
        $READONLY = check_role("admin") || $state == "In attesa" || $state == "Accettato" ? "readonly" : "";
        $CANUPDATE = check_role("admin") || check_role("parent") || $_SESSION['adult'];

        $formAction = "/updateUscita.php";

        $modalName = $id . "Modal";

        $btnText = "Apri";
        $title = "Uscita Anticipata";
        $req_text = "";

        // Text before form
        $body = '<p>Richiesta di Uscita Anticipata</p>' . $req_text;
        $body .= '<br>';

        // Richiesta Uscita Anticipata
        $body .= '
                    <label for="date">Data</label><br>
                    <input type="date" id="date" name="date" value="' . $date . '" required ' . $READONLY . '><br>
                    <label for="hour">Ora</label><br>
                    <input type="time" id="hour" name="hour" min="' . $MIN_H . '" max="' . $MAX_H . '" value="' . $hour . '" required ' . $READONLY . '><br>';
        
        // Id Evento
        $body .= '<input type="hidden" id="id" name="id" value="' . $id . '" required>';

        // Motivazione
        $body .= '
                <label for="motivation">Motivazione</label><br>
                <textarea cols="50" rows="4" id="motivation" name="motivation" required ' . $READONLY . '>' . $motiv . '</textarea><br>';
        
        $approve = check_role('admin') && $state == "In attesa" ?
                    '<br>
                    <input type="radio" id="approve" name="m" value="a">
                    <label for="m">Accetta</label><br>
                    <input type="radio" id="deny" name="m" value="d">
                    <label for="m">Rifiuta</label><br>'
                    : '';
        
        $footer = $state == "In attesa" && !check_role("admin") ||
                    check_role('admin') && $state == "Accettato" || 
                    check_role('admin') && $state == "Rifiutato" || 
                    check_role('admin') && $state == "Da giustificare" ||
                    $CANUPDATE && $state == "Accettato" || 
                    !$CANUPDATE ? 
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>'
                        :
                        '<button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                        <input type="submit" value="Invia" class="btn btn-primary">';

        $diag = '
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $modalName . '">
                ' . $btnText . '
            </button>            
            <form method="POST" action="' . $formAction . '">
                <div class="modal fade" id="' . $modalName . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalName . 'Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="' . $modalName . 'Label">' . $title . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            ' . $body . '
                            ' . $approve . '
                        </div>
                        <div class="modal-footer">
                        ' . $footer . '
                        </div>
                    </div>
                    </div>
                </div>
            </form>';
        return $diag;
    }

    //make another diag with forms
    function state_diag($mat='', $state=''){
        if(!isset($id) || !isset($date) || !isset($state)) error("PHP_insufficient_assenza_diag_params");

        $modalName = "stateModal";

        $btnText = $state;
        $title = "Stato";
        
        $footer = '<button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>';

        $diag = '
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $modalName . '">
                ' . $btnText . '
            </button>            
                <div class="modal fade" id="' . $modalName . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalName . 'Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="' . $modalName . 'Label">' . $title . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                        ' . $footer . '
                        </div>
                    </div>
                    </div>
                </div>';
        return $diag;
    }
// aggiungere limite min x data e fixare orario
    function req_uscita_diag(){ 
        $MIN_H = '8:00';
        $MAX_H = '16:00';

        $formAction = "/addUscita.php";

        $modalName = "reqModal";

        $btnText = "Richiedi";
        $title = "Uscita Anticipata";

        // Text before form
        $body = '<p>Richiesta di Uscita Anticipata</p>';
        $body .= '<br>';

        // Richiesta Uscita Anticipata
        $body .= '
                    <label for="date">Data</label><br>
                    <input type="date" id="date" name="date" required><br>
                    <label for="hour">Ora</label><br>
                    <input type="time" id="hour" name="hour" min="' . $MIN_H . '" max="' . $MAX_H . '" required><br>';

        // Motivazione
        $body .= '
                <label for="motivation">Motivazione</label><br>
                <textarea cols="50" rows="4" id="motivation" name="motivation" required></textarea><br>';
        
        $footer = '
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                    <input type="submit" value="Invia" class="btn btn-primary">';

        $diag = '
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $modalName . '">
                ' . $btnText . '
            </button>            
            <form method="POST" action="' . $formAction . '">
                <div class="modal fade" id="' . $modalName . '" tabindex="-1" role="dialog" aria-labelledby="' . $modalName . 'Label" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="' . $modalName . 'Label">' . $title . '</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            ' . $body . '
                        </div>
                        <div class="modal-footer">
                        ' . $footer . '
                        </div>
                    </div>
                    </div>
                </div>
            </form>';
        return $diag;
    }

    function eventTable($section='', $events=[]){
        $table = "<table>";

        $tableHeaders = "<tr>
                    <th>Id</th><th>Tipo</th><th>Stato</th><th>Data</th>";
        $tableHeaders .= $section == 'r' ? '<th>Ora Entrata</th>' : ($section == 'u' ? "<th>Ora Uscita</th>" : '');
        if($section == '') $tableHeaders .= '<th>Ora Entrata</th><th>Ora Uscita</th>';

        $tableHeaders .= "<th>Motivazione</th></tr>";

        $table .= $tableHeaders;

        foreach($events as $record){
            $table .= "<tr>";
            $table .= "<td><p>" . $record['Id'] . "</p></td>";
            $table .= "<td><p>" . $record['Tipo'] . "</p></td>";
            $table .= "<td><p>" . $record['Stato'] . "</p></td>";
            $table .= "<td><p>" . $record['Data'] . "</p></td>";

            if($section == 'a' || $section == '' && $record['Tipo'] == "Assenza"){
                if($section == '') $table .= "<td></td><td></td>";

                $table .= "<td><p>" . $record['Motivazione'] . "</p></td>";
                $table .= "<td>" . assenza_diag($record['Id'], $record['Data'], $record['Motivazione'], $record['Stato']) . "</td>";

                $updateLink = "Assenza";
            }
            else if($section == 'r' || $section == '' && $record['Tipo'] == "Ritardo"){
                $table .= "<td><p>" . $record['Ora_entrata'] . "</p></td>";
                if($section == '') $table .= "<td></td>";

                $table .= "<td><p>" . $record['Motivazione'] . "</p></td>";
                $table .= "<td>" . ritardo_diag($record['Id'], $record['Data'], $record['Ora_entrata'], $record['Motivazione'], $record['Stato']) . "</td>";
                
                $updateLink = "Ritardo";
            }
            else if($section == 'u' || $section == '' && $record['Tipo'] == "Uscita"){
                if($section == '') $table .= "<td></td>";
                $table .= "<td><p>" . $record['Ora_uscita'] . "</p></td>";

                $table .= "<td><p>" . $record['Motivazione'] . "</p></td>";
                $table .= "<td>" . uscita_diag($record['Id'], $record['Data'], $record['Ora_uscita'], $record['Motivazione'], $record['Stato']) . "</td>";

                $updateLink = "Uscita";
            }

            if(check_role("admin")) $table .= "<td><button onclick=\"location.href='update" . $updateLink . ".php?mode=r&id=" . $record['Id'] . "'\">Rimuovi</button></td>";

            $table .= "</tr>";
        }
        $table .= "</table>";

        return $table;
    }

    function studentClassTable($section='', $records=[]){
        $table = "<table>";

        if($section == 's')
            $tableHeaders = "<tr><th>Num</th><th>Nome</th><th>Cognome</th><th>Stato</th></tr>";
        else if($section == 'c')
            $tableHeaders = "<tr><th>Classe</th></tr>";
        else
            error("bad_section_studentTable");

        $table .= $tableHeaders;

        $counter = 1;
        foreach($records as $record){
            $table .= "<tr>";

            if($section == 's'){

                $qry = 'SELECT Id, Tipo FROM evento AS e 
                        WHERE (U_Matricola = ? AND e.Data = CURDATE())';
                
                $db = get_PDO_connection();
                $stm = $db->prepare($qry);
                $stm->execute([$record['Matricola']]);

                if($stm->rowCount() > 0)
                    $event = $stm->fetch();
                else
                    $event = null;

                $table .= "<td><p>" . $counter . "</p></td>";
                $table .= "<td><p>" . $record['Nome'] . "</p></td>";
                $table .= "<td><p>" . $record['Cognome'] . "</p></td>";
                $state = isset($event) ? $event['Tipo'] : "Presenza";
                $table .= "<td><p>" . $state . "</p></td>";

                // aggiungere stato cliccabile con diag/selezione stato
                $table .= "<td><button onclick='window.location.href = \"?section=s&mat=" . $record['Matricola'] . "\"'>Eventi</button></td>";
                // view degli eventi dello studente
                $counter++;
            }
            else
                $table .= "<td><p onclick='window.location.href = \"?section=c&class=" . $record['Id'] . "\"'>" . $record['Anno'] . $record['Sezione'] . "</p></td>";
        
            $table .= "</tr>";
        }
        $table .= "</table>";

        return $table;
    }
?>
<html>
    <head>
        <title>Agenda</title>
        <?php
            print_metadata();
            get_css();
        ?>
            <script>
                let today = '<?php
                    echo date("Y-m-d");
                ?>';
                let datePicker = document.getElementById('date');
                datePicker.setAttribute("min", today);
                datePicker.setAttribute("value", today);
                document.getElementById('hour').setAttribute("value", "08:00");
            </script>
    </head>
    <body>
        <?php
            print_header();
            
            $isAdmin = check_role('admin');
            $student = $isAdmin ? null : (check_role('parent') ? $_SESSION['son'] : $_SESSION['user']);

            $db = get_PDO_connection();

            if(isset($_GET['section'])){

                $section = $_GET['section'];

                switch($section){
                    case 'a':
                        // Tabella Assenze
                        if($isAdmin) error("forbidden_page");

                        echo "<h1>Assenze</h1>";

                        $qry = 'SELECT * FROM evento WHERE Tipo = "Assenza" AND U_Matricola = ?';
                        $stm = $db->prepare($qry);
                        $stm->execute([$student]);

                        if($stm->rowCount() > 0){
                            $events = $stm->fetchAll();
                            echo eventTable($section, $events);
                        }
                        else
                            echo "<p>Non ci sono Assenze</p>";

                        break;
        
                    case 'r':
                        // Tabella Ritardi
                        if($isAdmin) error("forbidden_page");

                        echo "<h1>Ritardi</h1>";

                        $qry = 'SELECT * FROM evento WHERE Tipo = "Ritardo" AND U_Matricola = ?';
                        $stm = $db->prepare($qry);
                        $stm->execute([$student]);
                        
                        if($stm->rowCount() > 0){
                            $events = $stm->fetchAll();
                            echo eventTable($section, $events);
                        }
                        else
                            echo "<p>Non ci sono Ritardi</p>";

                        break;
                    
                    case 'u':
                        // Tabella Uscite
                        if($isAdmin) error("forbidden_page");

                        echo "<h1>Richieste di Uscita Anticipata</h1>";

                        if($_SESSION['adult']||check_role('parent'))
                            echo req_uscita_diag();

                        $qry = 'SELECT * FROM evento WHERE Tipo = "Uscita" AND U_Matricola = ?';
                        $stm = $db->prepare($qry);
                        $stm->execute([$student]);

                        if($stm->rowCount() > 0){
                            $events = $stm->fetchAll();
                            echo eventTable($section, $events);
                        }
                        else
                            echo "<p>Non ci sono Richieste di Uscita Anticipata</p>";

                        break;

                    case 'c':
                        // Tabella Classi
                        is_user_admin();

                        if(isset($_GET['class'])){
                            $qry = 'SELECT Matricola, Nome, Cognome FROM appartenere AS a 
                                    INNER JOIN classe AS c ON (c.Id = a.C_Id) 
                                    INNER JOIN utente AS u ON (u.Matricola = a.U_Matricola)
                                    WHERE C_Id = ? AND u.Tipo = "student"';
                            $stm = $db->prepare($qry);
                            $stm->execute([$_GET['class']]);

                            if($stm->rowCount() > 0){
                                $records = $stm->fetchAll();
                                echo studentClassTable('s', $records);
                            }
                            else
                                echo "<p>Non ci sono studenti appartenenti a questa classe</p>";
                                //error('class_not_bounded_to_user');
                        }
                        else{
                            $qry = 'SELECT * FROM appartenere INNER JOIN classe ON (C_Id = Id) WHERE U_Matricola = ?';
                            $stm = $db->prepare($qry);
                            $stm->execute([$_SESSION['user']]);

                            if($stm->rowCount() > 0){
                                $records = $stm->fetchAll();
                                echo studentClassTable('c', $records);
                            }
                            else
                                echo "<p>Non appartieni a nessuna Classe</p>";
                        }
                        

                        //aggiungere controlli per focussare la ricerca

                        break;

                        // creare sezione s per vis eventi stud
                    case 's':
                        //if(!isset($_GET['mat'])) error("matricola_not_provided");

                        $qry = $qry = 'SELECT * FROM evento WHERE U_Matricola = ?';
                        $stm = $db->prepare($qry);
                        $stm->execute([$_GET['mat']]);
                        
                        if($stm->rowCount() > 0){
                            $records = $stm->fetchAll();
                            echo eventTable('', $records);
                        }
                        else
                            echo "<p>Non esistono eventi per questo utente</p>";

                        break;

                    default:
                        error("bad_section");
                        break;
                }
            }
            print_footer();
        ?>
    </body> 
</html>  