<?php
// Handle regular PHP errors (warnings, notices, etc.)
  set_error_handler(function ($errno, $errstr, $errfile, $errline) {
      http_response_code(500);
      echo json_encode([
          "error"   => "PHP Error",
          "message" => $errstr,
          "file"    => $errfile,
          "line"    => $errline
      ]);
      exit;
  });

// Handle uncaught exceptions
  set_exception_handler(function ($exception) {
      http_response_code(500);
      echo json_encode([
          "error"   => "Exception",
          "message" => $exception->getMessage(),
          "file"    => $exception->getFile(),
          "line"    => $exception->getLine()
      ]);
      exit;
  });

// Handle fatal errors using shutdown function
  register_shutdown_function(function () {
      $error = error_get_last();
      if ($error) {
          http_response_code(500);
          echo json_encode([
              "error"   => "Fatal Error",
              "message" => $error['message'],
              "file"    => $error['file'],
              "line"    => $error['line']
          ]);
          exit;
      }
  });

?>