<?php
Session::require_user(true);

$db = Database::get();
$infos = getAndMergeEOIInfos($db);



render_page(function() use ($infos) {
	$status_change = $_GET['status_change'] ?? '';
    $status_change_to = $_GET['status_change_to'] ?? '';
    $confirm_change = $_POST['confirm_change'] ?? '';

    //var_dump($status_change, $status_change_to, $confirm_change);
    

    $searchTags = [
        'job_id:' => 'job_id', 
        'user_id:'  => 'user_id', 
        'first_name:'  => 'first_name', 
        'last_name:'  => 'last_name', 
    ];

    echo search_head_html('Change status: ', 'Change', $status_change, true, true, false, true);

    if ($status_change) {
        echo '
            <form method="POST" action="">
                <label>Are you sure you want to change these eois to "' . $status_change_to . '"?</label>
                <input type="Submit" name="confirm_change" value="Confirm Change">
            </form>
            ';

        $terms = explode(';', $status_change);

        $filtered = $infos;

        foreach ($searchTags as $tag => $infoKey) {
            foreach ($terms as $term) {
                $term = trim($term);
                if (str_starts_with($term, $tag)) {
                    $extractedInfo = array_map('trim', explode(',', substr($term, strlen($tag))));

                    

                    $filtered = 
                    array_filter($filtered, function($info) use ($extractedInfo, $infoKey) {
                        if (array_key_exists($infoKey, $info)) {
                            return in_array($info[$infoKey], $extractedInfo);
                        }

                        if (isset($info['applicant_info'][0]) && array_key_exists($infoKey, $info['applicant_info'][0])) {
                            return in_array($info['applicant_info'][0][$infoKey], $extractedInfo);
                        }

                        return false;
                    });
                }
            }

            
        }
        
        foreach ($filtered as $info) { 

            if ($status_change && $status_change_to && $confirm_change) {
                $db = Database::get();
                $db->query('UPDATE eoi SET status = ? WHERE id = ?', [$status_change_to, $info['id']]);
                $info['status'] = $status_change_to;
            } 

            
            render('eoi/eoi_info', $info); 
        }
    } else {
        
        foreach ($infos as $info) { 
            render('eoi/eoi_info', $info); 
        }
    }

    echo '
        </div>
    </section>
    ';
	
},
	title: 'Management',
	style: 'manage',
);
