<?php
/* Template Name: Final Job Listing Temp */
get_header();

$linkedin_rapidapi_jobs_saved_data = $_SESSION['linkedin_rapidapi_jobs'];

if(empty($linkedin_rapidapi_jobs_saved_data) || (time() - $_SESSION['linkedin_rapidapi_loggedtime']) > 691200) { //5days = 432000, 8days = 691200

    $curl = curl_init();
    
    ////From Office Account
    // curl_setopt_array($curl, [
    //         CURLOPT_URL => "https://linkedin-api8.p.rapidapi.com/search-jobs?keywords=developer&locationId=103644278&datePosted=anyTime&sort=mostRelevant",
    //     // CURLOPT_URL => "https://linkedin-api8.p.rapidapi.com/search-jobs?datePosted=anyTime&sort=mostRelevant",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 30,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "GET",
    //     CURLOPT_HTTPHEADER => [
    //         "x-rapidapi-host: linkedin-api8.p.rapidapi.com",
    //         "x-rapidapi-key: ac36d5deeemsh88bafde352c8b87p1c36bcjsn4b1a67ef1172"
    //     ],
    // ]);
    
    ////From Suraj Account
    curl_setopt_array($curl, [
    	CURLOPT_URL => "https://linkedin-api8.p.rapidapi.com/search-jobs?locationId=103644278&datePosted=anyTime&sort=mostRelevant",
    	CURLOPT_RETURNTRANSFER => true,
    	CURLOPT_ENCODING => "",
    	CURLOPT_MAXREDIRS => 10,
    	CURLOPT_TIMEOUT => 30,
    	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    	CURLOPT_CUSTOMREQUEST => "GET",
    	CURLOPT_HTTPHEADER => [
    		"x-rapidapi-host: linkedin-api8.p.rapidapi.com",
    		"x-rapidapi-key: 0e410c8febmshe2aef2ee9a753eap192b95jsna5a60e9018c0"
    	],
    ]);
    
    $linkedin_rapidapi_jobs_json = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        
        $_SESSION['linkedin_rapidapi_jobs'] = $linkedin_rapidapi_jobs_json;
        $_SESSION['linkedin_rapidapi_loggedtime'] = time();
        
        // echo 'Generated:';
        // echo '<pre>';
        // print_r(json_decode($linkedin_rapidapi_jobs_json));
        // echo '</pre>';
        
        $lndin_array_data = json_decode($linkedin_rapidapi_jobs_json)->data;
        
    } 
} else {
    
    // echo 'Saved data:';
    // echo '<pre>';
    // print_r(json_decode($linkedin_rapidapi_jobs_saved_data)->data);
    // echo '</pre>';
    
    $lndin_array_data = json_decode($linkedin_rapidapi_jobs_saved_data)->data;
    
}
$get_title = $_GET['title'] ?? '';
?>

<section class="pt-[145px]">
    <div class="container mx-auto">
        <figure class="w-full h-[450px]">
            <img class="w-full h-full object-cover rounded-[6px]" src="<?php echo get_template_directory_uri(); ?>/images/find-your-job.png" alt=" footer bg" />
        </figure>
        <form class="job-input-wrapper relative mt-10 p-2">
            <input class="w-full border border-[#D9D9D9] bg-transparent rounded-[6px] outline-none py-3 pl-[44px]" type="text" placeholder="Search Job title or keyword" name="title" value="<?php echo $_GET['title']; ?>">
            <svg class="absolute top-1/2 -translate-y-1/2 left-7" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 17L13.1396 13.1396M13.1396 13.1396C13.7999 12.4793 14.3237 11.6953 14.6811 10.8326C15.0385 9.96978 15.2224 9.04507 15.2224 8.11121C15.2224 7.17735 15.0385 6.25264 14.6811 5.38987C14.3237 4.5271 13.7999 3.74316 13.1396 3.08283C12.4793 2.42249 11.6953 1.89868 10.8326 1.54131C9.96978 1.18394 9.04507 1 8.11121 1C7.17735 1 6.25264 1.18394 5.38987 1.54131C4.5271 1.89868 3.74316 2.42249 3.08283 3.08283C1.74921 4.41644 1 6.2252 1 8.11121C1 9.99722 1.74921 11.806 3.08283 13.1396C4.41644 14.4732 6.2252 15.2224 8.11121 15.2224C9.99722 15.2224 11.806 14.4732 13.1396 13.1396Z" stroke="#898A8E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <button class="text-[#FFFFFF] flex gap-[6px] justify-center items-center rounded-[4px] bg-[#000080] px-8 py-3 leading-[1] absolute top-1/2 -translate-y-1/2 right-3">Find jobs <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.01271L1.48241 4.99976L0 0.986816H1.60381L7 4.99976L1.60381 9.01271H0Z" fill="white" />
                </svg>
            </button>
        </form>
        
        
        <div class="job-card-sec grid grid-cols-4 gap-9 mt-10">
            <?php
            foreach($lndin_array_data as $ldata) {
                
                $job_link = $ldata->url;
                $company_name = $ldata->company->name; 
                $company_url = $ldata->company->url;
                $job_title = $ldata->title;
                $job_location = $ldata->location;
                $job_icon = $ldata->company->logo;
                if(!$job_icon) $job_icon = get_template_directory_uri().'/images/job-icon.png';
                
                if(empty($_GET['title']) || ($get_title && stripos($job_title, $get_title) !== false) || ($get_title && stripos($job_location, $get_title) !== false)) {
                
                    echo '
                    <div class="job-card">
                        <img src="'.$job_icon.'" height="50" width="50"/>
                        <p class="job-organization">'.$ldata->benefits.' <span>'.$ldata->postDate.'</span></p>
                        <h3 class="job-title">'.$job_title.'</h3>
                        <ul class="job-type">
                            <li>'.$ldata->type.'</li>
                        </ul>
                        <div class="flex justify-between pt-[10px]">
                            <div>
                                <span class="job-location">'.$job_location.'</span>
                            </div>
                            <a href="'.$ldata->url.'" target="_blank">
                                <button class="job-apply-btn">Apply
                                    <svg width="7" height="10" viewBox="0 0 7 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 9.01271L1.48241 4.99976L0 0.986816H1.60381L7 4.99976L1.60381 9.01271H0Z" fill="white" />
                                    </svg>
                                </button>
                            </a>
                        </div>
                    </div>';
                    
                }
            }
            ?>
        </div>
        <!--<div class="pagination-sec">-->
        <!--    <a href="" class="pagination-btn">-->
        <!--        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
        <!--            <path d="M15.8337 10.0003H4.16699M4.16699 10.0003L10.0003 15.8337M4.16699 10.0003L10.0003 4.16699" stroke="#344054" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />-->
        <!--        </svg>-->
        <!--        <span>Previous</span>-->
        <!--    </a>-->
        <!--    <div class="page-numbers">-->
        <!--        <button>1</button>-->
        <!--        <button>2</button>-->
        <!--        <button>3</button>-->
        <!--        <button>...</button>-->
        <!--        <button>8</button>-->
        <!--        <button>9</button>-->
        <!--        <button>10</button>-->
        <!--    </div>-->
        <!--    <a href="" class="pagination-btn">-->
        <!--        <span>Next</span>-->
        <!--        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">-->
        <!--            <path d="M4.16699 10.0003H15.8337M15.8337 10.0003L10.0003 4.16699M15.8337 10.0003L10.0003 15.8337" stroke="#344054" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />-->
        <!--        </svg>-->
        <!--    </a>-->
        <!--</div>-->
    </div>
</section>





<?php
get_footer();
