<?php
function myedcal_admin_menu() {
    add_menu_page(
        __('Editorial Calender','myedcal'),
        'Editorial Calender',
        'manage_options',
        'editorial-calender',
		'myedcal_content_menu',
        '',
        100
    );
    add_submenu_page(
		'editorial-calender',
		__('Schedule Calender', 'myedcal'),
		'Schedule Calender',
		'manage_options',
		'schedule-calender',
		'myedcal_schedule_calender_menu',
	);
}
function myedcal_content_menu(){
    global $wpdb, $table_prefix;
    $table_name = $table_prefix.'content_calender';
    $q = "SELECT * FROM `".$table_name."`";
    $results = $wpdb->get_results($q);
    ob_start()
    ?>
    <table class="wp-list-table widefat fixed striped table-view-excerpt posts" style="width:99%;">
        <thead>
            <tr>
                <th>Post Title</th>
                <th>Occasion</th>
                <th>Author</th>
                <th>Day</th>
                <th>Reviewer</th>
            </tr>
            <tbody>
                <?php
                    foreach($results as $result){
                ?>
                <tr>
                    <td><?php echo $result->post_title; ?></td>
                    <td><?php echo $result->occasion; ?></td>
                    <td><?php echo $result->author; ?></td>
                    <td><?php echo $result->day; ?></td>
                    <td>
                    <?php 
                    $reviewers = maybe_unserialize($result->reviewer);
                    foreach($reviewers as $reviewer){
                        echo $reviewer;
                        echo "<br>";
                    } ?>
                    </td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </thead>
    </table>
    <?php
    $html = ob_get_clean();
    echo $html;
}
function myedcal_schedule_calender_menu(){
    $reviewers = get_users(array(
        'role__in' => array('subscriber')
    ));
    $authors = get_users(array(
        'role__in' => array('author')
    ));
    ob_start()
    ?>
    <form method="post" style="display:block; padding:1rem; width:10%;">
        <label for="day">Day</label>
        <input type="date" name="day" id="day" style="margin:0.5rem;">
        <label for="occasion">Occasion</label>
        <input type="text" name="occasion" id="occasion" style="margin:0.5rem;">
        <label for="post-title">Post Title</label>
        <input type="text" name="post-title" id="post-title" style="margin:0.5rem;">
        <label for="author">Author</label>
        <select name="author" id="author" style="margin:0.5rem;">
            <?php 
                foreach($authors as $author){
                    ?>
                    <option value="<?php echo $author->user_login; ?>"><?php echo $author->user_login; ?></option>
                    <?php
                }
            ?>
        </select>
        <label for="reviewer">Reviewer</label><br>
        <?php 
            foreach($reviewers as $reviewer){
                ?>
                <input type="checkbox" name="reviewer[]" value="<?php echo $reviewer->user_login; ?>" style="margin:0.5rem;"><?php echo $reviewer->user_login; ?>
                <?php
            }
        ?>
        <button type="submit" name="submit">Submit</button>
    </form>
    <?php
    $html = ob_get_clean();
    echo $html;
    global $wpdb, $table_prefix;
    $table_name = $table_prefix.'content_calender';
    if ( isset( $_POST['submit'] )){
        $post_meta = array(
            'day'=>$wpdb->escape($_POST['day']),
            'occasion' => $wpdb->escape($_POST['occasion']),
            'post-title' => $wpdb->escape($_POST['post-title']),
            'author' => $wpdb->escape($_POST['author']),
            'reviewer' => maybe_serialize($wpdb->escape($_POST['reviewer']))
        );    
        $q = "INSERT INTO `".$table_name."` (`day`, `occasion`, `post_title`, `author`, `reviewer`)
        VALUES ('".$post_meta['day']."', '".$post_meta['occasion']."', '".$post_meta['post-title']."', '".$post_meta['author']."', '".$post_meta['reviewer']."');";
        $wpdb->query($q);
        echo "<h1>Inserted Successfully</h1>";
    }
}
