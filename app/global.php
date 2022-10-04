<?php

/** create flash */
function createFlash($type, $message)
{
  $_SESSION['flash'] =  [
    'type' => $type,
    'message' => $message,
  ];
}

/** show flash */
function showFlash()
{
  if (isset($_SESSION['flash'])) {
    ['type' => $type, 'message' => $message] = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return "
		<div class='alert alert-$type'>
			<strong>$type</strong>
			<br>
			$message
		</div>
		";
  }
}

/** redirect */
function redirect($location, $queryStr = [])
{
  if (!empty($queryStr)) {
    foreach ($queryStr as $key => $value) {
      $location .= !str_contains($location, '?') ? '?' : '&';
      $location .= "{$key}=${value}";
    };
  }
  header("location: {$location}");
}

/** terminate page and show error text */
function pageError(int $code)
{
  $text = '';
  switch ($code) {
    case 404:
      http_response_code(404);
      $text = "<h1 style='color:red'>404 Not Found</h1>";
      break;
  }

  die($text);
}
