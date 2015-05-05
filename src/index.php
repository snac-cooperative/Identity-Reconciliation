<?php
/**
 * Web Frontend
 *
 * This script will read from the $_GET variable for URL arguments.
 * It requires a "q" argument with the name to parse and match. It will print out
 * as JSON the results from the reconciliation engine.
 */

// Dependencies
require 'vendor/autoload.php';
require 'reconciliation_engine.php';

header("Content-Type: application/json");

if (isset($_GET['q'])) {

    $engine = new reconciliation_engine();

    // Create the new identity to search
    $identity = new identity($_GET['q']);
    $identity->parse_original();

    // Run the reconciliation engine against this identity
    $engine->reconcile($identity);

    $output = array();
    $output["search_identity"] = $identity;
    $output["results"] = $engine->get_results();

    echo json_encode($output);
}

?>
