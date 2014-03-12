<?php 
ob_end_clean();
header("Content-type: application/pdf");
echo $content_for_layout;
?>