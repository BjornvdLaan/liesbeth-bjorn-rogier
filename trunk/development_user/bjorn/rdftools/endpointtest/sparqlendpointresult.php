<?php
require_once( "../sparqllib.php" );

$endpoint = $_POST['endpoint'];

$db = sparql_connect( $endpoint );
if( !$db ) { print sparql_errno() . ": " . sparql_error(). "\n"; exit; }

print "<h1>$endpoint</h1>";
if( $db->alive() ) 
{
	print "<p>Status: OK</p>";
}
else
{
	print "<p>Not alive: ".$db->error()."</p>";
}
?>