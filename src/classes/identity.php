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
     * string Postgres CPF ID
     */
    public $cpf_postgres_id = null;

    /**
     * string ARK ID
     */
    public $cpf_ark_id = null;

    /**
     * Constructor
     *
     * @param string $string The original string to construct this identity
     */
    function __construct($string) {
        $this->original_string = $string;
    }

    /**
     * String Of the class
     */
    function __toString() {
        return "identity: " . $this->original_string;
    }

    /**
     * Get Unique ID
     *
     * This returns a unique id for this particular identity object.  It
     * should continue to be a hash of the values.
     *
     * @return string unique identifier for this identity
     */
    function unique_id() {
        return md5($this->original_string);
    }
}
