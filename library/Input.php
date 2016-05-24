<?php

class Input
{
    /**
     * Check if a given value was passed in the request
     *
     * @param string $key index to look for in request
     * @return boolean whether value exists in $_POST or $_GET
     */
    public static function has($key)
    {
        $requestCheck = isset($_REQUEST[$key]);
        return $requestCheck;
    }

    /**
     * Get a requested value from either $_POST or $_GET
     *
     * @param string $key index to look for in index
     * @param mixed $default default value to return if key not found
     * @return mixed value passed in request
     */
    public static function get($key, $default = null)
    {
        if (self::has($key) == true) {
            return $_REQUEST[$key];
        } else {
            return null;
        }
    }

    public static function getString($key, $min = 5, $max = 255)
    {
        $potentialString = self::get($key);

        if(!is_numeric($min) || !is_numeric($max) || !is_string($potentialString) ) {
            throw new InvalidArgumentException("Unexpected entry for {$key}.");
        }

        if(!isset($potentialString)) {
            throw new OutOfRangeException("Missing input in {$key}.");
        } 

        if(!is_string($potentialString)) {
            throw new DomainException("Please enter text in {$key}.");
        } 

        if( strlen($potentialString) < $min || strlen($potentialString) > $max ) {
            throw new LengthException("Your entry in {$key} has too few or too many letters.");
        }

        return $potentialString;

    }

    public static function getNumber($key, $min = 1, $max = 12)
    {
        $potentialNumber = self::get($key);

        if(!isset($potentialNumber)) {
            throw new OutOfRangeException("Missing Input in {$key}.");
        }  

        if(!is_numeric($min) || !is_numeric($max) || !is_numeric($potentialNumber) ) {
            throw new InvalidArgumentException("Unexpected entry for {$key}.");
        }

        if($potentialNumber < $min || strlen($potentialNumber) > $max) {
            throw new RangeException("Your entry in {$key} is too small or too big.");
        }

        if(!is_numeric($potentialNumber)) {
            throw new DomainException("Please enter a numeric value in {$key}.");
        } 
            
            $findme = '.';
        
            if(strpos($potentialNumber, $findme) === false) 
            {
                return intval($potentialNumber);
            } else {
                return floatval($potentialNumber);
            }  

    }
    


    ///////////////////////////////////////////////////////////////////////////
    //                      DO NOT EDIT ANYTHING BELOW!!                     //
    // The Input class should not ever be instantiated, so we prevent the    //
    // constructor method from being called. We will be covering private     //
    // later in the curriculum.                                              //
    ///////////////////////////////////////////////////////////////////////////
    private function __construct() {}
}



