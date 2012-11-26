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

if(isset($_POST['checkbox1']) && $_POST['checkbox1'] == 'checked') {
$ns1 = $_POST['namespace1'];
$ns1f = $_POST['namespace1full'];
$db->ns($ns1,$ns1f);
}

if(isset($_POST['checkbox2']) && $_POST['checkbox2'] == 'checked') {
$ns2 = $_POST['namespace2'];
$ns2f = $_POST['namespace2full'];
$db->ns($ns2,$ns2f);
}

if(isset($_POST['checkbox3']) && $_POST['checkbox3'] == 'checked') {
$ns3 = $_POST['namespace3'];
$ns3f = $_POST['namespace3full'];
$db->ns($ns3,$ns3f);
}

if(isset($_POST['checkbox4']) && $_POST['checkbox4'] == 'checked') {
$ns1 = $_POST['namespace4'];
$ns1f = $_POST['namespace4full'];
$db->ns($ns4,$ns4f);
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