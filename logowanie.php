<?php include "includes/header.php"; ?>

<form action="" method="post" class="main-form">
    <div class="form-group">
        <label class="form-label" for="nazwa">Wpisz nazwę użytkownika</label>
        <input type="text" name="nazwa" id="nazwa" class="form-input" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="haslo">Wpisz hasło</label>
        <input type="password" name="haslo" id="haslo" class="form-input" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Zaloguj się" class="form-submit">
    </div>
</form>

<p class="text-normal">Nie masz konta? <a href="rejestracja.php">Stwórz konto</a></p>

<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nazwa = $_POST['nazwa'];
    $haslo = md5($_POST['haslo']);

    $q_usernameCheck = $conn->query("SELECT uzytkownik_id, haslo FROM uzytkownicy WHERE nazwa = '$nazwa';");
    if ($q_usernameCheck->num_rows == 0) {
        echo "<p class='error-text'>Użytkownik o podanej nazwie nie istnieje.</p>";
    } else {
        $row_usernameCheck = $q_usernameCheck->fetch_assoc();
        if ($haslo == md5($row_usernameCheck['haslo'])) {
            echo "<p class='error-text'>Niepoprawne hasło!</p>";
        } else {
            $_SESSION['uzytkownik_id'] = $row_usernameCheck['uzytkownik_id'];
            header("Location: index.php");
        }
    }
}
include "includes/footer.php";
?>