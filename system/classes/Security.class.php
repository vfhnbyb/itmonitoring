<?php defined('Imperial') or die('No direct script access.');

class Security {
	/**
     * clean
     *
     * @param string	$var
     * @return string
     */
	function clean($var) {
		return str_replace('&ndash;', '–', trim(htmlentities($var, ENT_QUOTES, 'UTF-8')));
        //return mysqli_real_escape_string($var);
        //return trim(mysqli_real_escape_string(htmlentities($var, ENT_QUOTES, 'UTF-8')));
	}


    /**
     * int
     *
     * @param string $var
     * @return int
     */
	function int(string $var) {
		return abs((int)$var);
	}


    /**
     * get
     *
     * @param string $key
     * @return string
     */
    function get(string $key) {
    	return (isset($_GET[$key])) ? $this -> clean($_GET[$key]) : '';
    }


    /**
     * pos
     *
     * @param string $key
     * @return string
     */
    function post(string $key) {
    	return (isset($_POST[$key])) ? $this -> clean($_POST[$key]) : '';
    }

    /**
     * cookie
     *
     * @param string $key
     * @return string
     */
    function cookie(string $key) {
    	return $this -> clean($_COOKIE[$key]);
    }
}