<?php
require_once 'stages/elastic.php';

/**
 * Elastic Search (Name) Stage
 *
 * This stage queries elastic search for the entire original name and returns
 * the list of identities that are the best matches for that string. 75% of the
 * original string must be matched
 *
 * @author Robbie Hott
 */
class elastic_seventyfive extends elastic {

    /**
     * Name
     */
    protected $name = "elastic_seventyfive";

    /**
     * Must match threshold
     */
    protected $min_match = "75%";

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
