<?php
include "includes/header.php";

if (!isset($_SESSION['uzytkownik_id'])) {
    header("Location: logowanie.php");
}

if (!isset($_GET['action'])) {
    echo "<p class='error-text'>Nie wybrano żadnej akcji!</p>";
} else {
    switch ($_GET['action']) {
        default:
            echo "<p class='error-text'>Nie wybrano poprawnej akcji!</p>";
            break;

        case "add":
            if (!isset($_GET['zestaw_id'])) {
                echo "<p class='error-text'>Nie wybrano zestawu!</p>";
                break;
            }
            $zestaw_id = $_GET['zestaw_id'];
            $q_checkingZestaw = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");
            if ($q_checkingZestaw->num_rows == 0) {
                echo "<p class='error-text'>Nie wybrano poprawnego zestawu!</p>";
                break;
            }
            ?>
            <form action="" method="post" class="main-form">
                <div class="form-group">
                    <label class="form-label" for="pytanie">Pytanie:</label>
                    <input type="text" name="pytanie" id="pytanie" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="odpowiedz">Odpowiedź:</label>
                    <input type="text" name="odpowiedz" id="odpowiedz" class="form-input" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Wyślij" class="form-submit">
                </div>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pytanie = $_POST['pytanie'];
                $odpowiedz = $_POST['odpowiedz'];

                $conn->query("INSERT INTO fiszki (zestaw_id, pytanie, odpowiedz, ostatnio_wyswietlone) VALUES ('$zestaw_id', '$pytanie', '$odpowiedz', '0000-00-00 00:00:00');");
                header("Location: zestawy.php?action=view&zestaw_id=".$zestaw_id);
            }
            break;
        
        case "edit":
            if (!isset($_GET['fiszka_id'])) {
                echo "<p class='error-text'>Brak id fiszki!</p>";
            } else {
                $fiszka_id = $_GET['fiszka_id'];
                $q_FiszkaData = $conn->query("SELECT * FROM fiszki WHERE fiszka_id = '$fiszka_id';");
                
                if ($q_FiszkaData->num_rows == 0) {
                    echo "<p class='error-text'>Wybrano niepoprawną fiszkę!</p>";
                } else {
                    $row = $q_FiszkaData->fetch_assoc(); ?>
                    <form action="" method="post" class="main-form">
                        <div class="form-group">
                            <label class="form-label" for="pytanie">Pytanie:</label>
                            <input type="text" name="pytanie" id="pytanie" value="<?= $row['pytanie']; ?>" placeholder="<?= $row['pytanie']; ?>" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="odpowiedz">Odpowiedź:</label>
                            <input type="text" name="odpowiedz" id="odpowiedz" value="<?= $row['odpowiedz']; ?>" placeholder="<?= $row['odpowiedz']; ?>" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Edytuj" class="form-submit">
                        </div>
                    </form>
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $pytanie = $_POST['pytanie'];
                        $odpowiedz = $_POST['odpowiedz'];

                        $conn->query("UPDATE fiszki SET pytanie = '$pytanie', odpowiedz = '$odpowiedz' WHERE fiszka_id = '$fiszka_id';");
                        $q_ktoryZestaw = $conn->query("SELECT z.zestaw_id FROM zestawy z INNER JOIN fiszki f ON z.zestaw_id = f.zestaw_id WHERE f.fiszka_id = '$fiszka_id';");
                        $row_ktoryZestaw = $q_ktoryZestaw->fetch_assoc();
                        header("Location: zestawy.php?action=view&zestaw_id=".$row_ktoryZestaw['zestaw_id']);
                    }
                }
            }
            break;
        case "delete":
            if (!isset($_GET['fiszka_id'])) {
                echo "<p class='error-text'>Brak id fiszki!</p>";
            } else {
                $fiszka_id = $_GET['fiszka_id'];
                $q_ktoryZestaw = $conn->query("SELECT z.zestaw_id FROM zestawy z INNER JOIN fiszki f ON z.zestaw_id = f.zestaw_id WHERE f.fiszka_id = '$fiszka_id';");
                $row_ktoryZestaw = $q_ktoryZestaw->fetch_assoc();
                $conn->query("DELETE FROM fiszki WHERE fiszka_id = '$fiszka_id';");
                header("Location: zestawy.php?action=view&zestaw_id=".$row_ktoryZestaw['zestaw_id']);
            }
            break;
    }
}
include "includes/footer.php";
?>