<!DOCTYPE html>
<html lang="fi">
  <head>
  <link href="styles/styles.css" rel="stylesheet">
    <title>Parkki - <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
  </head>
  <body>
  <header>
  <header>
      <h1><a href="<?=BASEURL?>">Parkki Business Park</a></h1>
      <div class="profile">
        <?php
          if (isset($_SESSION['user'])) {
            echo "<div>$_SESSION[user]</div>";
            echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
          } else {
            echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
          }
        ?>
      </div>
    </header>

    </header>

    <section>
      <?=$this->section('content')?>
    </section>
    <footer>
      <hr>
      <div>Parkki by Anhop</div>
    </footer>
  </body>
</html>