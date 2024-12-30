<?php
/* Template Name: Test */
 get_header(); ?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->

        <div id="capture" style="WIDTH: 96%;">
            <div class="container mx-auto generated-resume">

                <div class="wrapper design-2">
                    <div class="personal-deatails">
                        <h2>Sharmita Shee</h2>
                        <p>sharmitashee@gmail.com</p>
                    </div>
                    <div class="personal-deatails">
                        <h3>Profile</h3>
                        <p>Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo.</p>
                    </div>
                    <div class="education">
                        <h3>Education</h3>
                        <div class="result-box">
                            <p><b>Rames Chandra Girls' High School</b><span>2012</span></p>
                            <p>Madhyamik</p>
                        </div>
                        <div class="result-box">
                            <p><b>Technique Plytechnic Institute</b><span>Aug 2015 - 2017</span></p>
                            <p>Diploma in Electronics and Telecommunication Engg</p>
                        </div>  
                        <div class="result-box">
                            <p><b>Modern Institute of Engineering</b><span>Aug 2019 - 2022</span></p>
                            <p>B.Tech in Electronics and Telecommunication Engg</p>
                        </div> 
                    </div>
                    <div class="experience">
                        <h3>Professional Experience</h3>
                        <div class="result-box">
                            <p><b>Sketch Web Solutions</b><span>2012</span></p>
                            <p>Junior Developer</p>
                        </div>
                        <div class="result-box">
                            <p><b>Abcd Company</b><span>Aug 2015 - 2017</span></p>
                            <p>Senior Developer</p>
                        </div>  
                        <div class="result-box">
                            <p><b>Viacon</b><span>Aug 2019 - 2022</span></p>
                            <p>Lead Developer</p>
                        </div> 
                    </div>
                </div>

            </div>
        </div>
        <div class="container mx-auto">
            <button id="download-pdf">Download as PDF</button>
        </div>
        

        <script>
            jQuery(document).ready(function ($) {
                $('#download-pdf').click(function () {
                    alert('ok');
                    const { jsPDF } = window.jspdf;

                    // Capture the div as a canvas using html2canvas
                    html2canvas($('#capture')[0], { scale: 2 }).then(function (canvas) {
                        const imgData = canvas.toDataURL('image/png'); // Convert canvas to image
                        const pdf = new jsPDF('p', 'mm', 'a4'); // Create a new jsPDF instance
                        const imgWidth = 180; // Width of the image in the PDF
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
        /* line-height: 2rem; */
    }
    .personal-deatails p {
        font-size: 20px;
    }
    .generated-resume h2 {   
        font-size: 42px;
        color: green;
        font-weight: 700;
    }
    .generated-resume .designation {
        border-bottom: 1px solid #ccc;
    }
    .result-box { margin-bottom: 1rem; }
    .result-box span {
        float: right;
    }
    .generated-resume h3 {
        font-size: 22px;
        text-transform: uppercase;
        font-weight: 900;
        border-bottom: 1px solid #000;
        margin: 1.4rem 0;
    }
    .generated-resume p {
        font-size: 18px;
        line-height: 1.62rem;
    }

    .form-section {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
    }
    .form-section h4 {
        margin-top: 0;
    }
    .add-btn, .remove-btn {
        margin-top: 10px;
    }
</style>
   
<?php
get_footer();