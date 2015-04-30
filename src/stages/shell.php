<?php


/**
 * Shell Abstract Class
 *
 * Abstract class that allows a subclass to easily call and report values from
 * a shell script.  This makes it easy for a stage writer to use another
 * language or technology to create the stage.  Once written, a future stage
 * may inherit this class and define the shell script to be called.  Values
 * will be properly passed to the shell script defined by the $script_name
 * field.
 *
 * @author Robbie Hott
 */
abstract class shell implements stage {

    /**
     * Constants
     */
    const OUTPUT_STDOUT = 0;
    const OUTPUT_RETVAL = 1;

    /**
     * Shell script to run.
     *
     * This is the script path and name, including parameters.  It should be of the form:
     *
     * `/path/to/script [options] STRING`
     *
     * Where `STRING` is a literal, which will be replaced by the string passed
     * to the run function below.
     */
    protected $script_name;

    /**
     * Return value location
     *
     * Boolean variable that defines whether the output of the script will be
     * returned on standard out (STDOUT) or will be returned as the exit value
     * of the script.  Use one of the static members above.
     */
    protected $script_output = self::OUTPUT_STDOUT;


    /**
     * Run function
     *
     * Runs the function defined in the $script_name field, replacing `STRING`
     * with the string to be considered.  Takes the return value from the
     * defined output method and returns that to the caller. The string will be
     * escaped and wrapped with single quotes.
     *
     * @param string $string The string to be parsed and/or matched.  
     * @return float A numerical value representing this string's value in regards to
     * the stage's definition
     *
     */
    public function run($string) { 

        // If the string is empty, just return false to note that this did not
        // actually complete
        if (empty($string)) {
            return false;
        }

        // Buffers for output and return value
        $output = array();
        $retval = PHP_INT_MAX;

        // Clean up the string
        $cleaned = escapeshellarg($string);

        // Replace STRING with the cleaned string
        $toexec = str_replace('STRING', $cleaned, $this->script_name);

        // Execute the shell script
        exec($toexec, $output, $retval);

        // Handle the output
        switch($this->script_output) {
            case self::OUTPUT_STDOUT:
                if (!empty($output)) {
                    $return = trim($output[0]);
                    
                    // Check to see if the return value is numeric
                    if (is_numeric($return)) 
                        return floatval($return);
                }
                break;
            case self::OUTPUT_RETVAL:
                return $retval;
                break;
        }
        return false;
    }
}

