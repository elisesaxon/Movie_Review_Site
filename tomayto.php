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

  <?php function printTitle() {
      $titlefile = fopen($_POST["movie"]."/info.txt", 'r');
      $title = fgets($titlefile);
      $year = trim(fgets($titlefile));
      fclose($titlefile);
      echo "<p id=movie_title> $title ($year) </p>";
    } ?>



    <?php function printTopBar($avg) { ?>
      <p id=top_bar>
      <img src=images/tomato.png alt=tomato />
      <?php
        echo "$avg";
        printDropDown();
      ?>
      </p>
    <?php } ?>

    <?php function printDropDown() { ?>
       <form method=post action=tomayto.php>
       <select name=movie>
       <?php
         $movies = glob("moviefiles/*", GLOB_BRACE);
         foreach($movies as $movie) {
           $info = fopen($movie . "/info.txt", 'r');
           $title = fgets($info);
           fclose($info);
           if(strcmp($movie, "moviefiles/princessbride") == 0) {
             echo "<option value=$movie selected>$title</option>";
           } else {
             echo "<option value=$movie>$title</option>";
           }
         }
       ?>
       </select>
       <input type=submit value=Select />
    <?php } ?>

    <?php function printOverview() { ?>
      <div id=right_bar>
      <?php
        $alt = str_replace("moviefiles/", "", $_POST["movie"]);
        echo "<p> <img src=".$_POST["movie"]."/overview.png alt=$alt/> </p>";
      ?>
      <dl>
      <?php
        $overviewfile = fopen($_POST["movie"]."/overview.txt", 'r');
        while(($line = fgets($overviewfile)) !== false) {
          $linearray = explode(':', $line);
          echo "<dt>$linearray[0]:</dt>";
          echo "<dd>$linearray[1]</dd>";
        }
        fclose($overviewfile);
      ?>
      </dl>
      </div>
    <?php } ?>

    <?php function printCol($colnum, $colstart, $colend, $reviews) {
        echo "<div id=reviews_col" . $colnum . ">";
        for($i = $colstart; $i < $colend; $i++) {
          $reviewfile = fopen($reviews[$i], 'r');
          $reviewtext = fgets($reviewfile);
          $tomatos = fgets($reviewfile);
          $reviewer = fgets($reviewfile);
          $reviewerfrom = fgets($reviewfile);
          fclose($reviewfile); ?>

          <div class=review>
          <p>
          <?php for($j = 0; $j < $tomatos; $j++) { ?>
            <img src=images/tomatosmall.png alt=tomatosmall/>
          <?php }
          echo "$reviewtext </p>";
          echo "<p>$reviewer</p>";
          echo "<p>$reviewerfrom</p>"; ?>
          </div>
        <?php } ?>
      </div>
    <?php } ?>


    <h1>Tomayto/Tomahto</h1>

    <?php printTitle(); ?>

    <div id=main_block>

    <?php
      printOverview();

      $reviews = glob($_POST["movie"]."/review*.txt", GLOB_BRACE);

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
    ?>

    </div>

    <h1>Tomayto/Tomahto</h1>

</body>
</html>
