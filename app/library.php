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
function redirect($view, $queryStr = [])
{
  $location = "/?v=${view}";
  if (!empty($queryStr)) {
    foreach ($queryStr as $key => $value) {
      $location .= "&{$key}=${value}";
    };
  }
  header("location: {$location}");
}

/** resources */
function resources()
{
}
