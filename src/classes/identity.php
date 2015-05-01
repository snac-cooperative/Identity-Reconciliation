<?php

/**
 * Identity Class
 *
 * This class contains the entire information about a given identity, broken
 * down into pieces.  The reconciliation engine expects an input token string
 * (or identity) to be broken down into individual pieces through the use of a
 * parser or other mechanism.  The original string (if one exists) may be
 * included in this identity.  In fact, some of the pieces of the engine will
 * make use of this original "search" string.  However, the full power of the
 * system cannot be utilized unless that string is parsed.
 *
 * As more information is available to our system, the number of fields in this
 * class should increase.  However, they should never decrease to maintain
 * compatibility.
 *
 * @author Robbie Hott
 */

class identity {

    /**
     * Publicly accessible data fields
     */

    /**
     * string Original string
     */
    public $original_string = "";

    /**
     * string Entity type
     */
    public $entity_type = null;

    /**
     * Constructor
     *
     * @param string $string The original string to construct this identity
     */
    function __construct($string) {
        $original_string = $string;
    }
}
