<?php

function create_response()
{
  $response = new stdClass();
  $response->success = FALSE;
  $response->message = "Unknown Failure";
  $response->found = FALSE;
  $response->data = [];

  return $response;
}

function generate_random_string($size = FALSE)
{
  $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $length = strlen($characters);
  $random_string = "";
  if ($size === FALSE or !is_integer($size)) {
    $size = 26;
  }
  for ($i = 0; $i < $size; $i++) {
    $random_string .= $characters[rand(0, $length - 1)];
  }
  return $random_string;
}
