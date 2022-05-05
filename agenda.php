<?php
    require "utils/utils.php";
?>
<html>
    <head>
        <title>Agenda</title>
            <?php
               get_css();
            ?>
    </head>
    <body>
        <?php
            $con= get_PDO_connection();

            // tabella assenza 
            echo "<h1>Assenze</h1>";
            $qry = 'SELECT * FROM Evento WHERE Tipo = "Assenza"';
            
            $stm = $con->query($qry);
            
            $list = $stm->fetchAll();
            echo "<table>";
            echo"<tr>";
            foreach($list as $record){
                echo"<th> $record[Id] </th>";
                echo"<th> $record[Stato] </th>";
                echo"<th> $record[Data] </th>";
                echo"<th> $record[Motivazione] </th>";
            }
            echo"</tr>";
            echo "</table>";

            // tabella ritardo  
            echo "<h1>Ritardo</h1>";
            $qry = 'SELECT * FROM Evento WHERE  Tipo = "Ritardo"';
            
            $stm = $con->query($qry);
            
            $list = $stm->fetchAll();
            echo "<table>";
            echo"<tr>";
            foreach($list as $record){
                echo"<th> $record[Id] </th>";
                echo"<th> $record[Stato] </th>";
                echo"<th> $record[Data] </th>";
                echo"<th> $record[Ora_entrata] </th>";
                echo"<th> $record[Motivazione] </th>";
            }
            echo"</tr>";
            echo "</table>";

            // tabella uscite
            echo "<h1>Uscite</h1>";
            $qry = 'SELECT * FROM Evento WHERE  Tipo = "Ritardo"';
            
            $stm = $con->query($qry);
            
            $list = $stm->fetchAll();
            echo "<table>";
            echo"<tr>";
            foreach($list as $record){
                echo"<th> $record[Id] </th>";
                echo"<th> $record[Stato] </th>";
                echo"<th> $record[Data] </th>";
                echo"<th> $record[Ora_uscita] </th>";
                echo"<th> $record[Motivazione] </th>";
            }
            echo"</tr>";
            echo "</table>";
        ?>
    </body> 
</html>  

        