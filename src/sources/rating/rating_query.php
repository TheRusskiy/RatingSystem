<?php
class RatingQuery {
    function __construct($query) {
        $this->query = mysql_query($query);
    }
    function execute(){
        while ($row = mysql_fetch_array($this->query)) {
            return $row[0];
        }
        throw new Exception("Nothing found!");
    }
}