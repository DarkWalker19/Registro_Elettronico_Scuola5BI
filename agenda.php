<?php
    require_once "utils/utils.php";

    is_user_logged();

    function diag($id='', $eLate=false, $eReq=false, $isReq=false, $date='', $hour='', $motiv='', $state=''){ 
        $MIN_H = '8:00';
        $MAX_H = '16:00';
        $READONLY = check_role("admin") || $state == "In attesa" || $state == "Accettato" ? "" : "readonly";

        if(!is_bool($eLate) || !is_bool($isReq)) error("PHP_bad_diag_params_type");
        if($isReq && $eLate || $isReq && $motiv != '') error("PHP_diag_params_conflict");
        if($eLate && $date == null || $eLate && $hour == null || !$eLate && !$isReq && $date == null) error("PHP_insufficient_diag_params");

        $modalName = $isReq ? "reqModal" : $id . "Modal";

        $btnText = $isReq || $eReq ? "Richiedi" : "Apri";
        $title = $isReq || $eReq ? "Richiesta di Uscita Anticipata" : "Evento";
        $req_text = $eReq ? "<br><p>del <b>" . $date . "</b> alle ore <b>" . $hour . "</b></p>" : "";

                // Text before form
        $body = $eLate ? '<p>Entrata alle: <b>' . $hour . '</b> del <b>' . $date . '</b>' : ($isReq || $eReq ? '<p>Richiesta di Uscita Anticipata</p>' . $req_text : '<p>Assenza del: <b>' . $date . '</b></p>');
        $body .= '<br>';

        $body .= $isReq ?
                // Richiesta Uscita Anticipata
                '
                    <label for="date">Data</label><br>
                    <input type="date" id="date" name="date" required ' . $READONLY . '><br>
                    <label for="hour">Ora</label><br>
                    <input type="time" id="hour" name="hour" min="' . $MIN_H . '" max="' . $MAX_H . '" required ' . $READONLY . '><br>'
                : 
                // Assenza || Ritardo
                '
                <input type="hidden" id="id" name="id" value="' . $id . '" required>';

                // Motivazione
        $body .= '
                <label for="motivation">Motivazione</label><br>
                <input type="text" id="motivation" name="motivation" value=' . $motiv . ' required ' . $READONLY . '><br>';
        
        $approve = check_role('admin') && $state == "In attesa" ?
                    '<br>
                    <input type="radio" id="approve" name="m" value="a">
                    <label for="m">Accetta</label><br>
                    <input type="radio" id="deny" name="m" value="d">
                    <label for="m">Rifiuta</label><br>'
                    : '';
        
        $footer = $state == "In attesa" && !check_role("admin") || check_role('admin') && $state == "Accettato" || $state == "Rifiutato" ? 
                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>'
                    :
                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                    <input type="submit" value="Invia" class="btn btn-primary">';

        $diag = '
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#' . $modalName . '">
                ' . $btnText . '
            </button>            
            <form method="POST" action="/updateAssenza.php">
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

    function eventTable($section='', $events=[], $canUpdate=false){
        $eLate = false;
        $isReq = false;
        if ($section == 'r') $eLate = true;

        $table = "<table>";

        $tableHeaders = "<tr>
                    <th>Id</th><th>Stato</th><th>Data</th>";
        $tableHeaders .= $section == 'r' ? '<th>Ora Entrata</th>' : ($section == 'u' ? "<th>Ora Uscita</th>" : '');

        $tableHeaders .= "<th>Motivazione</th></tr>";

        $table .= $tableHeaders;

        $eventH = "";

        foreach($events as $record){
            $table .= "<tr>";
            $table .= "<td>" . $record['Id'] . "</td>";
            $table .= "<td>" . $record['Stato'] . "</td>";
            $table .= "<td>" . $record['Data'] . "</td>";
            
            if($section == 'r'){
                $eventH = $record['Ora_entrata'];
            }
            if($section == 'u'){
                $eventH = $record['Ora_escita'];
            }

            $table .= $eventH;

            $table .= "<td>" . $record['Motivazione'] . "</td>";

            $table .= $canUpdate ? diag($record['Id'], $eLate, $isReq, $record['Data'], $eventH, $record['Motivazione'], $record['Stato']) : '';
// aggiungere tasto rimuovi
            $table .= "</tr>";
        }
        $table .= "</table>";

        return $table;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Agenda</title>
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
            $canUpdate = $_SESSION['adult'] || check_role('parent');

            $con = get_PDO_connection();

            if(isset($_GET['section'])){

                $section = $_GET['section'];

                switch($section){
                    case 'a':
                        // Tabella Assenze
                        echo "<h1>Assenze</h1>";
                        $qry = 'SELECT * FROM Evento WHERE Tipo = "Assenza"';
                        
                        $stm = $con->query($qry);
                        if($stm->rowCount() > 0){
                            $events = $stm->fetchAll();
                            echo eventTable($section, $events, $canUpdate);
                        }
                        else
                            echo "<p>Non ci sono Assenze</p>";

                        break;
        
                    case 'r':
                        // Tabella Ritardi  
                        echo "<h1>Ritardi</h1>";
                        $qry = 'SELECT * FROM Evento WHERE  Tipo = "Ritardo"';
                        
                        $stm = $con->query($qry);
                        if($stm->rowCount() > 0){
                            $events = $stm->fetchAll();
                            echo eventTable($section, $events, $canUpdate);
                        }
                        else
                            echo "<p>Non ci sono Ritardi</p>";

                        break;
                    
                    case 'u':
                        // Tabella Uscite
                        echo "<h1>Richieste di Uscita Anticipata</h1>";
                        $qry = 'SELECT * FROM Evento WHERE  Tipo = "Ritardo"';
                        
                        $stm = $con->query($qry);
                        if($stm->rowCount() > 0){
                            $events = $stm->fetchAll();
                            echo eventTable($section, $events, $canUpdate);
                        }
                        else
                            echo "<p>Non ci sono Richieste di Uscita Anticipata</p>";

                        break;

                    case 'c':
                        // Tabella Classi
                        is_user_admin();

                        $class = $_GET['class'];
                        $student = $_GET['m'];

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