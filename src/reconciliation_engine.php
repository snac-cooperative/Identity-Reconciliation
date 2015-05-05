<?php
require 'classes/identity.php';
require 'classes/static_weight.php';
require 'stages/elastic_name.php';

/**
 * Name Reconciliation Engine (Main Class)
 *
 * This class provides the meat of the reconciliation engine. To run the
 * reconciliation engine, create an instance of this class and call the
 * reconcile method.
 *
 * @author Robbie Hott
 */
class reconciliation_engine {

    /**
     * Raw test results directly from the tests.  This is going to be per
     * test, then per ID.  Later, they will be parsed into a per ID, per test.
     */
    private $raw_results;

    /**
     * Array of tests to perform on the string.  These will have a listing in
     * the battery of tests.  A user may chose a list of tests, a preset list,
     * or write their own. 
     */ 
    private $tests;

    /**
     * Full test results per id
     */
    private $results;

    /**
     * Instance of the weighting class to produce the final value of a
     * weighted result vector.
     */
    private $weight;

    /**
     * Constructor
     */
    public function __construct() {
        $this->raw_results = array();
        $this->tests = array(new elastic_name());
        $this->results = array();
        $this->weight = new static_weight();
        return;
    }

    /**
     * Destructor
     */
    public function __destruct() {
        return;
    }

    /**
     * Main reconciliation function
     *
     * This function does the reconciliation and returns the top identity from
     * the engine.  Other top identities and their corresponding score vectors
     * may be obtained by other functions within this class.  
     * @param identity $identity The identity to be searched. This identity 
     * must be in the proper form 
     * @return identity The top identity by the reconciliation
     * engine
     */
    public function reconcile($identity) {
        echo $identity . "\n" . $identity->original_string . "\n";
        // Run the tests and collect the results
        foreach ($this->tests as $test) {
            $this->raw_results[$test->get_name()] = $test->run($identity, null);
        }

        // Fix up the results by organizing them by name, then by test
        $this->collate_results();

        // Generate all the scores
        $this->generate_scores();

        // Sort by score
        $this->sort_results();

        // Return the top result from the list
        return $this->top_result();
    }

    /**
     * Get the top result
     *
     * Returns the top result from the result set
     *
     * @return identity The top identity by the reconciliation engine
     */
    public function top_result() {
        if (count($this->results) > 0)
            return $this->results[0]["identity"];
        else
            return null;
    }

    /**
     * Get the top result vector
     *
     * Returns the vector of result values for the top result
     *
     * @return array The result vector for the top result
     */
    public function top_vector() {
        if (count($this->results) > 0) 
            return $this->results[0]["vector"];
        else
            return null;
    }

    /**
     * Get the top result value
     *
     * Returns the numeric value for the top result
     *
     * @return float The numerical value for the top result
     */
    public function top_value() {
        if ($this->top_vector() != null) 
            return $this->results[0]["score"];
        else
            return 0;
    }

    /**
     * Generate Scores
     *
     * Generates all the scores for each vector in the results
     */
    public function generate_scores() {
        foreach ($this->results as $i => $res) {
            $this->results[$i]["score"] = $this->weight->compute($res["vector"]);
        }
    }

    /**
     * Collate Results
     *
     * This function takes the raw output of the reconciliation engine and
     * reformats it back to results that can be easily parsed by id.
     * Specifically, it takes the results of the per-test values and returns
     * them per-id.
     */
    public function collate_results() {
        $tmp = array();
        foreach ($this->raw_results as $test => $res_list) {
            foreach ($res_list as $res) {
                // Get Unique ID for this identity
                $k = $res["id"]->unique_id();
                // Create entry in the array if it doesn't exist
                if (!array_key_exists($k, $tmp)) {
                    $tmp[$k] = array("identity"=>$res["id"],
                                     "score" => 0,
                                     "vector" => array());
                }
                // Store the strength value in the vector
                $tmp[$k]["vector"][$test] = $res["strength"];
            }
        }
        // Push the results on the result array
        foreach ($tmp as $res) 
            array_push($this->results, $res);
    }

    /**
     * Sort results
     *
     * Sorts the results by score, highest to lowest
     */
    private function sort_results() {
        usort($this->results, array("reconciliation_engine", "results_rsort"));
    }

    /**
     * Get all results
     *
     * @return array The full array of results
     */
    public function get_results() {
        return $this->results;
    }
    
    /**
     * Reverse sort of results
     */
    public static function results_rsort($a, $b) {
         if ($a["score"] == $b["score"])
             return 0;
         return ($a["score"] < $b["score"]) ? 1 : -1;
     }

    /**
     * Auto load the stage classes
     */
    function __autoload($class_name) {
            include 'stages/' . $class_name . '.php';
    }

}


/**
 * Auto load the stage classes
 */
function __autoload($class_name) {
        include 'stages/' . $class_name . '.php';
}


?>