<?php
/* Template Name: Resume Builder */
get_header();
?>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->

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
        font-size: 14px;
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

<section class="contact-us-page">
    <div class="container mx-auto">

        <div class="author-page-breadcrumbs-wrappers">
            <ul class="breadcrumbs">
                <li class="bread-list"><a href="<?php echo home_url(); ?>">Home</a></li>
                <li class="bread-list"><?php echo strip_tags(get_the_title()); ?></li>
            </ul>
        </div>
        <div class="contact-us-page-inner">
            <div class="contact-us-content-sec">
                <h2 class="contact-us-page-underline-title"><?php echo strip_tags(get_the_title()); ?></h2>
                <div class="contact-us-page-dsc-wrapper">                    
                

                    <form class="contact-us-from" method="post" id="tech_contact_form">
                        <input type="hidden" name="action" value="tech_contact_process" />

                        <h3><strong>Select One Design to view the result</strong></h3>

                        <input type="radio" id="design-1" name="template_design" value="design-1" selected>
                        <label for="design-1">Design 1</label><br>
                        <input type="radio" id="design-2" name="template_design" value="design-2">
                        <label for="design-2">Design 2</label><br>
                        <input type="radio" id="design-3" name="template_design" value="design-3">
                        <label for="design-3">Design 3</label>

                        <div class="contact-f-s-name-email-wrapper">
                            <div class="contact-from-common-mb-for-email-name-sec">
                                <input type="text" id="name" name="name" class="contact-from-common-input" placeholder="Enter your Name" />
                                <span class="focus-border"></span>
                            </div>

                            <div class="contact-from-common-mb-for-email-name-sec">
                                <input type="email" id="email" name="email" class="contact-from-common-input" placeholder="Enter your E-mail" />
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

                        <!-- Education -->            
                        <div class="contact-from-common-mb">
                            <h4 class="contact-from-common-mb"><strong>Education</strong></h4>
                            <div id="education" class="form-section">                    
                                <div class="contact-from-common-mb">
                                    <input class="contact-from-common-input" type="text" name="institute_name[]" placeholder="Enter Institute Name">
                                </div>
                                <div class="contact-from-common-mb">
                                    <input class="contact-from-common-input" type="text" name="institute_joining_date[]" placeholder="Enter Joining Date">
                                </div>
                                <div class="contact-from-common-mb">
                                    <input class="contact-from-common-input" type="text" name="institute_leaving_date[]" placeholder="Enter Leaving Date">
                                </div>
                            </div>
                            <button type="button" class="add-btn contact-from-common-mb" onclick="addSection('education')">Education + </button>
                        </div>

                    
                        <!-- Experience -->            
                        <div class="contact-from-common-mb">
                            <h4 class="contact-from-common-mb"><strong>Experience</strong></h4>
                            <div id="experience" class="form-section">                    
                                <div class="contact-from-common-mb">
                                    <input class="contact-from-common-input" type="text" name="company_name[]" placeholder="Enter Company Name">
                                </div>
                                <div class="contact-from-common-mb">
                                    <input class="contact-from-common-input" type="text" name="company_joining_date[]" placeholder="Enter Joining Date">
                                </div>
                                <div class="contact-from-common-mb">
                                    <input class="contact-from-common-input" type="text" name="company_leaving_date[]" placeholder="Enter Leaving Date">
                                </div>
                            </div>
                            <button type="button" class="add-btn contact-from-common-mb" onclick="addSection('experience')">Experience +</button>
                        </div>
                        
                    </form>

                    <div class="error-msg"></div>
                    <div class="success-ms"></div>

                </div>
            </div>
        </div>

    </div>
    

    <div id="capture">
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

</section>


<?php
get_footer();