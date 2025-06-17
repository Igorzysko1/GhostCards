<?php include "includes/header.php"; ?>

<a href="fiszki.php?action=add">Dodaj fiszkę</a>
<h1>Fiszki:</h1>
<?php
$q_selectFiszkas = $conn->query("SELECT * FROM fiszki;");

while ($a_selectFiszka = $q_selectFiszkas->fetch_assoc()) {
    echo "<p>";
    echo "<h3>".$a_selectFiszka['pytanie']."</h3>";
    echo "<a href='fiszki.php?action=edit&fiszka_id=".$a_selectFiszka['fiszka_id']."'>Edytuj fiszkę</a>";
    echo "</p>";
}
?>

<?php include "includes/footer.php" ?>