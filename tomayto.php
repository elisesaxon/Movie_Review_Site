<!--
  Elise Saxon
  CS342: Web Scripting
  Due Nov 7, 2017

  Tomayto/tomahto website: A site formatted based on Homework #3
  specifications. Practice with PHP concepts.
  This file reads in data from various movie data files and is
  styled by tomayto.css.

  To run in browser: http://192.168.64.2/Movie_Review_Site/tomayto.php
-->

<html>
<head>
  <title>Tomaytos/Tomahtos</title>
  <link rel='stylesheet' type='text/css' href='tomayto.css'/>
</head>
<body>

  <?php
    function printDropDown() {
       /*echo <select name=movie>";
        $movies = glob('moviefiles/*', GLOB_BRACE);
        foreach($movies as $movie) {
          $info = fopen($movie . "/info.txt", 'r');
          $title = fgets($info);
          fclose($info);
          echo "<option value=".$title.">".$title."</option>";
        }
        echo "<option name=movie> </option>";
      echo "</select>";
      echo "<input type=submit name=submitMovie value=Select />";
      */
    }

    function printTitle() {
      $titlefile = fopen("moviefiles/mortalkombat/info.txt", 'r');
      $title = fgets($titlefile);
      $year = trim(fgets($titlefile));
      fclose($titlefile);
      echo "<p id=movie_title> $title ($year) </p>";
    }

    function printTopBar($avg) {
      echo"<p id=top_bar>";
      echo "<img src=images/tomato.png alt=tomato />";
      echo "$avg";
      printDropDown();
      echo "</p>";
    }

    function printOverview() {
      echo "<div id=right_bar>";
      echo "<p> <img src=moviefiles/mortalkombat/overview.png alt=mortalkombat/> </p>";
      echo "<dl>";
      $overviewfile = fopen("moviefiles/mortalkombat/overview.txt", 'r');
      while(($line = fgets($overviewfile)) !== false) {
        $linearray = explode(':', $line);
        echo "<dt>$linearray[0]:</dt>";
        echo "<dd>$linearray[1]</dd>";
      }
      fclose($overviewfile);
      echo "</dl>";
      echo "</div>";
    }

    function printCol($colnum, $colstart, $colend, $reviews) {
        echo "<div id=reviews_col" . $colnum . ">";
        for($i = $colstart; $i < $colend; $i++) {
          $reviewfile = fopen($reviews[$i], 'r');
          $reviewtext = fgets($reviewfile);
          $tomatos = fgets($reviewfile);
          $reviewer = fgets($reviewfile);
          $reviewerfrom = fgets($reviewfile);
          fclose($reviewfile);

          echo "<div class=review>";
          echo "<p>";
          for($j = 0; $j < $tomatos; $j++) {
            echo "<img src=images/tomatosmall.png alt=tomatosmall/>";
          }
          echo "$reviewtext </p>";
          echo "<p>$reviewer</p>";
          echo "<p>$reviewerfrom</p>";
          echo "</div>";
        }
      echo "</div>";
    }


    echo "<h1>Tomayto/Tomahto</h1>";

    printTitle();

    echo "<div id=main_block>";

    printOverview();

    $reviews = glob("moviefiles/mortalkombat/review*.txt", GLOB_BRACE);

    $avg = 0;
    foreach($reviews as $review) {
      $reviewarray = file($review);
      $avg = $avg + (int)$reviewarray[1];
    }
    $avg = $avg / sizeof($reviews);
    printTopBar(round($avg, 1));

    $maxcol = ceil(sizeof($reviews)/2);
    printCol(1, 0, $maxcol, $reviews);
    printCol(2, $maxcol, sizeof($reviews), $reviews);



    echo "</div>";

    echo "<h1>Tomayto/Tomahto</h1>";
  ?>
</body>
</html>
