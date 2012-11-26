<?php
require_once( "../sparqllib.php" );

getAbstractFromArtistWhArray("Carly Rae Jepsen");

function getAbstractFromArtist($artist) {
	
	$query = "SELECT ?abstract \n";
	$query += "WHERE { \n";
	$query += "?id foaf:name \"".$artist."\" ;\n";
	$query += "<http://dbpedia.org/ontology/abstract> ?abstract .\n";
	$query += "FILTER ( langMatches( lang(?abstract), 'en') || ! langMatches(lang(?abstract),'*')) }";
	echo $query;
	$endpoint = "dbpedia.org/sparql";
	$abstract = execQuerySingle($query, $endpoint);
	echo $abstract;
}

function execQuerySingleWhArray($query, $endpoint) {
	if(isset($query) && isset($endpoint)) {
		$db = sparql_connect( $endpoint );
		if( !$db ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }

		$db->ns( "rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
		$db->ns( "rdfs","http://www.w3.org/2000/01/rdf-schema#" );
		$db->ns( "owl","http://www.w3.org/2002/07/owl#" );
		$db->ns( "foaf","http://xmlns.com/foaf/0.1/" );
		$db->ns( "dc","http://purl.org/dc/elements/1.1/" );
		
		$result = $db->query( $query); 
		if( !$result ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
		 
		$field = $result->field_array( $result );
		$data = $result->fetch_array();
		
		return $data[$field[0]];
		
		/*print "Fields";
		foreach( $fields as $field ) {
			print "$field";
		}
		
		while( $row = $result->fetch_array() )
		{
			foreach( $fields as $field  {
				print "$row[$field]";
			}
		}
		*/
		
	}
}

function execQuerySingle($query, $endpoint, $nsarray = array() ) {
	if(isset($query) && isset($endpoint)) {
		$db = sparql_connect( $endpoint );
		if( !$db ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }

		$db->ns( "rdf","http://www.w3.org/1999/02/22-rdf-syntax-ns#" );
		$db->ns( "rdfs","http://www.w3.org/2000/01/rdf-schema#" );
		$db->ns( "owl","http://www.w3.org/2002/07/owl#" );
		$db->ns( "foaf","http://xmlns.com/foaf/0.1/" );
		$db->ns( "dc","http://purl.org/dc/elements/1.1/" );
		if(isset($nsarray)) {
			foreach($nsarray as $ns) {
				$arr = explode(",",$ns);
				$db->ns($arr[0], $arr[1]);
			}
		}
		$result = $db->query( $query); 
		if( !$result ) { print $db->errno() . ": " . $db->error(). "\n"; exit; }
		 
		$field = $result->field_array( $result );
		$data = $result->fetch_array();
		
		return $data[$field[0]];
		
		/*print "Fields";
		foreach( $fields as $field ) {
			print "$field";
		}
		
		while( $row = $result->fetch_array() )
		{
			foreach( $fields as $field  {
				print "$row[$field]";
			}
		}
		*/
		
	}
}
?>