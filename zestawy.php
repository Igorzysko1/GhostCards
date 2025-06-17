<?php
include "includes/header.php";
?>

<script src="scripts/fiszkas.js" defer></script>

<?php

if (!isset($_GET['action'])) {
    echo "<p class='error-text'>Nie wybrano akcji!</p>";
} else {
    switch ($_GET['action']) {
        default:
            echo "<p class='error-text'>Nie wybrano poprawnej akcji!</p>";
            break;

        case "view":
            if (!isset($_GET['zestaw_id'])) {
                echo "<p class='error-text'>Nie wybrano zestawu do przeglądania!</p>";
            } else {
                $zestaw_id = $_GET['zestaw_id'];
                $q_zestawData = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");

                if ($q_zestawData->num_rows == 0) {
                    echo "<p class='error-text'>Nie wybrano poprawnego zestawu do przeglądania</p>";
                } else {
                    $q_fiszkasInZestaw = $conn->query("SELECT * FROM fiszki f INNER JOIN zestawy z ON f.zestaw_id = z.zestaw_id WHERE f.zestaw_id = '$zestaw_id';");

                    if ($q_fiszkasInZestaw->num_rows == 0) {
                        echo "<p class='text-normal'>Wybrany zestaw fiszek jest pusty.</p>";
                    } else {
                        $licznik = 1;
                        echo "<a href='zestawy.php?action=play&zestaw_id=".$zestaw_id."' class='ui-button-important'>Zagraj w zestaw</a>";
                        echo "<div class='fiszkas-list'>";
                        while ($a_fiszkaInZestaw = $q_fiszkasInZestaw->fetch_assoc()) {
                            echo "<div class='fiszka-set'>";
                            echo "<p class='fiszka-set-counter'>#$licznik</p>";
                            echo "<p class='fiszka-set-text'>Pytanie: ".$a_fiszkaInZestaw['pytanie']."</p>";
                            echo "<p class='fiszka-set-text'>Odpowiedź: ".$a_fiszkaInZestaw['odpowiedz']."</p>";
                            echo "<a class='ui-button' href='fiszki.php?action=edit&fiszka_id=".$a_fiszkaInZestaw['fiszka_id']."'>Edytuj fiszkę</a>";
                            echo "<a class='ui-button' href='fiszki.php?action=delete&fiszka_id=".$a_fiszkaInZestaw['fiszka_id']."'>Usuń fiszkę</a>";
                            echo "</div>";
                            $licznik++;
                        }
                        echo "</div>";
                    }
                }
            }
            break;

        case "play":
            if (!isset($_GET['zestaw_id'])) {
                echo "<p class='text-error'>Nie wybrano zestawu!</p>";
            } else {
                $zestaw_id = $_GET['zestaw_id'];
                $q_zestawData = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");

                if ($q_zestawData->num_rows == 0) {
                    echo "<p class='error-text'>Nie wybrano poprawnego zestawu!</p>";
                } else {
                    $q_fiszkasInZestaw = $conn->query("SELECT * FROM fiszki f INNER JOIN zestawy z ON f.zestaw_id = z.zestaw_id WHERE f.zestaw_id = '$zestaw_id';");

                    if ($q_fiszkasInZestaw->num_rows == 0) {
                        echo "<p class='error-text'>Wybrany zestaw jest pusty.</p>";
                    } else {
                        $licznik = 1;
                        while ($a_fiszkaInZestaw = $q_fiszkasInZestaw->fetch_assoc()) {
                            echo "<div class='zestaw' id='zestaw".$licznik."' style='display: none;'>";
                            echo "<div class='zestaw-inner' id='zestaw-inner".$licznik."'>";
                                echo "<div class='pytanie' id='pytanie".$licznik."'>";
                                    echo "<p>".$a_fiszkaInZestaw['pytanie']."</p>";
                                echo "</div>";
                                echo "<div class='odpowiedz' id='odpowiedz".$licznik."' style='display: none;'>";
                                    echo "<p>".$a_fiszkaInZestaw['odpowiedz']."</p>";
                                echo "</div>";
                            echo "</div>";
                            if (isset($_SESSION['uzytkownik_id'])) {
                                echo "<a href='zestawy.php?action=podpowiedz&fiszka_id=".$a_fiszkaInZestaw['fiszka_id']."' class='ui-button hint-button'>Dodaj podpowiedź</a>";
                            }
                            $fiszka_id = $a_fiszkaInZestaw['fiszka_id'];
                            $q_selectHints = $conn->query("SELECT * FROM podpowiedzi WHERE fiszka_id = '$fiszka_id';");
                            if ($q_selectHints->num_rows > 0) {
                                $losowa_liczba = 1;
                                echo "<div class='hints'>";
                                while($a_selectHint = $q_selectHints->fetch_assoc()) {
                                    $losowa_liczba = rand(1, 3);
                                    echo "<div class='hints-inner'>";
                                    echo "<img src='images/ghost".$losowa_liczba.".png' style='width: 100px; height: 100px; alt='duszek' class='ghost_photo'>";
                                    echo "<p class='hint-text'>".$a_selectHint['tresc']."</p>";
                                    echo "</div>";
                                }
                                echo "</div>";
                            }
                            echo "</div>";
                            $licznik++;
                        }
                        echo "<div class='fiszkas-buttons'>";
                        echo "<button class='fiszka-prev' onclick='previousFiszka()'><i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;Poprzednia fiszka</button>";
                        echo "<button class='fiszka-next' onclick='nextFiszka()'>Następna fiszka&nbsp;&nbsp;<i class='fa fa-angle-double-right'></i></button>";
                        echo "</div>";
                    }
                }
            }
            break;

        case "podpowiedz":
            if (!isset($_SESSION['uzytkownik_id'])) {
                header("Location: logowanie.php");
            } else {
                if (!isset($_GET['fiszka_id'])) {
                    echo "<p class='error-text'>Nie wybrano fiszki!</p>";
                } else {
                    $fiszka_id = $_GET['fiszka_id'];
                    $q_specificFiszka = $conn->query("SELECT * FROM fiszki WHERE fiszka_id = '$fiszka_id';");
                    if ($q_specificFiszka->num_rows == 0) {
                        echo "<p class='error-text'>Nie wybrano poprawnej fiszki!</p>";
                    } else { ?>
                        <form action="" method="post" class='main-form'>
                            <div class="form-group">
                                <label for="tresc" class="form-label">Wpisz treść podpowiedzi</label>
                                <input type="text" class="form-input" name="tresc" id="tresc" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Dodaj podpowiedź" class="form-submit">
                            </div>
                        </form>
                        <?php 
                        if ($_SERVER['REQUEST_METHOD'] === "POST") {
                            $tresc = $_POST['tresc'];
                            $conn->query("INSERT INTO podpowiedzi (fiszka_id, tresc) VALUES ('$fiszka_id', '$tresc');");
                            $q_zestawID = $conn->query("SELECT f.zestaw_id FROM fiszki f INNER JOIN zestawy z ON f.zestaw_id = z.zestaw_id WHERE f.fiszka_id = '$fiszka_id';");
                            $row_zestawID = $q_zestawID->fetch_assoc();
                            header("Location: zestawy.php?action=play&zestaw_id=".$row_zestawID['zestaw_id']);
                        }
                    }
                }
            }
            break;
        
        case "add":
            if (!isset($_SESSION['uzytkownik_id'])) {
                header("Location: logowanie.php");
            } else {
                ?>
                <form action="" method="post" class="main-form">
                    <div class="form-group">
                        <label for="nazwa" class="form-label">Podaj nazwę nowego zestawu</label>
                        <input type="text" name="nazwa" id="nazwa" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Dodaj zestaw" class="form-submit">
                    </div>
                </form>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === "POST") {
                    $nazwa = $_POST['nazwa'];
                    $uzytkownik_id = $_SESSION['uzytkownik_id'];

                    $q_checkingZestawName = $conn->query("SELECT * FROM zestawy WHERE nazwa = '$nazwa';");
                    if ($q_checkingZestawName->num_rows > 0) {
                        echo "<p class='error-text'>Podana nazwa już istnieje!</p>";
                    } else {
                        $conn->query("INSERT INTO zestawy (uzytkownik_id, nazwa) VALUES ('$uzytkownik_id', '$nazwa');");
                        header("Location: index.php");
                    }
                }
            }
            break;
        case "edit":
            if (!isset($_SESSION['uzytkownik_id'])) {
                header("Location: logowanie.php");
            } else {
                if (!isset($_GET['zestaw_id'])) {
                    echo "<p class='error-text'>Nie wybrano zestawu!</p>";
                } else {
                    $zestaw_id = $_GET['zestaw_id'];
                    $q_zestawData = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");

                    if ($q_zestawData->num_rows == 0) {
                        echo "<p class='error-text'>Nie wybrano poprawnego zestawu!</p>";
                    } else {
                        $row_zestawData = $q_zestawData->fetch_assoc();
                        $uzytkownik_id = $_SESSION['uzytkownik_id'];

                        if ($row_zestawData['uzytkownik_id'] != $uzytkownik_id) {
                            echo "<p class='error-text'>Zestaw nie jest twój!</p>";
                        } else {
                            ?>
                            <form action="" method="post" class="main-form">
                                <div class="form-group">
                                    <label for="nazwa" class="form-label">Wpisz nową nazwę</label>
                                    <input type="text" name="nazwa" id="nazwa" value=<?= $row_zestawData['nazwa']; ?> placeholder=<?= $row_zestawData['nazwa']; ?> class="form-input" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Zmień nazwę" class="form-submit">
                                </div>
                            </form>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] === "POST") {
                                $nazwa = $_POST['nazwa'];
                                $conn->query("UPDATE zestawy SET nazwa = '$nazwa' WHERE zestaw_id = '$zestaw_id';");
                                header("Location: index.php");
                            }
                        }
                    }
                }
            }
        break;

    case "delete":
        if (!isset($_SESSION['uzytkownik_id'])) {
            header("Location: logowanie.php");
        } else {
            if (!isset($_GET['zestaw_id'])) {
                echo "<p class='error-text'>Nie wybrano zestawu!</p>";
            } else {
                $zestaw_id = $_GET['zestaw_id'];
                $q_zestawData = $conn->query("SELECT * FROM zestawy WHERE zestaw_id = '$zestaw_id';");
                
                if ($q_zestawData->num_rows == 0) {
                    echo "<p class='error-text'>Nie wybrano poprawnego zestawu!</p>";
                } else {
                    $row_zestawData = $q_zestawData->fetch_assoc();
                    $uzytkownik_id = $_SESSION['uzytkownik_id'];
                    
                    if ($row_zestawData['uzytkownik_id'] != $uzytkownik_id) {
                        echo "<p class='error-text'>Zestaw nie jest twój!</p>";
                    } else {
                        $conn->query("DELETE FROM zestawy WHERE zestaw_id = '$zestaw_id';");
                        header("Location: index.php");
                    }
                }
            }
        }
        break;
    }
}

include "includes/footer.php";
?>