<?php
include "includes/header.php";

if (!isset($_GET['action'])) {
    echo "<p class='error-text'>Nie wybrano żadnej akcji!</p>";
} else {
    switch ($_GET['action']) {
        default:
            echo "<p class='error-text'>Nie wybrano poprawnej akcji!</p>";
            break;

        case "add": ?>
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

                $conn->query("INSERT INTO fiszki (pytanie, odpowiedz, ostatnio_wyswietlone) VALUES ('$pytanie', '$odpowiedz', '0000-00-00 00:00:00');");
                header("Location: index.php");
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
                    $row = $q_FiszkaData->fetch_row(); ?>
                    <h1>Edytowanie fiszki <?= $row[1]; ?></h1>
                    <form action="" method="post" class="main-form">
                        <div class="form-group">
                            <label class="form-label" for="pytanie">Pytanie:</label>
                            <input type="text" name="pytanie" id="pytanie" value="<?= $row[1]; ?>" placeholder="<?= $row[1]; ?>" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="odpowiedz">Odpowiedź:</label>
                            <input type="text" name="odpowiedz" id="odpowiedz" value="<?= $row[2]; ?>" placeholder=<?= $row[2]; ?> required>
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
                        header("Location: index.php");
                    }
                }
            }
            break;
        case "delete":
            if (!isset($_GET['fiszka_id'])) {
                echo "<p class='error-text'>Brak id fiszki!</p>";
            } else {
                $fiszka_id = $_GET['fiszka_id'];
                $conn->query("DELETE FROM fiszki WHERE fiszka_id = '$fiszka_id';");
                header("Location: index.php");
            }
            break;
    }
}
include "includes/footer.php";
?>