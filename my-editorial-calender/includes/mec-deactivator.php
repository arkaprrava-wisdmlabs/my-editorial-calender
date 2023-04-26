<?php
function myedcal_deactivation(){
    global $wpdb, $table_prefix;
    $table_name = $table_prefix.'content_calender';
    $q = "TRUNCATE `$table_name`";
    $wpdb->query($q);
}