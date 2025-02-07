(function($){

    $(document).ready(function(){

        $.ajax({
            type: 'POST',
            url: ajax_script.ajax_url,
            data: {
                action: 'get_data'
            },
            dataType : 'json',
            success: function (response) {
                var cities = response.cities;
               // var htmlContent = response.petition_description
                if(cities){
                    $('#city').empty();
                    $('#city').append('<option value="" selected="selected" class="gf_placeholder">Please Select Your Province</option>');
                    $.each(cities, function(index, item) {
                        $('#city').append('<option value="' + item.city_name + '">' + item.city_name + '</option>');
                    });
                }
                if(response.petition_subject){
                    $('#petition').val(response.petition_subject);
                }
                // if(htmlContent){
                //     var textContent = $(htmlContent).text();
                //     $('#petition_description').text(textContent);
                // }
            },
            error : function(errorThrown){
               console.log(errorThrown);
           }
        });

        // Form submit
        $("#enquiry-form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
          //  alert("works");
          if ($('#bcc').is(':checked') && $("#bcc_email").val() == '' || $('#ccc').is(':checked') && $("#ccc_email").val() == '') {
            Swal.fire({
                title: "BCC OR CC Email Field should be filled",
                icon: 'warning',
            })
            return false;
          }
            var form = $(this).serialize();
            $(this).find('button[type=submit]').append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
            $(this).find('button[type=submit]').prop('disabled',true);
            var thiss = $(this);
            
            $('body').waitMe({
                effect : 'bounce',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });

            $.ajax({
                type: 'post',
                url: ajax_script.ajax_url,
                data: {
                    action: 'submit_form',
                    form_data: form,
                   // signature: signature,
                },
                dataType : 'json',
                success: function (response) {
                    $('.fa.fa-spinner.fa-spin').remove();
                    $('body').waitMe('hide');
					$(thiss).find('button[type=submit]').prop('disabled',false);
                    // console.log(response);
            
                    Swal.fire({
                        title: response.message,
                        icon: response.status,
                    }).then((willDelete) => {
                        if (response.redirect_url) {window.location.href = response.redirect_url;}
                      }); 				
                },
                error : function(errorThrown){
                   console.log(errorThrown);
                   $('body').waitMe('hide');
               }
            });
        }); 

        var firstName = "firstname";
        var lastName = "lastname";
         // On change name update names in petition description
        $(document).on('change', '#firstName, #lastName', function() { 
            var set_f_Name  = $('#firstName').val();
            var set_l_Name = $('#lastName').val();
            // Get the current content of the WordPress editor
            var editorContent = tinyMCE.activeEditor.getContent();
             // Check which input triggered the change
            if ($(this).attr('id') === 'firstName') {
                // Replace the placeholder $firstname with the actual first name
                //var updatedContent = editorContent.replace(/\$firstname/g, firstName);
                var updatedContent = editorContent.replace(new RegExp(firstName, "g"), set_f_Name);
                // Set the updated content back to the WordPress editor
                tinyMCE.activeEditor.setContent(updatedContent);   
                firstName = set_f_Name;
                    
            } else if ($(this).attr('id') === 'lastName') {
                // Replace the placeholder $firstname with the actual first name
                var updatedContent = editorContent.replace(new RegExp(lastName, "g"), set_l_Name);
                // Set the updated content back to the WordPress editor
                tinyMCE.activeEditor.setContent(updatedContent);     
                lastName = set_l_Name;        
            }
        });

         // On change city
        $(document).on('change', '#city', function(e){
            var selected_city = $(this).val();
            //console.log("selected city", selected_city);
            $('body').waitMe({
                effect : 'bounce',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            $.ajax({
                type: 'POST',
                url: ajax_script.ajax_url,
                data: {
                    action: 'get_constituencies',
                    selected_city: selected_city,
                },
                dataType : 'json',
                success: function (response) {
                    $('body').waitMe('hide');
                    $('.hid').empty();
                   
                    //console.log("response", response);  
                    var constituencies  = response.constituency;
                    if(constituencies){
                        // Clear existing options
                        $('#constituency').empty();
                         // Add a placeholder option
                        $('#constituency').append('<option value="" selected="selected" class="gf_placeholder">Please Select Your Constituency</option>');

                        $.each(constituencies, function(index, item) {
                            $('#constituency').append('<option value="' + item.constituency_name + '">' + item.constituency_name + '</option>');
              
                        });
                    }
                   
              
                },
                error : function(errorThrown){
                    $('body').waitMe('hide');
                   console.log(errorThrown);
               }
            });
        });

        // On change selected_constituency
        $(document).on('change', '#constituency', function(e){
            var selected_constituency = $(this).val();
            console.log("selected_constituency", selected_constituency);
            $('body').waitMe({
                effect : 'bounce',
                text : '',
                bg : 'rgba(255,255,255,0.7)',
                color : '#000',
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });
            $.ajax({
                type: 'POST',
                url: ajax_script.ajax_url,
                data: {
                    action: 'get_td_senators',
                    selected_constituency: selected_constituency,
                },
                dataType : 'json',
                success: function (response) {
                    $('body').waitMe('hide');                   
                   // var toEmail = response.default_senators_list + ',' + response.prime_minister_email;
                   // $('#send-to').val(toEmail); // set to field with default_senators_list

                   // $('#input_4_3').val(response.default_senators_list); 
                    var senators  = response.senators;
                    if(senators.length > 0) { 
                        console.log("response", response.senators);  
                        $('.hid').empty();
                         // Add a placeholder option
                        $('.hid').append('<p class="email-note"><span>Note:</span> This email will be sent to all 60 Senators, The Minister for the Environment, Climate and Communications, Eamon Ryan, The Minister for Housing, Local Government and Heritage, Darragh O’Brien along with the following TDs.</p> <label class="list" for="inputState">List of TDS</label>');

                        $.each(senators, function(index, item) {
                            $('.hid').append('<div class="form-check"><input class="form-check-input checkbox" type="checkbox" id="' + item.tds_senators_name + '" name="tds_senators[]" value="' + item.tds_senators_email + '" >' +
                                              '<label class="form-check-label" for="'+  item.tds_senators_name  + '"> ' + item.tds_senators_name + ' ' + item.tds_senators_email + '</label></div>');
                        });
                        $(".checkbox").click();

                        // show tds senators
                        $('.hid').show();
                    }
                    else{
                          
                          $('.hid').empty();
                    }
                   
              
                },
                error : function(errorThrown){
                    $('body').waitMe('hide');
                   console.log(errorThrown);
               }
            });
        });

        $(document).on('change', '#bcc', function() { 
            if ($('#bcc').is(':checked')) {
                $('.bcc_email').show();
                var email_val  = $("#email-addr").val();
                $("#bcc_email").val(email_val);
            } else {
                $('.bcc_email').hide();
                jQuery("#bcc_email").val('');
            }
        });
    
        $(document).on('keyup', '#email-addr', function() { 
            var email_val  = $("#email-addr").val();
            $("#bcc_email").val(email_val);
        });

        $(document).on('change', '.checkbox', function() { 
            var selectedValues = jQuery('.checkbox:checked').map(function(){
                return jQuery(this).val();
            }).get().join(',');
    
            jQuery('#send-to').val(selectedValues);
        });

    });
})(jQuery);