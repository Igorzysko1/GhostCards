<?php
include "includes/header.php";

if (!isset($_GET['action'])) {
    echo "<p class='error-text'>Nie wybrano akcji!</p>";
} else {
    switch ($_GET['action']) {
        default:
            echo "<p class='error-text'>Nie wybrano poprawnej akcji!</p>";
            break;

        case "view":
            if (!isset($_GET['zestaw_id'])) {
                echo "<p class='error-text'>Nie wybrano zestawu do przeglądania!</p>";
            } else {
                $zestaw_id = $_GET['zestaw_id'];
                $q_zestawData = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");

                if ($q_zestawData->num_rows == 0) {
                    echo "<p class='error-text'>Nie wybrano poprawnego zestawu do przeglądania</p>";
                } else {
                    $q_fiszkasInZestaw = $conn->query("SELECT * FROM fiszki f INNER JOIN zestawy z ON f.zestaw_id = z.zestaw_id WHERE f.zestaw_id = '$zestaw_id';");

                    if ($q_fiszkasInZestaw->num_rows == 0) {
                        echo "<p>Wybrany zestaw fiszek jest pusty.</p>"; # To nie jest error (powinno wygladac tak jak reszta)
                    } else {
                        $licznik = 1;
                        while ($a_fiszkaInZestaw = $q_fiszkasInZestaw->fetch_assoc()) {
                            echo "<p>";
                            echo "<h2>Fiszka numer ".$licznik."</h2>";
                            echo "Pytanie: ".$a_fiszkaInZestaw['pytanie'];
                            echo "Odpowiedź: ".$a_fiszkaInZestaw['odpowiedz'];
                            echo "</p>";
                            $licznik++;
                        }
                    }
                }
            }
            break;
    }
}

include "includes/footer.php";
?>