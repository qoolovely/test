<?php 
echo $_GET['state'];



$callback = 'https://' . $_SERVER['HTTP_HOST']  . '/callback.php';
if (isset($_GET['code'])) {
  $url = 'https://api.line.me/oauth2/v2.1/token';
  $data = array(
    'grant_type' => 'authorization_code',
    'client_id' => '1546810912',
    'client_secret' => 'a49e8e816f823c6040c17f187546821f',
    'code' => $_GET['code'],
    'redirect_uri' => $callback
  );
  $data = http_build_query($data, '', '&');
  $header = array(
    'Content-Type: application/x-www-form-urlencoded'
  );
  $context = array(
    'http' => array(
      'method'  => 'POST',
      'header'  => implode('\r\n', $header),
      'content' => $data
    )
  );
  $resultString = file_get_contents($url, false, stream_context_create($context));
  $result = json_decode($resultString, true);

  if(isset($result['access_token'])) {
    $url = 'https://api.line.me/v2/profile';
    $context = array(
      'http' => array(
      'method'  => 'GET',
      'header'  => 'Authorization: Bearer '. $result['access_token']
      )
    );
    $profileString = file_get_contents($url, false, stream_context_create($context));
    $profile = json_decode($profileString, true);
    //echo '<img style="width:10%" src="' . htmlspecialchars($profile["pictureUrl"], ENT_QUOTES) . '" />';
    echo '<h2>displayName</h2>';
    echo '<p class="text-muted">' . htmlspecialchars($profile["displayName"], ENT_QUOTES) . '</p>';
    echo '<h2>userId</h2>';
    echo '<p class="text-muted">' . htmlspecialchars($profile["userId"], ENT_QUOTES) . '</p>';
    echo '<h2>accessToken</h2>';
    echo '<p class="text-muted">' . $result['access_token'] . '</p>';

    if(isset($result['id_token'])) {
      $val = explode(".", $result['id_token']);
      $data_json = base64UrlDecode($val[1]);
      echo '<h2>ID_TOKEN</h2>';
      echo '<p class="text-muted">' . $data_json . '</p>';
    }
  }
}
else {
  echo '<p>Login Failed.</p>';
}


function base64UrlDecode($data) {
    $replaced = str_replace(array('-', '_'), array('+', '/'), $data);
    $lack = strlen($replaced) % 4;
    if ($lack > 0) {
        $replaced .= str_repeat("=", 4 - $lack);
    }
    return base64_decode($replaced);
}

?>
