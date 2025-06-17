<?php include "includes/header.php"; ?>

<a href="fiszki.php?action=add">Dodaj fiszkę</a>
<h1>Zestawy fiszek:</h1>
<?php
$q_selectZestawy = $conn->query("SELECT * FROM zestawy;");

while ($a_selectZestaw = $q_selectZestawy->fetch_assoc()) {
    echo "<p>";
    echo "<h3>".$a_selectZestaw['nazwa']."</h3>";
    echo "<a href='zestawy.php?action=view&zestaw_id=".$a_selectZestaw['zestaw_id']."'>Zobacz zestaw</a>";
    echo "</p>";
}
?>

<?php include "includes/footer.php" ?>