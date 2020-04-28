<?php

/**
 * En abstrakt klasse for modeller.
 * En modell holder på data som den henter fra databasen, eller skriver data til databasen.
 */
abstract class Model {

    protected $mysqli;
    protected $logger;

    /**
     * En konstruktør for modeller som tar imot en kobling til en database.
     */
    public function __construct(MySQLi $mysqli, Monolog\Logger $logger) {
        $this->mysqli = $mysqli;
        $this->logger = $logger;
    }

}

?>