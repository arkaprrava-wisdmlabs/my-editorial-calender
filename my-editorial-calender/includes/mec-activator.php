<?php
function myedcal_activation(){
    global $wpdb, $table_prefix;
    $table_name = $table_prefix.'content_calender';
    $q = "CREATE TABLE IF NOT EXISTS `$table_name` (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        day DATE NOT NULL,
        occasion varchar(10) NOT NULL,
        post_title varchar(10) NOT NULL,
        author varchar(10) NOT NULL,
        reviewer varchar(100) NOT NULL,
        PRIMARY KEY  (id)
    )";
    $wpdb->query($q);
}