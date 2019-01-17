<!DOCTYPE html>

<html>
  <head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='./style/edit.css'>
    <title>Admin</title>
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
          $nazwisko_2 = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_POST['nazwisko_2']))));
          $imie_2 = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_POST['imie_2']))));
          $zawodnik_2 = $nazwisko_2 . ' ' . $imie_2;

          if ($zawodnik_2) {
            $sql_list = 'SELECT zawodnik FROM zawodnicy ORDER BY zawodnik';
            $result_list = mysqli_query($dbc, $sql_list);
            $list = [];
            $licznik = 1;
            if (mysqli_num_rows($result_list) > 0) {
               while ($row = mysqli_fetch_array($result_list)) {
                  $list[$licznik] = $row[0];
                  if ($list[$licznik] == $zawodnik_2) {
                     echo "<p id='nap_istnieje'>Zawodnik <strong>$zawodnik_2</strong> jest już w tabeli. Wprowadź innego.</p>";
                     break;
                  } else if ($licznik == mysqli_num_rows($result_list)) {
                     $sql = "UPDATE zawodnicy SET zawodnik='$zawodnik_2' WHERE id_zaw=$id LIMIT 1";
                     $result = mysqli_query($dbc, $sql);
                     echo "<p>Dane zawodnika zostały zmienione na: <strong>$zawodnik_2</strong>.</p>";
                     $form = false;
                     echo "<p>Powróć na <a href='./index.php'>stronę główną</a></p>";
                  }
                  $licznik++;
               }
            }
         } else {
            echo "<p>Pole nie może być puste</p>";
         }
      }

      if ($form) {
      ?>
      <form action="<?php $_SERVER['PHP_SELF']?>" method="post">
          <?php
          echo "<p>Edytuj zawodnika <strong>$zawodnik</strong>.</p>";
          echo "<p>Wprowadź nowe dane:</p>";
          echo "<input type='number' name='number' value='$id' style='display:none;'>";
          echo "<label for='nazwisko_2'>nazwisko:</label><input type='text' name='nazwisko_2' id='nazwisko_2'><br>";
          echo "<label for='imie_2'>imię:</label><input type='text' name='imie_2'><br>";
          ?>
          <br>
          <input type='submit' name='submit' value='Zatwierdź' id='button' disabled>
          <p>Powrót bez edytowania na <a href='./index.php'>stronę główną</a>.</p>
      </form>
      <?php
      }
   } else {
      echo "<p>Nie wybrano żadnego zawodnika do edycji.</p>";
      echo "<p>Powrót na <a href='./index.php'>stronę główną.</a></p>";
   }

   mysqli_close($dbc);
   ?>
   <p class='hide'>hidden</p>
   <p class='hide'>hidden</p>
   <footer>
      <hr>
      <p>Copyright &copy; <strong>Krzysztof Kozak</strong> wszelkie prawa zastrzeżone</p>
   </footer>

   <script>
      var button = document.getElementById('button');
      var nazwisko_2 = document.getElementById('nazwisko_2');
      var imie_2 = document.getElementById('imie_2');
      nazwisko_2.oninput = activate;
      imie_2.oninput = activate;

      function activate() {
         if (nazwisko_2.value != '' || imie_2.value != '') {
            button.disabled = false;
         }
      }


   </script>
  </body>
</html>
