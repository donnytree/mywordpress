mywordpress
===========

I have been developing and programming in Wordpress for several years. I reuse a lot of the same code, and thought I would post some here that you might find helpful. Caveat: a lot of this code is hacked from other places, useful resources include http://wordpress.stackexchange.com/, http://codex.wordpress.org/Function_Reference, and http://stackoverflow.com/ 

For multiple side navigation templates, in your "sidebar.php" file:
```php
<?php 
$title = get_the_title();
if ($title == "Title of Page") {
   require_once("new-sidebar-template.php");
} elseif ($title == "Title of other Page") {
   require_once("other-sidebar-template.php");
} else {
   require_once("sidenav-all.php");
}
?>
```
