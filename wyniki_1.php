<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Wyniki</title>
   <link rel="stylesheet" href="./style/wyniki_1.css">
</head>
<body>

   <?php
     require_once('authorize.php');
     require_once('mysqli_connect.php');
   ?>
     <div>
       <nav>
          <nav>
             <a href="index.php">Lista zawodników</a> |
             <a href='./tabela_adm.php'>Tabela</a>
          </nav>
       </nav>
     </div>
   <?php

     $sql = "SELECT id_zaw, zawodnik FROM zawodnicy ORDER BY zawodnik";

     ?>
     <div id='left_div'>
       <div>
          <p>Liczba drużyn:
             <select name='ile_druz' id='ile_druz'>
               <option value='2'>2</option>
               <option value='3'>3</option>
             </select>
             <button type='button' name='button' id='but_ile_druz'>Zatwierdź</button>
          </p>
       </div>
       <div id='teams'>
     <?php

     $result = mysqli_query($dbc, $sql);
     $x = 1;

     if (mysqli_num_rows($result) > 0) {

       ?>
       <div>
       <form action='wyniki_2.php' method='POST'>
         <h4>Wybierz składy, datę, punkty i bramki:</h4>
         <table id='wyniki'>
         <tr>
            <th>l.p.</th><th>Zawodnik</th><th>Skład 1</th><th>Skład 2</th><th class='checkbox_3'>Skład 3</th>
         </tr>
       <?php

       if (!empty($_GET['date_back'])) {
         $zmienna_pom = 2;
         $date_back = $_GET['date_back'];
         $pkt_back_1 = $_GET['pkt_back_1'];
         $pkt_back_2 = $_GET['pkt_back_2'];
         $bram_back_1 = $_GET['bram_back_1'];
         $bram_back_2 = $_GET['bram_back_2'];
         $nr_1 = $_GET['nr_1'];
         $nr_2 = $_GET['nr_2'];

         for ($i=0; $i<$nr_1; $i++) {
            $napis_1[$i] = 'druzyna_1' . $i;
            $druzyna1[$i] = $_GET["$napis_1[$i]"];
         }
         for ($i=0; $i<$nr_2; $i++) {
            $napis_2[$i] = 'druzyna_2' . $i;
            $druzyna2[$i] = $_GET["$napis_2[$i]"];
         }

         if (!empty($_GET['nr_3'])) {
            $zmienna_pom = 3;
            $pkt_back_3 = $_GET['pkt_back_3'];
            $bram_back_3 = $_GET['bram_back_3'];
            $nr_3 = $_GET['nr_3'];

            for ($i=0; $i<$nr_3; $i++) {
               $napis_3[$i] = 'druzyna_3' . $i;
               $druzyna3[$i] = $_GET["$napis_3[$i]"];
            }
         } else {
            $pkt_back_3 = '';
            $bram_back_3 = '';
            $nr_3 = mysqli_num_rows($result);
            for ($i=0 ;$i< $nr_3 ;$i++) {
               $druzyna3[$i] = '';
            }
         }
       } else {
         $zmienna_pom = 1;
         $date_back = '';
         $pkt_back_1 = '';
         $pkt_back_2 = '';
         $pkt_back_3 = '';
         $bram_back_1 = '';
         $bram_back_2 = '';
         $bram_back_3 = '';

         $nr_1 = $nr_2 = $nr_3 = mysqli_num_rows($result);
         for ($i=0 ;$i< $nr_1 ;$i++) {
            $druzyna1[$i] = '';
            $druzyna2[$i] = '';
            $druzyna3[$i] = '';
         }
       }

       while ($row = mysqli_fetch_array($result))
       {

       ?>
         <tr <?php if($x%2==0) echo "class='parzysty'"; else echo "class='nieparzysty'"; ?>>
            <td><?php echo $x . '.'; ?></td>
            <td class='sklady'><strong><?php echo $row[1]; ?></strong></td>
            <td class='checkbox checkbox_1'>
               <input class='inp_check_1' type='checkbox' name='druzyna_1[]' value='<?php echo $row[1]; ?>'
               <?php
                  for ($j=0; $j<$nr_1; $j++){
                    if($druzyna1[$j]===$row[1]) { echo 'checked'; }}
               ?>>
            </td>
            <td class='checkbox checkbox_2'>
               <input class='inp_check_2' type='checkbox' name='druzyna_2[]' value='<?php echo $row[1]; ?>'
               <?php
                  for ($j=0; $j<$nr_2; $j++){
                    if($druzyna2[$j]===$row[1]) { echo 'checked'; }}
               ?>>
            </td>
            <td class='checkbox checkbox_3' disabled>
               <input class='inp_check_3' type='checkbox' name='druzyna_3[]' value='<?php echo $row[1]; ?>'
               <?php
                  for ($j=0; $j<$nr_3; $j++){
                    if($druzyna3[$j]===$row[1]) { echo 'checked'; }}
               ?>>
            </td>
         </tr>
       <?php
         $x++;
       }
       ?>
           <tr id='oddzielacz'>
             <td></td><td></td><td></td><td></td><td class='checkbox_3'></td>
           </tr>
           <tr class='dat_pkt_bra'>
             <td class='normal'></td><td class='left'><strong>data</strong></td><td colspan='3' id='date'><input class='input_date' type='date' name='date' value='<?php echo $date_back; ?>'></td>
           </tr>
           <tr class='dat_pkt_bra'>
             <td class='normal'></td><td class='left'><strong>punkty</strong></td>
             <td class='checkbox'><input class='input_punkty' type='number' name='punkty_1' value='<?php echo $pkt_back_1; ?>'></td>
             <td class='checkbox'><input class='input_punkty' type='number' name='punkty_2' value='<?php echo $pkt_back_2; ?>'></td>
             <td class='checkbox checkbox_3'><input class='input_punkty' type='number' name='punkty_3' value='<?php echo $pkt_back_3; ?>'></td>
          </tr>
          <tr class='dat_pkt_bra'>
             <td class='normal'></td><td class='left'><strong>bramki</strong></td>
             <td class='checkbox'><input class='input_bramki' type='number' name='bramki_1' value='<?php echo $bram_back_1; ?>'></td>
             <td class='checkbox'><input class='input_bramki' type='number' name='bramki_2' value='<?php echo $bram_back_2; ?>'></td>
             <td class='checkbox checkbox_3'><input class='input_bramki' type='number' name='bramki_3' value='<?php echo $bram_back_3; ?>'></td>
          </tr>
      </table>
         <br>
         <input type='submit' name='submit' value='Dodaj' id='sub_but' class='add_res'>
         <!-- <input type='reset' name='reset' value='Wyczyść' id=''> -->
         <button type="button" name="button" id='res_but' class='add_res'>Wyczyść</button> <!-- Przycisk typu input nie działa przy sticky forms. -->
       </form>
       <p><strong>Uwaga!</strong></p>
       <p>
       - Punkty nie mogą być ujemne.<br>
       - Dany zawodnik może być tylko w jednej drużynie.
       </p>
       </div>

       <?php
     } else {
        echo "Nie dodano jeszcze żadnych zawodników w tabeli.";
     }
   ?>
      </div>
   </div>
   <div id="right_div">

   </div>
   <?php
      mysqli_close($dbc);
   ?>
   <p class='hide'>hidden</p>
   <p class='hide'>hidden</p>
   <footer>
      <hr>
      <p>Copyright &copy; <strong>Krzysztof Kozak</strong> wszelkie prawa zastrzeżone</p>
   </footer>

      <script>
         // ---------------------------- ile drużyn -------------------------------------------
         var teams = document.getElementById('teams');

         var dat = document.getElementById('date');
         var data_meczu = document.getElementsByClassName('input_date');
         var punkty = document.getElementsByClassName('input_punkty');
         var bramki = document.getElementsByClassName('input_bramki');
         var checkbox_1 = document.getElementsByClassName('checkbox_1');
         var checkbox_2 = document.getElementsByClassName('checkbox_2');
         var checkbox_3 = document.getElementsByClassName('checkbox_3');

         var druzyna_1 = document.getElementsByClassName('inp_check_1');
         var druzyna_2 = document.getElementsByClassName('inp_check_2');
         var druzyna_3 = document.getElementsByClassName('inp_check_3');

         var sub_but = document.getElementById('sub_but');
         // sub_but.disabled = true;
         var res_but = document.getElementById('res_but');
         res_but.onclick = deactive_but;
         var but_ile_druz = document.getElementById('but_ile_druz');
         but_ile_druz.onclick = choose;

         if (data_meczu[0].value) {
            data_meczu[0].style.backgroundColor = 'transparent';
         }
         for (var i=0; i<punkty.length; i++) {
            if (punkty[i].value) {
               punkty[i].style.backgroundColor = 'transparent';
            }
            if (bramki[i].value) {
              bramki[i].style.backgroundColor = 'transparent';
            }
         }

         for (var i=0; i<druzyna_1.length; i++) {
            druzyna_1[i].oninput = fun;
            druzyna_2[i].oninput = fun;
            druzyna_3[i].oninput = fun;
         }

         data_meczu[0].oninput = fun;

         for (var i=0; i<punkty.length; i++) {
            punkty[i].oninput = fun;
            bramki[i].oninput = fun;
         }

         // ---------------------------------------------- funkcje ---------------------------------------------
         function choose() {
            var ile_druz = document.getElementById('ile_druz').value;

            if (ile_druz == 2) {
               teams.style.display = 'block';
               dat.setAttribute('colspan', 2);
               for (var i=0; i<checkbox_3.length; i++) {
                  checkbox_3[i].style.display = 'none';
               }
               if (<?php echo $zmienna_pom; ?> == 1 || <?php echo $zmienna_pom; ?> == 3) {      // Żeby po odświeżeniu czyścił pola wypełnionego formularza lub formularza z GET przy przejściu z 3 na 2 drużyny.
                  deactive_but();
               }
            } else {
               teams.style.display = 'block';
               for (var i=0; i<checkbox_3.length; i++) {
                  checkbox_3[i].style.display = 'table-cell';
               }
               dat.setAttribute('colspan', 3);
               if (<?php echo $zmienna_pom; ?> == 1 || <?php echo $zmienna_pom; ?> == 2) {      // Żeby po odświeżeniu czyścił pola wypełnionego formularza lub formularza z GET przy przejściu z 2 na 3 drużyny.
                  deactive_but();
               }
            }
         }

         function deactive_but() {
            sub_but.disabled = true;
            for (var i=0; i<druzyna_1.length; i++) {
               checkbox_1[i].style.backgroundColor = 'transparent'; // Czyści tło, po resecie.
               checkbox_2[i].style.backgroundColor = 'transparent';
               checkbox_3[i+1].style.backgroundColor = 'transparent';

            }
            data_meczu[0].value = '<?php if (!empty($_GET['date_back'])) echo ''; ?>';
            data_meczu[0].style.backgroundColor = 'tomato';
            for (var i=0; i<punkty.length; i++) {
               punkty[i].value = '<?php if (!empty($_GET['date_back'])) echo ''; ?>';
               bramki[i].value = '<?php if (!empty($_GET['date_back'])) echo ''; ?>';
               punkty[i].style.backgroundColor = 'tomato';
               bramki[i].style.backgroundColor = 'tomato';
            }
            for (var i=0; i<druzyna_1.length; i++) {
               druzyna_1[i].checked = false;
               druzyna_2[i].checked = false;
               druzyna_3[i].checked = false;
            }
         }

         function fun() { // Funkcja do wywoływania 3 funkcji za pomocą 1 eventu.
            active_but();
            change_color_1();
            change_color_2();
         }

         function active_but() {
           for (var i=0; i<druzyna_1.length; i++) {
             if (druzyna_1[i].checked) {
               for(var j=0; j<druzyna_2.length; j++) {
                  if (druzyna_2[j].checked) {
                     var ile_druzyn = document.getElementById('ile_druz').value;
                     if (ile_druzyn == 2 && data_meczu[0].value && punkty[0].value>=0 && punkty[1].value>=0 && bramki[0].value && bramki[1].value) {
                        for (var l=0; l<druzyna_1.length; l++) {
                           if (druzyna_1[l].checked && druzyna_2[l].checked) {
                              sub_but.disabled = true;
                              break;
                           } else {
                              sub_but.disabled = false;
                           }
                        }
                     } else {
                        for (var k=0; k<druzyna_3.length; k++) {
                           if (druzyna_3[k].checked && data_meczu[0].value && punkty[0].value>=0 && punkty[1].value>=0 && punkty[2].value>=0 && bramki[0].value && bramki[1].value && bramki[2].value && !druzyna_1[k].checked && !druzyna_2[k].checked) {
                              sub_but.disabled = false;
                              break;  // Zatrzymuje pętlę 'k'.
                           } else {
                           sub_but.disabled = true;
                           }
                        }
                     }
                     break; // Zatrzymuje pętlę 'j'.
                  } else {
                     sub_but.disabled = true;
                  }
               }
               break; // Zatrzymuje pętlę 'i'.
            } else {
               sub_but.disabled = true;
            }
          }
         }

         function change_color_1() {
           for (var i=0; i<druzyna_1.length; i++) {
             if (druzyna_1[i].checked && druzyna_2[i].checked && druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'tomato';
                checkbox_2[i].style.backgroundColor = 'tomato';
                checkbox_3[i+1].style.backgroundColor = 'tomato';
             } else if (druzyna_1[i].checked && druzyna_2[i].checked) {
                checkbox_1[i].style.backgroundColor = 'tomato';
                checkbox_2[i].style.backgroundColor = 'tomato';
                checkbox_3[i+1].style.backgroundColor = 'transparent';
             } else if (druzyna_1[i].checked && druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'tomato';
                checkbox_2[i].style.backgroundColor = 'transparent';
                checkbox_3[i+1].style.backgroundColor = 'tomato';
             } else if (druzyna_2[i].checked && druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'transparent';
                checkbox_2[i].style.backgroundColor = 'tomato';
                checkbox_3[i+1].style.backgroundColor = 'tomato';
             } else if (druzyna_1[i].checked || druzyna_2[i].checked || druzyna_3[i].checked) {
                checkbox_1[i].style.backgroundColor = 'transparent';
                checkbox_2[i].style.backgroundColor = 'transparent';
                checkbox_3[i+1].style.backgroundColor = 'transparent';
             }
          }
         }

         function change_color_2() {
            if (data_meczu[0].value != '') {
               data_meczu[0].style.backgroundColor = 'transparent';
            } else {
               data_meczu[0].style.backgroundColor = 'tomato';
            }

            for (var i=0; i<punkty.length; i++) {
               if (punkty[i].value != '') {
                  punkty[i].style.backgroundColor = 'transparent';
               } else {
                  punkty[i].style.backgroundColor = 'tomato';
               }
            }

            for (var i=0; i<punkty.length; i++) {
               if (bramki[i].value != '') {
                  bramki[i].style.backgroundColor = 'transparent';
               } else {
                  bramki[i].style.backgroundColor = 'tomato';
               }
            }
         }

         //------------------------------------------- test -----------------------------
         var but = document.getElementById('but');
         but.onclick = test;
         function test() {

         }
    </script>
</body>
</html>
