<?php
ob_start(); // Output Buffering Start
session_start();

include 'system/ini.php';

LoginOrNo(); // I'm login Or no

echo '<h1 class="text-center">Welcom ' . $_SESSION['Name'] . "</div>";

include $foldertemp . 'footer.php';


ob_end_flush(); // Release The Output