<?php include "includes/header.php"; ?>

<form action="" method="post">
    <div class="form-group">
        <label for="nazwa">Wpisz nazwę użytkownika</label>
        <input type="text" name="nazwa" id="nazwa" required>
    </div>
    <div class="form-group">
        <label for="haslo">Wpisz hasło</label>
        <input type="password" name="haslo" id="haslo" required>
    </div>
    <input type="submit" value="Zarejestruj się">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $nazwa = $_POST['nazwa'];
    $haslo = md5($_POST['haslo']);

    $q_usernameCheck = $conn->query("SELECT uzytkownik_id FROM uzytkownicy WHERE nazwa = '$nazwa';");
    $row_usernameCheck = $q_usernameCheck->fetch_assoc();
    if ($row_usernameCheck->num_rows > 0) {
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