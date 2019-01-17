<!DOCTYPE html>

<html>
  <head>
    <meta charset='utf-8'>
    <link rel='stylesheet' href='./style/wyniki_2.css'>
    <title>Usuń</title>
  </head>
  <body>
     
     <?php
     require_once('authorize.php');
     require_once('mysqli_connect.php');

     if (!empty($_POST['date'])) {
       $zmienna_pom = 2;
       $data = $_POST['date'];
       $tbl_date = explode('-', $data);
       $d = mktime(1, 1, 1, $tbl_date[1], $tbl_date[2], $tbl_date[0]); // Pierwsze trzy cyfr to godzina i one muszą być podane jako argumenty. Wszystkie argumenty muszą być INT.
       $date_new = date("Y-m-d-l", $d);
       $tbl_date_2 = explode('-', $date_new);

       switch ($tbl_date_2[1]) {
          case '01': $tbl_date_2[1] = 'styczeń';
            break;
          case '02': $tbl_date_2[1] = 'luty';
            break;
          case '03': $tbl_date_2[1] = 'marzec';
            break;
          case '04': $tbl_date_2[1] = 'kwiecień';
            break;
          case '05': $tbl_date_2[1] = 'maj';
            break;
          case '06': $tbl_date_2[1] = 'czerwiec';
            break;
          case '07': $tbl_date_2[1] = 'lipiec';
            break;
          case '08': $tbl_date_2[1] = 'sierpień';
            break;
          case '09': $tbl_date_2[1] = 'wrzesień';
            break;
          case '10': $tbl_date_2[1] = 'październik';
            break;
          case '11': $tbl_date_2[1] = 'listopad';
            break;
          case '12': $tbl_date_2[1] = 'grudzień';
            break;
       }

       switch ($tbl_date_2[3]) {
          case 'Monday': $tbl_date_2[3] = 'poniedziałek';
            break;
          case 'Tuesday': $tbl_date_2[3] = 'wtorek';
            break;
          case 'Wednesday': $tbl_date_2[3] = 'środa';
            break;
          case 'Thursday': $tbl_date_2[3] = 'czwartek';
            break;
          case 'Friday': $tbl_date_2[3] = 'piątek';
            break;
          case 'Saturday': $tbl_date_2[3] = 'sobota';
            break;
          case 'Sunday': $tbl_date_2[3] = 'niedziela';
            break;
       }

       $punkty_1 = $_POST['punkty_1'];
       $punkty_2 = $_POST['punkty_2'];
       $punkty_3 = $_POST['punkty_3']; // Dla 2 drużyn pobiera pusty łańcuch, a dla 3 drużyn wartość.
       $bramki_1 = $_POST['bramki_1'];
       $bramki_2 = $_POST['bramki_2'];
       $bramki_3 = $_POST['bramki_3']; // Dla 2 drużyn pobiera pusty łańcuch, a dla 3 drużyn wartość.
       $druzyna_1 = $_POST['druzyna_1'];
       $druzyna_2 = $_POST['druzyna_2'];
       $nr_1 = count($druzyna_1);
       $nr_2 = count($druzyna_2);
       $nr_3 = 0; // Dla 2 drużyn i nie zaznaczonej drużynie nr 3, funkcja count() nie działa.
       $str_1_all = '';
       $str_2_all = '';
       $str_3_all = '';

       for ($i=0; $i<$nr_1; $i++) {
          $str_1[$i] = '&amp;druzyna_1' . $i . '=' . $druzyna_1[$i];
          $str_1_all = $str_1_all . $str_1[$i];
       }
       for ($i=0; $i<$nr_2; $i++) {
          $str_2[$i] = '&amp;druzyna_2' . $i . '=' . $druzyna_2[$i];
          $str_2_all = $str_2_all . $str_2[$i];
       }

       $adres = "./wyniki_1.php?date_back=$data&amp;pkt_back_1=$punkty_1&amp;pkt_back_2=$punkty_2&amp;bram_back_1=$bramki_1&amp;bram_back_2=$bramki_2&amp;nr_1=$nr_1&amp;nr_2=$nr_2$str_1_all$str_2_all";

       if (!empty($_POST['druzyna_3'])) {
          $zmienna_pom = 3;
          $druzyna_3 = $_POST['druzyna_3'];
          $nr_3 = count($druzyna_3);

          for ($i=0; $i<$nr_3; $i++) {
            $str_3[$i] = '&amp;druzyna_3' . $i . '=' . $druzyna_3[$i];
            $str_3_all = $str_3_all . $str_3[$i];
          }

          $adres = "./wyniki_1.php?date_back=$data&amp;pkt_back_1=$punkty_1&amp;pkt_back_2=$punkty_2&amp;pkt_back_3=$punkty_3&amp;bram_back_1=$bramki_1&amp;bram_back_2=$bramki_2&amp;bram_back_3=$bramki_3&amp;nr_1=$nr_1&amp;nr_2=$nr_2&amp;nr_3=$nr_3$str_1_all$str_2_all$str_3_all";
       }

       $nr = [$nr_1, $nr_2, $nr_3];
       sort($nr);

       for($i=0; $i<$nr[2]; $i++) {
          if ($i >= $nr_1) {
             $druzyna_1[$i] = '';
          }
          if ($i >= $nr_2) {
             $druzyna_2[$i] = '';
          }
          if ($i >= $nr_3) {
             $druzyna_3[$i] = '';
          }
       }

       echo "<p>Sprawdź dane.</p>";
       echo "<p>Jeżeli się nie zgadzają, to <a href='$adres'>wybierz ponownie</a>.</p><br>";
      ?>

      <p>Data: <strong><?php echo $tbl_date_2[3] . ', ' . $tbl_date_2[2] . ' ' . $tbl_date_2[1] . ' ' . $tbl_date_2[0]; ?></strong></p>
      <?php
      $ilu_gracz = $nr_1 + $nr_2 + $nr_3;
      echo "<p>Ilość zawodników: <strong>$ilu_gracz</strong></p>";
      ?>
      <table id='wyniki_2'>
        <tr>
           <th>l.p.</th>
           <th>Skład 1</th>
           <th>Skład 2</th>
           <th class='th_3'>Skład 3</th>
        </tr>
        <?php
           for ($i=0; $i<$nr[2]; $i++) {
              $j = $i + 1;
              ?>
              <tr <?php if($i%2!=0) echo "class='parzysty'"; ?>>
              <?php
              echo "
              <td>$j.</td>
              <td class='sklady'><strong>$druzyna_1[$i]</strong></td>
              <td class='sklady'><strong>$druzyna_2[$i]</strong></td>
              <td class='sklady team_3'><strong>$druzyna_3[$i]</strong></td>
              </tr>";
           }
        ?>
        <tr id='bigger'>
           <td></td>
           <td></td>
           <td></td>
           <td td class='th_3'></td>
        </tr>
        <tr class='pkt_bra'>
           <td></td>
           <td class='sklady'>Punkty: <strong><?php echo $punkty_1;?></strong></td>
           <td class='sklady'>Punkty: <strong><?php echo $punkty_2;?></strong></td>
           <td class='sklady th_3'>Punkty: <strong><?php echo $punkty_3; ?></strong></td>
        </tr>
        <tr class='pkt_bra'>
           <td></td>
           <td class='sklady'>Bramki: <strong><?php echo $bramki_1; ?></strong></td>
           <td class='sklady'>Bramki: <strong><?php echo $bramki_2; ?></strong></td>
           <td class='sklady th_3'>Bramki: <strong><?php echo $bramki_3; ?></strong></td>
        </tr>
      </table>

      <?php
      if (!empty($_POST['druzyna_3'])) {
        $adres_forward="./wyniki_3.php?date_forward=$data&amp;pkt_forward_1=$punkty_1&amp;pkt_forward_2=$punkty_2&amp;pkt_forward_3=$punkty_3&amp;bram_forward_1=$bramki_1&amp;bram_forward_2=$bramki_2&amp;bram_forward_3=$bramki_3&amp;nr_1=$nr_1&amp;nr_2=$nr_2&amp;nr_3=$nr_3$str_1_all$str_2_all$str_3_all";
      } else {
         $adres_forward="./wyniki_3.php?date_forward=$data&amp;pkt_forward_1=$punkty_1&amp;pkt_forward_2=$punkty_2&amp;bram_forward_1=$bramki_1&amp;bram_forward_2=$bramki_2&amp;nr_1=$nr_1&amp;nr_2=$nr_2$str_1_all$str_2_all";
      }

      $sql = "SELECT data FROM daty";
      $result = mysqli_query($dbc, $sql);

      if (mysqli_num_rows($result) > 0) {
        $licznik = 1;
        while ($row = mysqli_fetch_array($result)) {
            if ($row[0] == $data) {
             echo "<p style='color:red;'>Taka data już jest w tabeli. Proszę ją zmienić.</p>";
             echo "<a href='$adres_forward'><button id='btn_submit' disabled>Zatwierdź</button></a>";
             break;
          } else {
             echo '<p></p>';
             if ($licznik == mysqli_num_rows($result)) {
               echo "<a href='$adres_forward'><button id='btn_submit'>Zatwierdź</button></a>";
             }
          }
          $licznik++;
        }
     } else {
        echo "<a href='$adres_forward'><button id='btn_submit'>Zatwierdź</button></a>";
     }
   } else {
      echo "<p>Nie wybrano składów.</p>";
      echo "<p>Wróć do <a href='./wyniki_1.php'>wybierania składów.</a></p>";
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
      if (<?php echo $nr_3; ?> == 0) {
         var th_3 = document.getElementsByClassName('th_3');
         var team_3 = document.getElementsByClassName('team_3');
         var btn_submit = document.getElementById('btn_submit');

         for (var i=0; i<4; i++) {
            th_3[i].style.display = 'none';
         }

         for (var i=0; i < <?php echo $nr[2] ?>; i++) {
            team_3[i].style.display = 'none';
         }
      }

    </script>
   </body>
</html>
