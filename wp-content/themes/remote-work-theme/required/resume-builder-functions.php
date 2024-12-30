<?php
add_action('wp_ajax_tech_contact_process', 'ajax_tech_contact_process');
add_action('wp_ajax_nopriv_tech_contact_process', 'ajax_tech_contact_process');
function ajax_tech_contact_process() {
    $response_arr = ['flag' => FALSE, 'msg' => NULL, 'generated_html' => NULL];
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $position = $_POST['position'];
    $description = $_POST['description'];
    $template_design = $_POST['template_design'];

    
    if(empty($name)) {
        $response_arr['msg'] = 'Enter your name.';
    } elseif(empty($email)) {
        $response_arr['msg'] = 'Enter your email address.';
    } elseif(empty($position)) {
        $response_arr['msg'] = 'Enter Candidate position.';
    } elseif(empty($description)) {
        $response_arr['msg'] = 'Enter Candidate profile description.';
    } elseif(empty($template_design)) {
        $response_arr['msg'] = 'Select a design';
    } else {

        if($template_design == 'design-2') {
            $designed_html = '
            <div class="wrapper design-2">
                <div class="personal-deatails">
                    <h2>Sharmita Shee..</h2>
                    <p>sharmitashee@gmail.com..</p>
                </div>
                <div class="personal-deatails">
                    <h3>Profile Details</h3>
                    <p>Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo.</p>
                </div>
            </div>';

        } else if($template_design == 'design-3') {
            $designed_html = '
            <div class="wrapper design-3">
                <div class="personal-deatails">
                    <h2>Sharmita Shee......</h2>
                    <p>sharmitashee@gmail.com..</p>
                </div>
                <div class="personal-deatails">
                    <h3>Profile Details</h3>
                    <p>Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo.</p>
                </div>
            </div>';

        } else { //Design 1
            $designed_html = '
            <div class="wrapper design-1">
                <div class="personal-deatails">
                    <h2>Sharmita Shee..</h2>
                    <p>sharmitashee@gmail.com..</p>
                </div>
                <div class="personal-deatails">
                    <h3>Profile Details</h3>
                    <p>Es un hecho establecido hace demasiado tiempo que un lector se distraerá con el contenido del texto de un sitio mientras que mira su diseño. El punto de usar Lorem Ipsum es que tiene una distribución más o menos normal de las letras, al contrario de usar textos como por ejemplo "Contenido aquí, contenido aquí". Estos textos hacen parecerlo un español que se puede leer. Muchos paquetes de autoedición y editores de páginas web usan el Lorem Ipsum como su texto por defecto, y al hacer una búsqueda de "Lorem Ipsum" va a dar por resultado muchos sitios web que usan este texto si se encuentran en estado de desarrollo.</p>
                </div>
            </div>';
            
        }
        

        $response_arr['generated_html'] = $designed_html;
        
        $response_arr['msg'] = 'Check your generated resume.';
        $response_arr['flag'] = true;
    }
    
    
    echo json_encode($response_arr);
    exit;
}


add_action('wp_footer', 'add_this_script_footer');
function add_this_script_footer(){ ?>

    <script>
        function addSection(sectionId) {
            const section = document.getElementById(sectionId);
            const clone = section.cloneNode(true);
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.textContent = 'Remove';
            removeBtn.className = 'remove-btn';
            removeBtn.onclick = function() {
                clone.remove();
            };
            clone.appendChild(removeBtn);
            section.parentNode.appendChild(clone);
        }
    </script>

    <script>
    jQuery(document).ready(function ($) {

        // console.log('remote!');
        $(document).on('change','#tech_contact_form', function (e) {
            e.preventDefault();
            var _data = $(this).serialize();            

            // console.log(_data);

            $.post(Front.ajaxurl, _data, function (resp) {
                if(resp.flag == true) {
                    $('.success-msg').show();
                    $('.success-msg').append('<span class="smessage" style="color: green;">' + resp.msg + '</span>');
                    // $('#tech_contact_form').trigger("reset");

                    console.log(resp.data);
                    $('.generated-resume').html(resp.generated_html);
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
    
<?php }