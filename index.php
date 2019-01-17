<!DOCTYPE html>

<html>
  <head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='./style/admin.css'>
    <title>Admin</title>
  </head>
  <body>
     
      <?php
        require_once('authorize.php');
        require_once('mysqli_connect.php');
        $napis = "<p class='hide'>hidden</p>";

        ?>
        <div class="">
           <nav>
              <nav>
                 <a href='./wyniki_1.php'>Wybieranie składów</a> |
                 <a href='./tabela_adm.php'>Tabela</a>
              </nav>
           </nav>
        </div>
        <br>
        <div>
        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Po submitowaniu formularza.
          $nazwisko = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_REQUEST['nazwisko']))));
          $imie = mysqli_real_escape_string($dbc, ucfirst(strtolower(trim($_REQUEST['imie']))));
          $login = mysqli_real_escape_string($dbc, trim($_REQUEST['login']));
          $pass = mysqli_real_escape_string($dbc, trim($_REQUEST['pass']));
          $pass_2 = mysqli_real_escape_string($dbc, trim($_REQUEST['pass_2']));

          if ((!empty($_REQUEST['nazwisko']) || !empty($_REQUEST['imie'])) && !empty($_REQUEST['login']) && !empty($_REQUEST['pass']) && !empty($_REQUEST['pass_2'])) { // Warunek I: co najmniej 1 pole musi być wypełnione.
             if ($_REQUEST['pass'] === $_REQUEST['pass_2']) {
               $zawodnik = $nazwisko . ' ' . $imie;
               $sql_3 = "SELECT zawodnik FROM zawodnicy WHERE zawodnik='$zawodnik'";
               $result_3 = mysqli_query($dbc, $sql_3);
               $sql_4 = "SELECT zawodnik FROM zawodnicy WHERE username='$login'";
               $result_4 = mysqli_query($dbc, $sql_4);
               if (mysqli_num_rows($result_3) > 0) {
                $napis = "<p class='napis'>Taki użytkownik już istnieje. Proszę wprowadzić inne dane.</p>";
               } elseif (mysqli_num_rows($result_4) > 0) {
                $napis = "<p class='napis'>Taki login już istnieje. Proszę wybrać inny.</p>";
               } else {
                  $sql_2 = "INSERT INTO zawodnicy (zawodnik, username, password) VALUES ('$zawodnik', '$login', sha2('$pass', 512))";
                  mysqli_query($dbc, $sql_2);
                  $napis = "<p class='dodany'>Zawodnik został dodany.</p>";
               }
            } else {
               $napis = "<p class='napis'>Hasło i potwierdzenie hasła nie zgadzają się.</p>";
            }
          } else {
           $napis = "<p class='napis'>Wpisz imię lub nazwisko oraz login, hasło i potwierdzenie hasła.</p>";
          }
        }

        $sql = 'SELECT id_zaw, zawodnik FROM zawodnicy ORDER BY zawodnik';
        $result = mysqli_query($dbc, $sql);
        $i = 1;
        if (mysqli_num_rows($result) > 0) {
           echo "<table class='admin'>";
           echo "<tr><th>l.p.</th><th id='zawodnicy'>Zawodnik</th><th class='ed_us'>Edytowanie</th><th class='ed_us'>Usuwanie</th></tr>";
           while ($row = mysqli_fetch_array($result))
           {
              ?>
              <tr <?php if($i%2==0) echo "class='parzysty'"; ?>>
              <?php
              echo "
              <td>$i.</td>
              <td><strong>$row[1]</strong></td>
              <td class='link'><a href='edit.php?id=$row[0]&amp;zawodnik=$row[1]' id='edit'>Edytuj</a></td>
              <td class='link'><a href='remove.php?id=$row[0]&amp;zawodnik=$row[1]' id='del'>Usuń</a></td>
              </tr>";
              $i++;
           }
           echo "</table>";
           // echo $napis;
        } else {
           echo "<p>W tabeli nie ma jeszcze żadnych zawodników.</p>";
        }

        mysqli_close($dbc);
     ?>
         <br>
         <p><strong>Dodaj zawodnika:</strong></p>
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id='form_1'>
            <label for='nazwisko'>nazwisko</label>
              <input type='text' name='nazwisko' id='nazwisko' value='<?php if (!empty($nazwisko)) echo $nazwisko; ?>'><br>
            <label for='imie'>imię</label>
              <input type='text' name='imie' id='imie' value='<?php if (!empty($imie)) echo $imie; ?>'><br>
            <label for='login'>login</label>
              <input type='text' name='login' id='login' value='<?php if (!empty($login)) echo $login; ?>'><br>
            <label for='pass'>hasło</label>
              <input type='password' name='pass' id='pass' value='<?php if (!empty($pass)) echo $pass; ?>'><br>
            <label for='pass_2'>Potwierdź hasło</label>
              <input type='password' name='pass_2' id='pass_2' value='<?php if (!empty($pass_2)) echo $pass_2; ?>'><br>
            <?php echo $napis; ?>
            <input type='submit' name='submit' value='Dodaj' class='button' id='submit'>
            <!-- <input type='reset' name='reset' value='Wyczyść' class='button' id='reset'> -->
            <button type="button" name="button" class='button' id='reset'>Wyczyść</button> <!-- Przycisk typu input nie działa przy sticky forms. -->
         </form>
         <?php
         // echo $napis;
         ?>
         <p class='hide'>hidden</p>
         <p class='hide'>hidden</p>
         <footer>
            <hr>
            <p>Copyright &copy; <strong>Krzysztof Kozak</strong> wszelkie prawa zastrzeżone</p>
         </footer>
     </div>
     <script>
        var reset = document.getElementById('reset');
        var nazwisko = document.getElementById('nazwisko');
        var imie = document.getElementById('imie');
        var login = document.getElementById('login');
        var pass = document.getElementById('pass');
        var pass_2 = document.getElementById('pass_2');
        reset.onclick = clear;

        function clear() {
           nazwisko.value = '<?php echo ''; ?>';
           imie.value = '<?php echo ''; ?>';
           login.value = '<?php echo ''; ?>';
           pass.value = '<?php echo ''; ?>';
           pass_2.value = '<?php echo ''; ?>';
        }

      </script>
  </body>
</html>
