<?php
/* Template Name: Test */
get_header(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

        <div id="capture">
            <h2>Hello, World!</h2>
            <p>This is the content of the div that will be saved as a PDF.</p>
        </div>
        <button id="download-pdf">Download as PDF</button>

        <script>
            jQuery(document).ready(function ($) {
                $('#download-pdf').click(function () {
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
        </script>

        <style>
            #capture {
                padding: 20px; border: 1px solid black; width: 300px; background-color: #f9f9f9;
            }
            h2 {
                color: green;
            }
            
        </style>
   
<?php
get_footer();