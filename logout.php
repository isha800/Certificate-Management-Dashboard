<?php
session_start();
session_unset();
session_destroy();
header("cache_control: no-store,no-cache,must-revalidate ,max-age=0");
 header("cache-control:post-check=0, pre-check=0,false");
   header("pragma:no-cache");
   header("Expires:0");  
header("Location:log.php");
exit();
?>