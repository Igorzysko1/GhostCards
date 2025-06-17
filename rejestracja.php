<?php include "includes/header.php"; ?>

<form action="" method="post" class="main-form">
    <div class="form-group">
        <label class="form-label" for="nazwa">Nazwa użytkownika</label>
        <input type="text" name="nazwa" id="nazwa" class="form-input" required>
    </div>
    <div class="form-group">
        <label class="form-label" for="haslo">Hasło</label>
        <input type="password" name="haslo" id="haslo" class="form-input" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Zarejestruj się" class="form-submit">
    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nazwa = $_POST['nazwa'];
    $haslo = md5($_POST['haslo']);

    $q_usernameCheck = $conn->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nazwa = '$nazwa';");
    if ($q_usernameCheck->num_rows > 0) {
        echo "<p class='error-text'>Podana nazwa użytkownika już istnieje!</p>";
    } else {
        $conn->query("INSERT INTO uzytkownicy (nazwa, haslo) VALUES ('$nazwa', '$haslo');");
        $q_usernameCheck = $conn->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nazwa = '$nazwa';");
        $row_usernameCheck = $q_usernameCheck->fetch_assoc();
        $_SESSION['uzytkownik_id'] = $row_usernameCheck['uzytkownik_id'];
        header("Location: index.php");
    }
}
?>
<?php include "includes/footer.php"; ?>