<?php
require_once( "../sparqllib.php" );
$endpoint = $_POST['endpoint'];
$db = sparql_connect( $endpoint );
if( !$db ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }

if($_POST['rdf'] == 'checked') {
$db->ns( "rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
}

if($_POST['rdfs'] == 'checked') {
$db->ns( "rdfs","http://www.w3.org/2000/01/rdf-schema#" );
}

if($_POST['owl'] == 'checked') {
$db->ns( "owl","http://www.w3.org/2002/07/owl#" );
}

if($_POST['foaf'] == 'checked') {
$db->ns( "foaf","http://xmlns.com/foaf/0.1/" );
}

if($_POST['dc'] == 'checked') {
$db->ns( "dc","http://purl.org/dc/elements/1.1/" );
}


$n = $_POST['fieldcount'];
$checkboxcheck = $_POST['checkboxcheck'];
$namespace = $_POST['namespace'];
$namespacefull = $_POST['namespacefull'];

print_r($checkboxcheck);
print_r($namespace);
print_r($namespacefull);
foreach( $namespace as $i => $qname){
if( $checkboxcheck[$i] == 'checked' && isset($qname) && isset( $namespacefull[$i] ) {

$ns = $qname;
$nsf = $namespacefull[$i];
$db->ns($ns,$nsf);
}

$sparql = $_POST['query'];
//$sparql = "SELECT * WHERE { ?a ?b ?c } LIMIT 5";
$result = $db->query( $sparql ); 
if( !$result ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
 
$fields = $result->field_array( $result );
 
print "<p>Number of rows: ".$result->num_rows( $result )." results.</p>";
print "<table class='example_table'>";
print "<tr>";
foreach( $fields as $field )
{
	print "<th>$field</th>";
}
print "</tr>";
while( $row = $result->fetch_array() )
{
	print "<tr>";
	foreach( $fields as $field )
	{
		print "<td>$row[$field]</td>";
	}
	print "</tr>";
}
print "</table>";

?>