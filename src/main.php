<?php
/**
 * Main PHP file that loads and runs the reconciliation engine
 */

// Dependencies
require 'vendor/autoload.php';
require 'name_reconciliation.php';

$engine = new ReconciliationEngine();
$engine->reconcile(new identity("george washington 1732"));
print_r($engine->get_results());

echo "Done";

?>
    
