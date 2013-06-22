<?php
**
** sidebar.php template for multiple side navigation templates
**

$title = get_the_title();
if ($title == "Title of Page") {
   require_once("new-sidebar-template.php");
} elseif ($title == "Title of other Page") {
   require_once("other-sidebar-template.php");
} else {
   require_once("sidenav-all.php");
}

?>
