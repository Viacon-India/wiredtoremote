<?php
/* Template Name: Rapidapi Job 1 */
get_header();

// if((time() - $_SESSION['linkedin_rapidapi_loggedtime']) > 120) {
//     $_SESSION['linkedin_rapidapi_jobs'] = '';
// 	$_SESSION['linkedin_rapidapi_loggedtime'] = '';
// }

?>
<div style="margin-top:100px;">

<?php // get location ID
/*

$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://linkedin-api8.p.rapidapi.com/search-locations?keyword=usa",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: linkedin-api8.p.rapidapi.com",
		"x-rapidapi-key: ac36d5deeemsh88bafde352c8b87p1c36bcjsn4b1a67ef1172"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	echo "cURL Error #:" . $err;
} else {
	echo "Location" .$response;
}
*/

?>

</div>
<!--<div id="linkedin" style="margin-top:50px;"></div>-->
<?php 

$linkedin_rapidapi_jobs_saved_data = $_SESSION['linkedin_rapidapi_jobs'];

if(empty($linkedin_rapidapi_jobs_saved_data) || (time() - $_SESSION['linkedin_rapidapi_loggedtime']) > 432000) { //5days

    $curl = curl_init();
    
    curl_setopt_array($curl, [
        // 	CURLOPT_URL => "https://linkedin-api8.p.rapidapi.com/search-jobs?keywords=developer&locationId=103644278&datePosted=anyTime&sort=mostRelevant",
        CURLOPT_URL => "https://linkedin-api8.p.rapidapi.com/search-jobs?datePosted=anyTime&sort=mostRelevant",
    	CURLOPT_RETURNTRANSFER => true,
    	CURLOPT_ENCODING => "",
    	CURLOPT_MAXREDIRS => 10,
    	CURLOPT_TIMEOUT => 30,
    	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    	CURLOPT_CUSTOMREQUEST => "GET",
    	CURLOPT_HTTPHEADER => [
    		"x-rapidapi-host: linkedin-api8.p.rapidapi.com",
    		"x-rapidapi-key: ac36d5deeemsh88bafde352c8b87p1c36bcjsn4b1a67ef1172"
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
    	
    	echo 'Generated:';
    	echo '<pre>';
    	print_r(json_decode($linkedin_rapidapi_jobs_json));
    	echo '</pre>';
    	
    } 
} else {
    
    // echo 'Saved data:';
    // echo '<pre>';
    // print_r(json_decode($linkedin_rapidapi_jobs_saved_data)->data);
    // echo '</pre>';
    
    $lndin_array_data = json_decode($linkedin_rapidapi_jobs_saved_data)->data;
    
?>

<section class="home-business-ideas-sec">
    <div class="container mx-auto">
        <h2 class="home-page-common-underline-title font-light">
            Linkedin <span class="font-bold">Rapidapi</span>
        </h2>
        <p>
            <?php //echo "Old time:" .$_SESSION['linkedin_rapidapi_loggedtime']; 
            //echo " New time:" .time(); ?>
        </p>
        <div class="home-business-ideas-grid-wrapper">
            
            <?php foreach($lndin_array_data as $ldata) {
            $job_link = $ldata->url;
            $company_name = $ldata->company->name; 
            $company_url = $ldata->company->url; ?>
            
                <div class="square-icon-card skew glow">
                    <figure> <img src="<?php echo $ldata->company->logo; ?>" alt="card" width="70"></figure>
                    <h2 class="square-icon-title"><?php echo $ldata->title; ?></h2>
                    <p class="square-icon-location"><b>Location:</b> <?php echo $ldata->location; ?></p>
                    <p><b>Job Link:</b> <a href="<?php echo $job_link; ?>" target="_blank"><?php echo $job_link; ?></a></p>
                    <p><b>Company Name:</b> <?php echo $company_name; ?></p>
                    <p><b>Company Page Link:</b> <a href="<?php echo $company_url; ?>" target="_blank"><?php echo $company_url; ?></a></p>
                </div>
            
            <?php } ?>
            
        </div>
    </div>
</section>

<style>
    .square-icon-card {
        height: 100% !important;
    }
    .square-icon-card p {
        z-index: 2;
    word-wrap: break-word;
    }
    .square-icon-location{
        color: #68b4ed;
    }
</style>

<?php
}

get_footer();
?>