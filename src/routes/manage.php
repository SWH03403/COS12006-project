<?php
$db = Database::get();
$infos = [];

foreach ($db->query('SELECT * FROM eoi') as $row) {
    $applicant_info = $db->query('SELECT * FROM user_applicant WHERE id = ?', [$row['user_id']]);
    $infos[] = $row + ['applicant_info' => $applicant_info];

    var_dump($row + ['applicant_info' => $applicant_info]);
    // $entry = &$cates[$row['id']];
	// $entry['id'] = "category-" . strtolower(str_replace(' ', '-', $row['name']));
	// $entry['name'] = $row['name'];
	// $entry['entries'] = [];
}
exit;

render_page(function() use ($infos) {
	echo 
    '<aside id="tools-bar" class="flex-y box"><ul>
        <form method="GET" action="search_result.php">
            <label>Search:</label>
            <br>
            <input type="text" name="model" required>
            <input type="submit" value="Search">
        </form>
        <p>Search guide: </p>
        <ul>
            <li>Use tag "job:" to filter for jobs ("jobs: VKE99, ZBA91;") </li>
            <li>Use tag "user_id:" to filter specific applicant id ("user_id: 24125;")</li>
            <li>Use tag "user_name:" to filter specific applicant name ("user_name: Bob, Jake;")</li>
        </ul>
    </aside>

    <div id="listing-eois" class="fill flex-y box">';
    foreach ($infos as $info) { render('eoi/eoi_info', $info); }
    echo '</div>';
	
},
	title: 'Management',
	style: 'manage',
);
