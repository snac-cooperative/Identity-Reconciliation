<?php
/**
 * Name Reconciliation Engine (Main Class)
 *
 * This class provides the meat of the reconciliation engine. To run the
 * reconciliation engine, create an instance of this class and call the
 * reconcile method.
 *
 * @author Robbie Hott
 */
public class ReconciliationEngine {

    private $results;
    /*
     * Array of tests to perform on the string.  These will have a listing in
     * the battery of tests.  A user may chose a list of tests, a preset list,
     * or write their own. 
     */ 
     private $tests;

    /*
     * Constructor
     */
    public __construct() {

    }

    /*
     * Destructor
     */
    public __destruct() {

    }

}

/*
 * Auto load the stage classes
 */
function __autoload($class_name) {
        include 'stages/' . $class_name . '.php';
}


?>
