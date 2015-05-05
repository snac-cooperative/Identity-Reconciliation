<?php
require_once 'stages/stage.php';

/**
 * Elastic Search (Name) Stage
 *
 * This stage queries elastic search for the entire original name and returns
 * the list of identities that are the best matches for that string.
 *
 * @author Robbie Hott
 */
class elastic_name implements stage {

    /**
     * Get Name
     *
     * Gets the name of the stage and returns it.  This must return a string.
     *
     * @return string Name of the stage.
     */
    public function get_name() {
        return "elastic_name";
    }

    /**
     * Run function
     *
     * Performs the body of the stage
     *
     * @param identity $search The identity to be evaluated.
     * @param identity[] $list A list of identities to evaluate against.  This
     * may be null.  
     * @return array An array of matches and strengths,
     * `{"id":identity, "strength":float}`.
     *
     */
    public function run($search, $list) {
        $search_string = $search->original_string;

        $client = new Elasticsearch\Client();

        $searchParams = array();
        $searchParams['index'] = 'snac';
        $searchParams['type']  = 'search_name_ark';
        $searchParams['body']['query']['match']['original'] = $search_string;
        $queryResponse = $client->search($searchParams);

        $results = array();
        foreach($queryResponse["hits"]["hits"] as $hit) {
            $id = new identity($hit["_source"]["official"]);
            $id->cpf_postgres_id = $hit["_source"]["cpf_id"];
            $id->cpf_ark_id = $hit["_source"]["ark_id"];
                
            array_push($results, 
                array("id"=> $id, "strength"=> $hit["_score"]));
        }
        return $results;

    } 

}
