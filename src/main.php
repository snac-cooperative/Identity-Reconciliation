<?php
/**
 * Main PHP file that loads and runs the reconciliation engine
 */

// Dependencies
require 'vendor/autoload.php';
require 'reconciliation_engine.php';

$engine = new reconciliation_engine();
$engine->reconcile(new identity("george washington 1732-1799"));
print_r($engine->get_results());

echo "Done";

?>
    
