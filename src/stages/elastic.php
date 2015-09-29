<?php
namespace reconciliation_engine\stages\helpers;
require_once 'stages/stage.php';

/**
 * Elastic Search Abstract Stage
 *
 * This stage provides functionality to query elastic search, allowing for
 * quicker writing of other elastic search based stages.
 *
 * @author Robbie Hott
 */
abstract class elastic implements stage {

    /**
     * @var string Name of the stage
     */
    protected $name = "";

    /**
     * @var string Elastic Search result field to search
     */
    protected $field = "official";

    /**
     * @var string Operator to use in the search
     */
    protected $operator = null;

    /**
     * @var int Number of results to return
     */
    protected $num_results = 25;

    /**
     * @var string Minimum match required (percentage)
     */
    protected $min_match = null;

    /**
     * Get Name
     *
     * Gets the name of the stage and returns it.  This must return a string.
     *
     * @return string Name of the stage.
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Run function
     *
     * Performs the body of the stage
     *
     * @param \identity $search The identity to be evaluated.
     * @param \identity[] $list A list of identities to evaluate against.  This
     * may be null.  
     * @return array An array of matches and strengths,
     * `{"id":identity, "strength":float}`.
     *
     */
    public function run($search, $list) {
        // Get the search string based on the sub-class' method
        $search_string = $this->get_search_string($search);
        $field = $this->field;

        // Create elastic search client
        try {
            $client = \Elasticsearch\ClientBuilder::create()->build();
        } catch (Error $e) {
            die("Could not instantiate Elastic Search");
        }

        $searchParams = array();
        $searchParams['index'] = 'snac';
        $searchParams['type']  = 'search_name';
        $searchParams['body']['query']['match'][$this->field]["query"] = $search_string;
        if ($this->min_match != null)
            $searchParams['body']['query']['match'][$this->field]['minimum_should_match'] = $this->min_match;
        if ($this->operator != null)
            $searchParams['body']['query']['match'][$this->field]['operator'] = $this->operator;
        if ($this->num_results != null)
            $searchParams['body']['size'] = $this->num_results;

        // Run the query
        $queryResponse = $client->search($searchParams);
        
        // Return the results
        $results = array();
        foreach($queryResponse["hits"]["hits"] as $hit) {
            $id = new \identity($hit["_source"]["official"]);
            $id->cpf_postgres_id = $hit["_source"]["cpf_id"];
            $id->cpf_ark_id = $hit["_source"]["ark_id"];
                
            array_push($results, 
                array("id"=> $id, "strength"=> $hit["_score"]));
        }
        return $results;

    } 

    /**
     * Create search string
     *
     * Determines what part of the $search identity should be used as the search string
     *
     * @param identity $search The identity to parse
     * @return string The search string for elastic search
     */
    protected abstract function get_search_string($search);
}
