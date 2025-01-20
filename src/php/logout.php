<?php
// Start the session to access session variables
session_start();

// Destroy all session data to log the user out
session_unset();
session_destroy();

// Redirect to the index page after logout
header("Location: /newattendancesystem/src/index.html");
exit();
?>
