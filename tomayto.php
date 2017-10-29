<!--
  Elise Saxon
  CS342: Web Scripting
  Due Nov 7, 2017

  Tomayto/tomahto website: A site formatted based on Homework #3
  specifications. Practice with PHP concepts.
  This file reads in data from various movie data files and is
  styled by tomayto.css.
-->

<html>
<head>
  <title>Tomaytos/Tomahtos</title>
  <link rel='stylesheet' type='text/css' href='tomayto.css'/>; 
</head>
<body>
  <select name="movie">

  <?php
    $movies = glob('moviefiles/*', GLOB_BRACE);
    foreach($movies as $movie) {
      $info = fopen($movie . "/info.txt", 'r');
      $title = fgets($info);
      fclose($info);

      echo $title;
      echo "<option value=".$title.">".$title."</option>";
    }
    ?>
    <option name="movie"> </option>
  </select>

  <input type="submit" name="submitMovie" value="Select" />
</body>
</html>
