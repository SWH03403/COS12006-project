<?php
$db = Database::get();
$infos = [];

foreach ($db->query('SELECT * FROM eoi') as $row) {
    $applicant_info = $db->query('SELECT * FROM user_applicant WHERE id = ?', [$row['user_id']]);
    $infos[] = $row + ['applicant_info' => $applicant_info];

    // var_dump($row + ['applicant_info' => $applicant_info]);
    // $entry = &$cates[$row['id']];
	// $entry['id'] = "category-" . strtolower(str_replace(' ', '-', $row['name']));
	// $entry['name'] = $row['name'];
	// $entry['entries'] = [];
}
//exit;

$search = $_GET['search'] ?? '';
$searchTags = [
    'job:' => 'job_id', 
    'user_id:'  => 'user_id', 
    'first_name:'  => 'first_name', 
    'last_name:'  => 'last_name', 
];

render_page(function() use ($infos, $search, $searchTags) {
	echo 
    '<aside id="tools-bar" class="flex-y box"><ul>
        <form method="GET" action="">
            <label>Search: </label>
            <br>
            <input type="text" name="search" placeholder="user_name: Bob...">
            <input type="submit" value="search">
        </form>

        <p>Search guide: </p>
        <ul>
            <li>Use tag "job:" to filter for jobs ("job: VKE99, ZBA91;") </li>
            <li>Use tag "user_id:" to filter specific applicant id ("user_id: 24125;")</li>
            <li>Use tag "first_name:" to filter specific first name ("first_name: Bob, Jake;")</li>
            <li>Other tags: last_name, user_name (find full name)</li>
        </ul>
    </aside>

    <div id="listing-eois" class="fill flex-y box">';
    if ($search) {
        $terms = explode(';', $search);
        $filtered = $infos;

        foreach ($searchTags as $tag => $infoKey) {
            foreach ($terms as $term) {
                // var_dump($term, $tag);
                // var_dump(str_starts_with($term, $tag));
                $term = trim($term);
                if (str_starts_with($term, $tag)) {
                    $extractedInfo = array_map('trim', explode(',', substr($term, strlen($tag))));

                    $filtered = 
                    array_filter($filtered, function($info) use ($extractedInfo, $infoKey) {
                        return in_array($info[$infoKey], $extractedInfo);
                    });
                }
            }
        }

        // foreach ($terms as $term) {
        //     $term = trim($term);
        //     if (str_starts_with($term, 'job:')) {
        //         $job_ids = array_map('trim', explode(',', substr($term, 4)));
        //         $filtered = array_filter($filtered, function($info) use ($job_ids) {
        //             return in_array($info['job_id'], $job_ids);
        //         });
        //     } elseif (str_starts_with($term, 'user_id:')) {
        //         $user_ids = array_map('trim', explode(',', substr($term, 8)));
        //         $filtered = array_filter($filtered, function($info) use ($user_ids) {
        //             return in_array($info['user_id'], $user_ids);
        //         });
        //     } elseif (str_starts_with($term, 'user_id:')) {
        //         $user_ids = array_map('trim', explode(',', substr($term, 8)));
        //         $filtered = array_filter($filtered, function($info) use ($user_ids) {
        //             return in_array($info['user_id'], $user_ids);
        //         });
        //     } 
        // }
        foreach ($filtered as $info) { render('eoi/eoi_info', $info); }
    } else {
        foreach ($infos as $info) { render('eoi/eoi_info', $info); }
    }

    echo '</div>';
	
},
	title: 'Management',
	style: 'manage',
);
