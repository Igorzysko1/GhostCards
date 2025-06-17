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
                        echo "<p class='text-normal'>Wybrany zestaw fiszek jest pusty.</p>";
                    } else {
                        $licznik = 1;
                        echo "<a href='zestawy.php?action=play&zestaw_id=".$zestaw_id."' class='ui-button'>Zagraj w zestaw</a>";
                        echo "<div class='fiszkas-list'>";
                        while ($a_fiszkaInZestaw = $q_fiszkasInZestaw->fetch_assoc()) {
                            echo "<div class='fiszka-set'>";
                            echo "<p class='fiszka-set-counter'>#$licznik</p>";
                            echo "<p class='fiszka-set-text'>Pytanie: ".$a_fiszkaInZestaw['pytanie']."</p>";
                            echo "<p class='fiszka-set-text'>Odpowiedź: ".$a_fiszkaInZestaw['odpowiedz']."</p>";
                            echo "<a class='ui-button' href='fiszki.php?action=edit&fiszka_id=".$a_fiszkaInZestaw['fiszka_id']."'>Edytuj fiszkę</a>";
                            echo "<a class='ui-button' href='fiszki.php?action=delete&fiszka_id=".$a_fiszkaInZestaw['fiszka_id']."'>Usuń fiszkę</a>";
                            echo "</div>";
                            $licznik++;
                        }
                        echo "</div>";
                    }
                }
            }
            break;

        case "play":
            if (!isset($_GET['zestaw_id'])) {
                echo "<p class='text-error'>Nie wybrano zestawu!</p>";
            } else {
                $zestaw_id = $_GET['zestaw_id'];
                $q_zestawData = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");

                if ($q_zestawData->num_rows == 0) {
                    echo "<p class='error-text'>Nie wybrano poprawnego zestawu!</p>";
                } else {
                    $q_fiszkasInZestaw = $conn->query("SELECT * FROM fiszki f INNER JOIN zestawy z ON f.zestaw_id = z.zestaw_id WHERE f.zestaw_id = '$zestaw_id';");

                    if ($q_fiszkasInZestaw->num_rows == 0) {
                        echo "<p class='error-text'>Wybrany zestaw jest pusty.</p>";
                    } else {
                        $licznik = 1;
                        while ($a_fiszkaInZestaw = $q_fiszkasInZestaw->fetch_assoc()) {
                            echo "<div class='zestaw' id='zestaw".$licznik."' style='display: none;'>";
                                echo "<div class='pytanie' id='pytanie".$licznik."'>";
                                    echo "<p>".$a_fiszkaInZestaw['pytanie']."</p>";
                                echo "</div>";
                                echo "<div class='odpowiedz' id='odpowiedz".$licznik."'>";
                                    echo "<p>".$a_fiszkaInZestaw['odpowiedz']."</p>";
                                echo "</div>";
                            echo "</div>";
                            $licznik++;
                        }
                    }
                }
            }
            break;
        
        case "add":
            if (!isset($_SESSION['uzytkownik_id'])) {
                header("Location: logowanie.php");
            } else {
                ?>
                <form action="" method="post" class="main-form">
                    <div class="form-group">
                        <label for="nazwa" class="form-label">Podaj nazwę nowego zestawu</label>
                        <input type="text" name="nazwa" id="nazwa" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj zestaw" class="form-submit">
                    </div>
                </form>
                <?php
            }
            break;
    }
}

include "includes/footer.php";
?>