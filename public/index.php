
<?php
 
  session_start();

  require_once '../src/init.php';

    if (isset($_SESSION['user'])) {
      require_once MODEL_DIR . 'henkilo.php';
      $loggeduser = haeHenkilo($_SESSION['user']);
    } else {
      $loggeduser = NULL;
    }
  
 
  $request = str_replace($config['urls']['baseUrl'],'',$_SERVER['REQUEST_URI']);
  $request = strtok($request, '?');
  $templates = new League\Plates\Engine(TEMPLATE_DIR); 
  
  switch ($request) {
    case '/':
    case '/tapahtumat':
      require_once MODEL_DIR . 'tapahtuma.php';
      $tapahtumat = haeTapahtumat();
      echo $templates->render('tapahtumat',['tapahtumat' => $tapahtumat]);
      break;

      case '/tapahtuma':
        require_once MODEL_DIR . 'tapahtuma.php';
        require_once MODEL_DIR . 'ilmoittautuminen.php';
        $tapahtuma = haeTapahtuma($_GET['id']);
        if ($tapahtuma) {
          if ($loggeduser) {
            $ilmoittautuminen = haeIlmoittautuminen($loggeduser['idhenkilo'],$tapahtuma['idtapahtuma']);
          } else {
            $ilmoittautuminen = NULL;
          }
          echo $templates->render('tapahtuma',['tapahtuma' => $tapahtuma,
                                               'ilmoittautuminen' => $ilmoittautuminen,
                                               'loggeduser' => $loggeduser]);
        } else {
          echo $templates->render('tapahtumanotfound');
        }
        break;
  

        case '/lisaa_tili':
          if (isset($_POST['laheta'])) {
            $formdata = cleanArrayData($_POST);
            require_once CONTROLLER_DIR . 'tili.php';
            $tulos = lisaaTili($formdata,$config['urls']['baseUrl']);
    


        $salasana = password_hash($formdata['salasana1'], PASSWORD_DEFAULT);
        $id = lisaaHenkilo($formdata['nimi'],$formdata['email'],$formdata['discord'],$salasana);
        echo "Tili on luotu tunnisteella $id";
        require_once CONTROLLER_DIR . 'tili.php';
        $tulos = lisaaTili($formdata);
        if ($tulos['status'] == "200") {
          echo $templates->render('tili_luotu', ['formdata' => $formdata]);
          break;
        }
        echo $templates->render('lisaa_tili', ['formdata' => $formdata, 'error' => $tulos['error']]);
        break;

        } else {
          echo $templates->render('lisaa_tili', ['formdata' => [], 'error' => []]);
        break;
      }
      
      case "/kirjaudu":
        case "/kirjaudu":
          if (isset($_POST['laheta'])) {
            require_once CONTROLLER_DIR . 'kirjaudu.php';
            if (tarkistaKirjautuminen($_POST['email'],$_POST['salasana'])) {
              session_regenerate_id();
              $_SESSION['user'] = $_POST['email'];
              header("Location: " . $config['urls']['baseUrl']);
            } else {
    
            echo $templates->render('kirjaudu', [ 'error' => ['virhe' => 'Väärä käyttäjätunnus tai salasana!']]);
          }
        } else {
          echo $templates->render('kirjaudu', [ 'error' => []]);
        }
        break;
  
      case "/logout":
          require_once CONTROLLER_DIR . 'kirjaudu.php';
          logout();
          header("Location: " . $config['urls']['baseUrl']);
          break;
      
      case '/ilmoittaudu':
          if ($_GET['id']) {
          require_once MODEL_DIR . 'ilmoittautuminen.php';
          $idtapahtuma = $_GET['id'];
          if ($loggeduser) {
            lisaaIlmoittautuminen($loggeduser['idhenkilo'],$idtapahtuma);
            }
              header("Location: tapahtuma?id=$idtapahtuma");
            } else {
              header("Location: tapahtumat");
            }
            break;
      
      case '/peru':
          if ($_GET['id']) {
          require_once MODEL_DIR . 'ilmoittautuminen.php';
          $idtapahtuma = $_GET['id'];
          if ($loggeduser) {
            poistaIlmoittautuminen($loggeduser['idhenkilo'],$idtapahtuma);
            }
              header("Location: tapahtuma?id=$idtapahtuma");
              } else {
                header("Location: tapahtumat");  
              }
              break;
              
      case "/vahvista":
          if (isset($_GET['key'])) {
          $key = $_GET['key'];
          require_once MODEL_DIR . 'henkilo.php';
            if (vahvistaTili($key)) {
              echo $templates->render('tili_aktivoitu');
              } else {
                echo $templates->render('tili_aktivointi_virhe');
              }
              } else {
                header("Location: " . $config['urls']['baseUrl']);
              }
                break;
           
          
      
    
  
    default:
      echo $templates->render('notfound');
  }
?> 