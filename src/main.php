<?php
/**
 * Main PHP file that loads and runs the reconciliation engine
 */

// Dependencies
require 'vendor/autoload.php';
require 'reconciliation_engine.php';

$engine = new reconciliation_engine();

// Create the new identity to search
$identity = new identity("");
$identity->original_string = "George Washington 1732";
$identity->name_only = "George Washington";

// Run the reconciliation engine against this identity
$engine->reconcile($identity);

// Print the results
print_r($engine->get_results());

echo json_encode($engine->get_results());

echo "Done";

?>
    
