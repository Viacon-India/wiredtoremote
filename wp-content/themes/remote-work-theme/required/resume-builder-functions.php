<?php
add_action('wp_ajax_tech_contact_process', 'ajax_tech_contact_process');
add_action('wp_ajax_nopriv_tech_contact_process', 'ajax_tech_contact_process');
function ajax_tech_contact_process() {
    $response_arr = ['flag' => FALSE, 'msg' => NULL, 'data' => NULL];
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $description = $_POST['description'];
    
    // if(empty($candidate_name)) {
    //     $response_arr['msg'] = 'Enter your name.';
    // } elseif(empty($candidate_email)) {
    //     $response_arr['msg'] = 'Enter your email address.';
    // } elseif(empty($position)) {
    //     $response_arr['msg'] = 'Enter Candidate position.';
    // } elseif(empty($description)) {
    //     $response_arr['msg'] = 'Enter Candidate message.';
    // } elseif(empty($template_design)) {
    //     $response_arr['msg'] = 'Select Design';
    // } else {
        
        // $to = 'mashum.webmaster@gmail.com';
        // $to = 'viacon.sharmita@gmail.com';
        // $body = '<table class="mail-table" style="border: 1px solid #0a9e01; padding:20px; width: 100%;">
        //             <h4 style="border-bottom: 2px solid #ccc; padding-bottom: 10px; width: 50%;">This e-mail was sent from a contact form on Techtrendspro.</h4>
        //             <tr>
        //                 <td>Name: ' .$user_name .'</td>
        //             </tr>
        //             <tr>
        //                 <td>Email: '. $user_email .'</td>
        //             </tr>
        //             <tr>
        //                 <td>Subject: ' . $subject. '</td>
        //             </tr>
        //             <tr>
        //                 <td>Message: ' . $u_mnessage .'</td>
        //             </tr>
        //         </table>';
        // $headers = array('Content-Type: text/html; charset=UTF-8', 'Reply-To: ' .$user_name .' <' . $user_email. '>');
        // wp_mail( $to, 'Tech Trends Pro Conatct Form' , $body, $headers );

        $response_arr['data'] = $_POST;
        
        $response_arr['msg'] = 'Thank you for your message. It has been sent.';
        $response_arr['flag'] = true;
    // }
    
    
    echo json_encode($response_arr);
    exit;
}