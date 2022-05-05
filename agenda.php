<?php
    require "utils/utils.php";

    is_user_logged();

    function diag($id, $type, $date=null, $hour=null, $isReq=false, $motiv=null){
        // Fare una unica roba perchè così fa schifissimo :) Lazy Serci
        // motiv in motivazione.value -> se rifiutato l'evento
        if($isReq){
            echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reqModal">
                                Richiesta
                            </button>
                            
                            <form method="POST" action="/updateAssenza.php">
                                <div class="modal fade" id="reqModal" tabindex="-1" role="dialog" aria-labelledby="reqModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="reqModalLabel">Richiesta ' . $type . '</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Richiesta di Uscita Anticipata</p>
                                            <label for="date">Data</label><br>
                                            <input type="date" id="date" name="date" required><br>
                                            <label for="hour">Ora</label><br>
                                            <input type="time" id="hour" name="hour" min="8:00" max="16:00" required><br>
                                            <label for="motivation">Motivazione</label><br>
                                            <input type="text" id="motivation" name="motivation" required><br>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                                        <input type="submit" value="Invia" class="btn btn-primary">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>';
        }
        else{
            $rAdditText = $type == "Ritardo" ? '<p>Entrata alle: ' . $hour . '</p>' : '';

            echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                Giustifica
                            </button>
                            
                            <form method="POST" action="/updateAssenza.php">
                                <div class="modal fade" id="' . $id . 'Modal" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'ModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="' . $id . 'ModalLabel">Giustifica ' . $type . '</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" id="id" name="id" value="' . $id . '" required>
                                            <p>' . $type . ' del ' . $date . '</p>
                                            ' . $rAdditText . '
                                            <label for="motivation">Motivazione</label><br>
                                            <input type="text" id="motivation" name="motivation" required><br>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                                        <input type="submit" value="Invia" class="btn btn-primary">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </form>';
        }
    }
?>
<html>
    <head>
        <title>Agenda</title>
            <?php
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
            $isOld = check_role('student_old') || check_role('parent');

            $con= get_PDO_connection();

            if(isset($_GET['section'])){

                $section = $_GET['section'];
        
                switch($section){
                    case 'a':
                        // tabella assenza
                        echo "<h1>Assenze</h1>";
                        $qry = 'SELECT * FROM Evento WHERE Tipo = "Assenza"';
                        
                        $stm = $con->query($qry);
                        
                        $list = $stm->fetchAll();
                        echo "<table>";
                        echo "<tr><th>Id</th><th>Stato</th><th>Data</th><th>Motivazione</th></tr>";
                        foreach($list as $record){
                            echo "<tr>";
                            echo "<td>" . $record['Id'] . "</td>";
                            echo "<td>" . $record['Stato'] . "</td>";
                            echo "<td>" . $record['Data'] . "</td>";
                            echo "<td>" . $record['Motivazione'] . "</td>";

                            if($isOld) diag($record['Id'], "Assenza", $record['Data']);

                            echo "</tr>";
                        }
                        echo "</table>";
                        break;
        
                    case 'r':
                        // tabella ritardo  
                        echo "<h1>Ritardo</h1>";
                        $qry = 'SELECT * FROM Evento WHERE  Tipo = "Ritardo"';
                        
                        $stm = $con->query($qry);
                        
                        $list = $stm->fetchAll();
                        echo "<table>";
                        echo "<tr><th>Id</th><th>Stato</th><th>Data</th><th>Ora Entrata</th><th>Motivazione</th></tr>";
                        foreach($list as $record){
                            echo"<tr>";
                            echo "<td>" . $record['Id'] . "</td>";
                            echo "<td>" . $record['Stato'] . "</td>";
                            echo "<td>" . $record['Data'] . "</td>";
                            echo "<td>" . $record['Ora_entrata'] . "</td>";
                            echo "<td>" . $record['Motivazione'] . "</td>";
                            echo"</tr>";
                        }
                        echo "</table>";
                        break;
                    
                    case 'u':
                        // tabella uscite
                        echo "<h1>Uscite</h1>";
                        $qry = 'SELECT * FROM Evento WHERE  Tipo = "Ritardo"';
                        
                        $stm = $con->query($qry);
                        
                        $list = $stm->fetchAll();
                        echo "<table>";
                        echo "<tr><th>Id</th><th>Stato</th><th>Data</th><th>Ora Uscita</th><th>Motivazione</th></tr>";
                        foreach($list as $record){
                            echo "<tr>";
                            echo "<td>" . $record['Id'] . "</td>";
                            echo "<td>" . $record['Stato'] . "</td>";
                            echo "<td>" . $record['Data'] . "</td>";
                            echo "<td>" . $record['Ora_uscita'] . "</td>";
                            echo "<td>" . $record['Motivazione'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        break;
        
                    default:
                        error("bad_section");
                        break;
                }
            }
        ?>
    </body> 
</html>  