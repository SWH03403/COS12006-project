<?php
Session::require_user(true);

$db = Database::get();
$infos = getAndMergeEOIInfos($db);

render_page(function() use ($infos) {
	$search = $_GET['search'] ?? '';
    $searchTags = [
        'job_id:' => 'job_id', 
        'user_id:'  => 'user_id', 
        'first_name:'  => 'first_name', 
        'last_name:'  => 'last_name', 
    ];

    echo search_head_html('Search: ', 'Search', $search, false, true, true , false);

    if ($search) {
        $terms = explode(';', $search);

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
            render('eoi/eoi_info', $info); 
        }
    } else {
        foreach ($infos as $info) { render('eoi/eoi_info', $info); }
    }

    echo '
        </div>
    </section>
    ';
	
},
	title: 'Management',
	style: 'manage',
);
