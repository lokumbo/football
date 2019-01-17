<!DOCTYPE html>

<html>
  <head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='./style/remove.css'>
    <title>Usuń</title>
  </head>
  <body>
     <?php
     require_once('authorize.php');
     require_once('mysqli_connect.php');

     if (!empty($_GET['id']) && !empty($_GET['zawodnik'])) {
       $id = mysqli_real_escape_string($dbc, trim($_GET['id'])); // Zmienne pobrane za pomocą metody GET oraz linka <a>.
       $zawodnik = mysqli_real_escape_string($dbc, trim($_GET['zawodnik']));
       $form = true;

       if (isset($_POST['submit'])) { // Najpierw sprawdza, czy formularz został wysłany.
          $sql = "DELETE FROM zawodnicy WHERE id_zaw=$id LIMIT 1";
          $result = mysqli_query($dbc, $sql);
          if ($result) {
            echo "<p>Zawodnik <strong>$zawodnik</strong> został usunięty.</p>";
            $form = false;
            echo "<p>Powróć na <a href='./index.php'>stronę główną</a>.</p>";
         } else {
            echo "<p id='napis'>Nie można usunąć zawodnika <strong>$zawodnik</strong>, ponieważ jest on dodany do tabeli z wynikami.</p>";
            echo "<p>Powróć na <a href='./index.php'>stronę główną</a>.</p>";
            $form = false;
         }
       }

       if ($form) {
       ?>
       <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
          <?php
          echo "<p>Czy na pewno usunąć zawodnika: <strong>$zawodnik</strong>?</p>";
          echo "<input type='number' name='number' value='$id' class='ukryj'>";
          echo "<input type='text' name='zawodnik' value='$zawodnik' class='ukryj'>";
          ?>
          <input type='submit' name='submit' value='Usuń' id='button'>
          <p>Jeżeli nie chcesz usuwać zawodnika, to powróć na <a href='./index.php'>stronę główną</a>.</p>
       </form>
       <?php
       }
    } else {
       echo "<p>Nie wybrano żadnego zawodnika do edycji.</p>";
       echo "<p>Powróć na <a href='./index.php'>stronę główną.</a></p>";
    }

    mysqli_close($dbc);
    ?>
    <p class='hide'>hidden</p>
    <p class='hide'>hidden</p>
    <footer>
      <hr>
      <p>Copyright &copy; <strong>Krzysztof Kozak</strong> wszelkie prawa zastrzeżone</p>
    </footer>

   </body>
</html>
