<?php
namespace stages;
require_once 'stages/elastic.php';

/**
 * Elastic Search (Name) Stage
 *
 * This stage queries elastic search for the entire original name and returns
 * the list of identities that are the best matches for that string.
 *
 * @author Robbie Hott
 */
class elastic_name extends helpers\elastic {

    /**
     * Name
     */
    protected $name = "elastic_name";

    /**
     * Operator to use
     */
    protected $operator = "AND";


    /**
     * Choose what parts to search
     *
     * @param identity $search The identity to parse
     * @return string The search string;
     */
    protected function get_search_string($search) {
        return $search->name_only;
    }

}
