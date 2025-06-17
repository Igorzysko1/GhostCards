<?php
include "includes/header.php";

if (!isset($_GET['action'])) {
    echo "<p>Nie wybrano żadnej akcji</p>";
} else {
    switch ($_GET['action']) {
        default:
            echo "<p>Nie wybrano poprawnej akcji</p>";
            break;

        case "add": ?>
            <form action="" method="post">
                <input type="text" name="pytanie"><br>
                <input type="text" name="odpowiedz">
                <input type="submit" value="Wyślij">
            </form>
            <?php
            $conn = new mysqli("localhost", "root", "", "ghostschool");

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $pytanie = $_POST['pytanie'];
                $odpowiedz = $_POST['odpowiedz'];

                $conn->query("INSERT INTO fiszki (pytanie, odpowiedz, ostatnio_wyswietlone) VALUES ('$pytanie', '$odpowiedz', '0000-00-00 00:00:00');");
                header("Location: index.php");
            }
}
}
include "includes/footer.php";
?>