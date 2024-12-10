<?php
/* Template Name: Resume Builder */
get_header();
?>

<section class="contact-us-page">
    <div class="container mx-auto">

        <form class="contact-us-from" method="post" id="tech_contact_form">
            <input type="hidden" name="action" value="tech_contact_process" />
            <div class="contact-f-s-name-email-wrapper">
                <div class="contact-from-common-mb-for-email-name-sec">
                    <input type="text" id="input1" name="input1" class="contact-from-common-input" placeholder="Enter your Name" />
                    <span class="focus-border"></span>
                </div>

                <div class="contact-from-common-mb-for-email-name-sec">
                    <input type="text" id="input1" name="input1" class="contact-from-common-input" placeholder="Enter your E-mail" />
                    <span class="focus-border"></span>
                </div>
            </div>

            <div class="contact-from-common-mb">
                <input type="text" id="input1" name="input1" class="contact-from-common-input" placeholder="website" />
                <span class="focus-border"></span>
            </div>

            <div class="contact-from-common-text-aria-mb">
                <textarea type="text" id="input1" name="input1" class="contact-from-common-textarea" placeholder="Comment"></textarea>
                <span class="focus-border"></span>
            </div>

            <div class="contact-from-contact-button-wrapper">
                <button type="submit" class="contact-from-contact-button">
                    get in touch <span class="icon-arrow"></span>
                </button>
            </div>
        </form>

    </div>
</div>


<script>
    jQuery(document).ready(function ($) {
    
    /*console.log('TTP2');
    jQuery(document).ready(function($) {
        $('meta[property=og:image]').attr("content", 'sharmita');
        console.log('ok');
    });*/
	
	$(document).on('submit','#tech_contact_form', function (e) {
        e.preventDefault();
        var _data = $(this).serialize();
        $.post(Front.ajaxurl, _data, function (resp) {
            if(resp.flag == true) {
                $('.success-msg').show();
                $('.success-msg').append('<span class="smessage" style="color: green;">' + resp.msg + '</span>');
                $('#tech_contact_form').trigger("reset");
                setTimeout(function() {
                  $('span.smessage').remove();
                  $('.success-msg').hide();
                }, 6000);
            } else {
                $('.error-msg').show();
                $('.error-msg').append('<span class="emessage" style="color: red;">' + resp.msg + '</span>');
                setTimeout(function() {
                  $('span.emessage').remove();
                  $('.error-msg').hide();
                }, 6000);
            }
        }, 'json');

    });

});   
</script>


<?php
get_footer();