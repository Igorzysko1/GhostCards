<?php include "includes/header.php"; ?>

<p class="heading-text">Zestawy fiszek:</p>
<?php
$q_selectZestawy = $conn->query("SELECT * FROM zestawy;");

echo "<div class='fiszkas-list'>";

while ($a_selectZestaw = $q_selectZestawy->fetch_assoc()) {
    echo "<div class='fiszka-set'>";
    echo "<p class='fiszka-set-name'>".$a_selectZestaw['nazwa']."</p>";
    echo "<a href='zestawy.php?action=view&zestaw_id=".$a_selectZestaw['zestaw_id']."' class='view-fiszka'><i class='fa fa-eye'></i>&nbsp;&nbsp;Zobacz zestaw</a>";
    echo "</div>";
}
echo "</div>";
?>

<?php include "includes/footer.php" ?>