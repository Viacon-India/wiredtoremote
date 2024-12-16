<?php
/* Template Name: Resume Builder */
get_header();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<section class="contact-us-page">
    <div class="container mx-auto">

        <form class="contact-us-from" method="post" id="tech_contact_form">
            <input type="hidden" name="action" value="tech_contact_process" />
            <div class="contact-f-s-name-email-wrapper">
                <div class="contact-from-common-mb-for-email-name-sec">
                    <input type="text" id="name" name="name" class="contact-from-common-input" placeholder="Enter your Name" />
                    <span class="focus-border"></span>
                </div>

                <div class="contact-from-common-mb-for-email-name-sec">
                    <input type="text" id="email" name="email" class="contact-from-common-input" placeholder="Enter your E-mail" />
                    <span class="focus-border"></span>
                </div>
            </div>

            <div class="contact-from-common-mb">
                <input type="text" id="position" name="position" class="contact-from-common-input" placeholder="Current Position" />
                <span class="focus-border"></span>
            </div>

            <div class="contact-from-common-text-aria-mb">
                <textarea type="text" id="description" name="description" class="contact-from-common-textarea" placeholder="Comment"></textarea>
                <span class="focus-border"></span>
            </div>

            <input type="radio" id="design-1" name="template_design" value="design-1" checked>
            <label for="design-1">Design 1</label><br>
            <input type="radio" id="design-2" name="template_design" value="design-2">
            <label for="design-2">Design 2</label><br>
            <input type="radio" id="design-3" name="template_design" value="design-3">
            <label for="design-3">Design 3</label>

            <div class="contact-from-contact-button-wrapper">
                <button type="submit" class="contact-from-contact-button">
                    get in touch <span class="icon-arrow"></span>
                </button>
            </div>
        </form>

        <button id="download-pdf">Download as PDF</button>

    </div>

    <div id="capture">
        <div class="container mx-auto generated-resume">



            <!-- <div class="wrapper design2">
                <h2>Sharmita Shee</h2>
                <p class="designation">Manager</p>
                <div>
                    <strong>Education</strong>
                    <p>Electronics Engineering</p>
                </div>
            </div> -->

        </div>
    </div>
</div>

<style>
    .design-1 {
       background: #0000ff1f;
    }
    .design-2 {
       background: #2eff001c;
    }
    .design-3 {
       background: #ff003b17;
    }

    .wrapper {
        padding: 2rem;
        line-height: 2rem;
    }
    .generated-resume h2 {   
        font-size: 23px;
        color: green;
        font-weight: 700;
    }
    .generated-resume .designation {
        border-bottom: 1px solid #ccc;
    }
</style>


<script>
    jQuery(document).ready(function ($) {
    
    // console.log('remote');
    /*jQuery(document).ready(function($) {
        $('meta[property=og:image]').attr("content", 'sharmita');
        console.log('ok');
    });*/

    jQuery(document).ready(function ($) {
        $('#download-pdf').click(function () {

            alert('clicked');
            const { jsPDF } = window.jspdf;

            // Capture the div as a canvas using html2canvas
            html2canvas($('#capture')[0], { scale: 2 }).then(function (canvas) {
                const imgData = canvas.toDataURL('image/png'); // Convert canvas to image
                const pdf = new jsPDF('p', 'mm', 'a4'); // Create a new jsPDF instance
                const imgWidth = 100; // Width of the image in the PDF
                const pageHeight = pdf.internal.pageSize.height; // Height of the PDF page
                const imgHeight = (canvas.height * imgWidth) / canvas.width; // Scale image to fit width

                // Add the image to the PDF
                pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);

                // Save the PDF
                pdf.save('div-content.pdf');
            });
        });
    });
	
	$(document).on('change','#tech_contact_form', function (e) {
        e.preventDefault();
        var _data = $(this).serialize();
        $.post(Front.ajaxurl, _data, function (resp) {
            if(resp.flag == true) {
                $('.success-msg').show();
                $('.success-msg').append('<span class="smessage" style="color: green;">' + resp.msg + '</span>');
                // $('#tech_contact_form').trigger("reset");

                console.log(resp.data);
                $('.generated-resume').html(`
                <div class="wrapper `+resp.data.template_design+`">
                    <h2>`+resp.data.name+`</h2>
                    <p class="designation">Manager</p>
                    <div><strong>Education</strong>
                        <p>Electronics Engineering</p>
                    </div>
                </div>
                `);
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