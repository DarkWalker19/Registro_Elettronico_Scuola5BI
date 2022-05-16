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
                    <th>Id</th><th>Stato</th><th>Data</th>";
        $tableHeaders .= $section == 'r' ? '<th>Ora Entrata</th>' : ($section == 'u' ? "<th>Ora Uscita</th>" : '');

        $tableHeaders .= "<th>Motivazione</th></tr>";

        $table .= $tableHeaders;

        foreach($events as $record){
            $table .= "<tr>";
            $table .= "<td>" . $record['Id'] . "</td>";
            $table .= "<td>" . $record['Stato'] . "</td>";
            $table .= "<td>" . $record['Data'] . "</td>";

            $table .= "<td>";
            $table .= $section == 'r' ? $record['Ora_entrata'] : ($section == 'u' ? $record['Ora_uscita'] : '');
            $table .= "</td>";

            $table .= "<td>" . $record['Motivazione'] . "</td>";

            if($section == 'a'){
                $table .= "<td>" . assenza_diag($record['Id'], $record['Data'], $record['Motivazione'], $record['Stato']) . "</td>";
                $updateLink = "Assenza";
            }
            else if($section == 'r'){
                $table .= "<td>" . ritardo_diag($record['Id'], $record['Data'], $record['Ora_entrata'], $record['Motivazione'], $record['Stato']) . "</td>";
                $updateLink = "Ritardo";
            }
            else if($section == 'u'){
                $table .= "<td>" . uscita_diag($record['Id'], $record['Data'], $record['Ora_uscita'], $record['Motivazione'], $record['Stato']) . "</td>";
                $updateLink = "Uscita";
            }
            else
                error("invalid_section_on_etbl_creation");
            
            if(check_role("admin")) $table .= "<td><button onclick=\"location.href='update" . $updateLink . ".php?mode=r&id=" . $record['Id'] . "'\">Rimuovi</button></td>";

            $table .= "</tr>";
        }
        $table .= "</table>";

        return $table;
    }

    //change
    function studentTable($section='', $events=[]){
        $table = "<table>";

        $tableHeaders = "<tr>
                    <th>Id</th><th>Stato</th><th>Data</th>";
        $tableHeaders .= $section == 'r' ? '<th>Ora Entrata</th>' : ($section == 'u' ? "<th>Ora Uscita</th>" : '');

        $tableHeaders .= "<th>Motivazione</th></tr>";

        $table .= $tableHeaders;

        foreach($events as $record){
            $table .= "<tr>";
            $table .= "<td>" . $record['Id'] . "</td>";
            $table .= "<td>" . $record['Stato'] . "</td>";
            $table .= "<td>" . $record['Data'] . "</td>";

            $table .= "<td>";
            $table .= $section == 'r' ? $record['Ora_entrata'] : ($section == 'u' ? $record['Ora_uscita'] : '');
            $table .= "</td>";

            $table .= "<td>" . $record['Motivazione'] . "</td>";

            if($section == 'a'){
                $table .= "<td>" . assenza_diag($record['Id'], $record['Data'], $record['Motivazione'], $record['Stato']) . "</td>";
                $updateLink = "Assenza";
            }
            else if($section == 'r'){
                $table .= "<td>" . ritardo_diag($record['Id'], $record['Data'], $record['Ora_entrata'], $record['Motivazione'], $record['Stato']) . "</td>";
                $updateLink = "Ritardo";
            }
            else if($section == 'u'){
                $table .= "<td>" . uscita_diag($record['Id'], $record['Data'], $record['Ora_uscita'], $record['Motivazione'], $record['Stato']) . "</td>";
                $updateLink = "Uscita";
            }
            else
                error("invalid_section_on_etbl_creation");
            
            if(check_role("admin")) $table .= "<td><button onclick=\"location.href='update" . $updateLink . ".php?mode=r&id=" . $record['Id'] . "'\">Rimuovi</button></td>";

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
                            $qry = 'SELECT * FROM appartenere WHERE U_Matricola = ? AND C_Id = ?';
                            $stm = $db->prepare($qry);
                            $stm->execute([$_SESSION['user'], $_GET['class']]);

                            if($stm->rowCount() > 0){
                                $events = $stm->fetchAll();
                                echo $_GET['class'];
                                //echo eventTable($section, $events, $canUpdate);
                            }
                            else
                                error('class_not_belong_to_user');
                        }
                        else{
                            $qry = 'SELECT Anno, Sezione FROM appartenere INNER JOIN classe ON (C_Id = Id) WHERE U_Matricola = "?"';
                            $stm = $db->prepare($qry);
                            $stm->execute([$_SESSION['user']]);

                            if($stm->rowCount() > 0){
                                $events = $stm->fetchAll();
                                echo "tante classi";
                                //echo eventTable($section, $events, $canUpdate);
                            }
                            else
                                echo "<p>Non appartieni a nessuna Classe</p>";
                        }
                        

                        //aggiungere controlli per focussare la ricerca

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