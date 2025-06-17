<?php
    try {
        $conn = new mysqli("localhost", "root", "", "ghostschool");
    } catch (exception $e) {
        echo "<p class='error-text'>Błąd łączenia z bazą: $e</p>";
    }
?>