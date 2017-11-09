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
      fclose($titlefile); ?>
      <p id=movie_title> <?= $title ?> ( <?=$year?>) </p>
  <?php } ?>



    <?php function printTopBar($avg) { ?>
      <div id=top_bar>
      <inline> <img src=images/tomato.png alt=tomato />
      <?= $avg ?>
      <?php printDropDown();?>
      </inline>
      </div>
    <?php } ?>

    <?php function printDropDown() { ?>
       <inline id="dropdown">
       <form method=post action=tomayto.php>
       <select name=movie>
       <?php
         $movies = glob("moviefiles/*", GLOB_BRACE);
         foreach($movies as $movie) {
           $info = fopen($movie . "/info.txt", 'r');
           $title = fgets($info);
           fclose($info);
           if(strcmp($movie, "moviefiles/princessbride") == 0) { ?>
             <option value= <?=$movie?> selected> <?=$title ?> </option>
           <?php } else { ?>
             <option value= <?=$movie?> > <?=$title?> </option>
           <?php }
         }
       ?>
       </select>
       <input type=submit value=Select />
       </inline>
    <?php } ?>

    <?php function printOverview() { ?>
      <div id=right_bar>
      <?php
        $alt = str_replace("moviefiles/", "", $_POST["movie"]); ?>
        <p> <img src= <?= $_POST["movie"] . "/overview.png" ?> alt= <?=$alt?> width=250 height=412 /> </p>
      <dl>
      <?php
        $overviewfile = fopen($_POST["movie"]."/overview.txt", 'r');
        while(($line = fgets($overviewfile)) !== false) {
          $linearray = explode(':', $line); ?>
          <dt> <?=$linearray[0]?>: </dt>
          <dd> <?=$linearray[1]?> </dd>
        <?php }
        fclose($overviewfile);
      ?>
      </dl>
      </div>
    <?php } ?>

    <?php function printCol($colnum, $colstart, $colend, $reviews) { ?>
        <div id= <?= "reviews_col" . $colnum ?>>
        <?php for($i = $colstart; $i < $colend; $i++) {
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
          <?php } ?>
          <?= $reviewtext ?> 
          </p>
          <p> <?= $reviewer ?> </p>
          <p> <?= $reviewerfrom ?> </p>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
	
	
	<?php if(!isset($_POST["movie"])) {
		$_POST["movie"] = "moviefiles/princessbride";
	} ?>
	
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
