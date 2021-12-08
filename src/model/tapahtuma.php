<?php

  require_once HELPERS_DIR . 'DB.php';

  function haeTapahtumat() {
    return DB::run('SELECT * FROM bp_tapahtuma ORDER BY tap_alkaa;')->fetchAll();
  }

  function haeTapahtuma($id) {
    return DB::run('SELECT * FROM bp_tapahtuma WHERE idtapahtuma = ?;',[$id])->fetch();
  }

  if ($loggeduser) {
    if (!$ilmoittautuminen) {
      echo "<div class='flexarea'><a href='ilmoittaudu?id=$tapahtuma[idtapahtuma]' class='button'>ILMOITTAUDU</a></div>";    
    } else {
      echo "<div class='flexarea'>";
      echo "<div>Olet ilmoittautunut tapahtumaan!</div>";
      echo "<a href='peru?id=$tapahtuma[idtapahtuma]' class='button'>PERU ILMOITTAUTUMINEN</a>";
      echo "</div>";
    }
  }


?>
 