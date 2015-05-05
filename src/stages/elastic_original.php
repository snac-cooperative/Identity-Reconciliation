<?php
require_once 'stages/elastic_abstract.php';

/**
 * Elastic Search (Name) Stage
 *
 * This stage queries elastic search for the entire original name and returns
 * the list of identities that are the best matches for that string.
 *
 * @author Robbie Hott
 */
class elastic_original extends elastic_abstract {

    /**
     * Name
     */
    protected $name = "elastic_original";

    /**
     * Choose what parts to search
     *
     * @param identity $search The identity to parse
     * @return string The search string;
     */
    protected function get_search_string($search) {
        return $search->original_string;
    }
}