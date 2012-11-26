<?php

class Sparql {

    public function checkStatus() {
        return true;
    }

    public function getAbstractFromArtist($artist) {
        $query = "SELECT ?abstract WHERE { ?id foaf:name \"" . $artist . "\"@en ; <http://dbpedia.org/ontology/abstract> ?abstract . FILTER ( langMatches( lang(?abstract), 'en') || ! langMatches(lang(?abstract),'*')) }";

        $endpoint = "dbpedia.org/sparql";
        $abstract = $this->execQuerySingle($query, $endpoint);
        return $abstract;
    }

    public function getSpouseFromArtist($artist) {
        $query = "SELECT ?artist2_name WHERE { ?artist1 a mo:MusicArtist; foaf:name \"" . $artist . "\" . ?artist2 a mo:MusicArtist; foaf:name ?artist2_name . ?artist1 rel:spouseOf ?artist2 . }";
        $endpoint = "dbtune.org/musicbrainz/sparql";
        $extraNS = array("rel,http://purl.org/vocab/relationship/", "mo,http://purl.org/ontology/mo/");
        $partner = $this->execQuerySingle($query, $endpoint, $extraNS);
        return $partner;
    }

    private function execQuerySingle($query, $endpoint, $nsarray = array()) {
        if (isset($query) && isset($endpoint)) {
            $db = sparql_connect($endpoint);
            if (!$db) {
                print $db->errno() . ": " . $db->error() . "\n";
                exit;
            }

            $db->ns("rdf", "http://www.w3.org/1999/02/22-rdf-syntax-ns#");
            $db->ns("rdfs", "http://www.w3.org/2000/01/rdf-schema#");
            $db->ns("owl", "http://www.w3.org/2002/07/owl#");
            $db->ns("foaf", "http://xmlns.com/foaf/0.1/");
            $db->ns("dc", "http://purl.org/dc/elements/1.1/");
            if (isset($nsarray)) {
                foreach ($nsarray as $ns) {
                    $arr = explode(",", $ns);
                    $db->ns($arr[0], $arr[1]);
                }
            }
            $result = $db->query($query);
            if (!$result) {
                print $db->errno() . ": " . $db->error() . "\n";
                exit;
            }

            $fields = $result->field_array($result);
            $abstract = '';
            $length = -1;
            while ($data = $result->fetch_array()) {
                if (strlen($data['abstract']) > $length) {
                    $abstract = $data['abstract'];
                    $length = strlen($data['abstract']);
                }
            }

            return $abstract;
        }
    }

}