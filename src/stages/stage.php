<?php


/**
 * Stage Interface
 *
 * Defines the interface for each of the stages.  Each stage will be called
 * using the public function below and the result is expected as a numerical
 * value.  This allows the plug-and-play engine to correctly quantify what
 * happened.
 *
 * @author Robbie Hott
 */

interface stage {

    /**
     * Run function
     *
     * This function is called by the reconciliation engine to execute this
     * stage of reconciliation.  It will pass the function the name string to
     * be considered.  The function will then perform its work on the string
     * and return a numeric value based on the strength of the string and the
     * computed function.
     *
     * @param identity $search The identity to be evaluated.
     * @param identity[] $list A list of identities to evaluate against.  This
     * may be null.  
     * @return array An array of matches and strengths,
     * `{"id":identity, "strength":float}`.
     *
     */
    public function run($search, $list); 

}
