<?php /*Template Name: Generate Url */ ?>
<?php if(is_user_logged_in() && current_user_can('customer')) { ?>
<?php
    $user = wp_get_current_user();
    $currencies = [
        'AFN' => 'Afghan Afghani',
        'ALL' => 'Albanian Lek',
        'DZD' => 'Algerian Dinar',
        'AOA' => 'Angolan Kwanza',
        'ARS' => 'Argentine Peso',
        'AMD' => 'Armenian Dram',
        'AWG' => 'Aruban Florin',
        'AUD' => 'Australian Dollar',
        'AZN' => 'Azerbaijani Manat',
        'BSD' => 'Bahamian Dollar',
        'BDT' => 'Bangladeshi Taka',
        'BBD' => 'Barbadian Dollar',
        'BZD' => 'Belize Dollar',
        'BMD' => 'Bermudian Dollar',
        'BOB' => 'Bolivian Boliviano',
        'BAM' => 'Bosnia & Herzegovina Convertible Mark',
        'BWP' => 'Botswana Pula',
        'BRL' => 'Brazilian Real',
        'GBP' => 'British Pound',
        'BND' => 'Brunei Dollar',
        'BGN' => 'Bulgarian Lev',
        'BIF' => 'Burundian Franc',
        'KHR' => 'Cambodian Riel',
        'CAD' => 'Canadian Dollar',
        'CVE' => 'Cape Verdean Escudo',
        'KYD' => 'Cayman Islands Dollar',
        'XAF' => 'Central African Cfa Franc',
        'XPF' => 'Cfp Franc',
        'CLP' => 'Chilean Peso',
        'CNY' => 'Chinese Renminbi Yuan',
        'COP' => 'Colombian Peso',
        'KMF' => 'Comorian Franc',
        'CDF' => 'Congolese Franc',
        'CRC' => 'Costa Rican Colón',
        'HRK' => 'Croatian Kuna',
        'CZK' => 'Czech Koruna',
        'DKK' => 'Danish Krone',
        'DJF' => 'Djiboutian Franc',
        'DOP' => 'Dominican Peso',
        'XCD' => 'East Caribbean Dollar',
        'EGP' => 'Egyptian Pound',
        'ETB' => 'Ethiopian Birr',
        'EUR' => 'Euro',
        'FKP' => 'Falkland Islands Pound',
        'FJD' => 'Fijian Dollar',
        'GMD' => 'Gambian Dalasi',
        'GEL' => 'Georgian Lari',
        'GIP' => 'Gibraltar Pound',
        'GTQ' => 'Guatemalan Quetzal',
        'GNF' => 'Guinean Franc',
        'GYD' => 'Guyanese Dollar',
        'HTG' => 'Haitian Gourde',
        'HNL' => 'Honduran Lempira',
        'HKD' => 'Hong Kong Dollar',
        'HUF' => 'Hungarian Forint',
        'ISK' => 'Icelandic Króna',
        'INR' => 'Indian Rupee',
        'IDR' => 'Indonesian Rupiah',
        'ILS' => 'Israeli New Sheqel',
        'JMD' => 'Jamaican Dollar',
        'JPY' => 'Japanese Yen',
        'KZT' => 'Kazakhstani Tenge',
        'KES' => 'Kenyan Shilling',
        'KGS' => 'Kyrgyzstani Som',
        'LAK' => 'Lao Kip',
        'LBP' => 'Lebanese Pound',
        'LSL' => 'Lesotho Loti',
        'LRD' => 'Liberian Dollar',
        'MOP' => 'Macanese Pataca',
        'MKD' => 'Macedonian Denar',
        'MGA' => 'Malagasy Ariary',
        'MWK' => 'Malawian Kwacha',
        'MYR' => 'Malaysian Ringgit',
        'MVR' => 'Maldivian Rufiyaa',
        'MRO' => 'Mauritanian Ouguiya',
        'MUR' => 'Mauritian Rupee',
        'MXN' => 'Mexican Peso',
        'MDL' => 'Moldovan Leu',
        'MNT' => 'Mongolian Tögrög',
        'MAD' => 'Moroccan Dirham',
        'MZN' => 'Mozambican Metical',
        'MMK' => 'Myanmar Kyat',
        'NAD' => 'Namibian Dollar',
        'NPR' => 'Nepalese Rupee',
        'ANG' => 'Netherlands Antillean Gulden',
        'TWD' => 'New Taiwan Dollar',
        'NZD' => 'New Zealand Dollar',
        'NIO' => 'Nicaraguan Córdoba',
        'NGN' => 'Nigerian Naira',
        'NOK' => 'Norwegian Krone',
        'PKR' => 'Pakistani Rupee',
        'PAB' => 'Panamanian Balboa',
        'PGK' => 'Papua New Guinean Kina',
        'PYG' => 'Paraguayan Guaraní',
        'PEN' => 'Peruvian Nuevo Sol',
        'PHP' => 'Philippine Peso',
        'PLN' => 'Polish Złoty',
        'QAR' => 'Qatari Riyal',
        'RON' => 'Romanian Leu',
        'RUB' => 'Russian Ruble',
        'RWF' => 'Rwandan Franc',
        'STD' => 'São Tomé and Príncipe Dobra',
        'SHP' => 'Saint Helenian Pound',
        'SVC' => 'Salvadoran Colón',
        'WST' => 'Samoan Tala',
        'SAR' => 'Saudi Riyal',
        'RSD' => 'Serbian Dinar',
        'SCR' => 'Seychellois Rupee',
        'SLL' => 'Sierra Leonean Leone',
        'SGD' => 'Singapore Dollar',
        'SBD' => 'Solomon Islands Dollar',
        'SOS' => 'Somali Shilling',
        'ZAR' => 'South African Rand',
        'KRW' => 'South Korean Won',
        'LKR' => 'Sri Lankan Rupee',
        'SRD' => 'Surinamese Dollar',
        'SZL' => 'Swazi Lilangeni',
        'SEK' => 'Swedish Krona',
        'CHF' => 'Swiss Franc',
        'TJS' => 'Tajikistani Somoni',
        'TZS' => 'Tanzanian Shilling',
        'THB' => 'Thai Baht',
        'TOP' => 'Tongan Paʻanga',
        'TTD' => 'Trinidad and Tobago Dollar',
        'TRY' => 'Turkish Lira',
        'UGX' => 'Ugandan Shilling',
        'UAH' => 'Ukrainian Hryvnia',
        'AED' => 'United Arab Emirates Dirham',
        'USD' => 'United States Dollar',
        'UYU' => 'Uruguayan Peso',
        'UZS' => 'Uzbekistani Som',
        'VUV' => 'Vanuatu Vatu',
        'VND' => 'Vietnamese Đồng',
        'XOF' => 'West African Cfa Franc',
        'YER' => 'Yemeni Rial',
        'ZMW' => 'Zambian Kwacha'
    ];
?>
  
<style>
    .transfer-link {
        display: flex;
        justify-content: center;
    }
    p.desc {
        font-size: 12px;
    }
    button.upload-again, button.copy-link {
     
        background: #7D7;
        color: #F9FAFB;
        font-size: 14px;
        font-weight: 600;
        padding: 10px 20px;
        border: 0;
        gap: 5px;
        cursor: pointer;
        margin: 0px 0px 0px 10px;
        width: 154px;
    }
    div#card-element {
        background: #e9e9e9;
        padding: 20px;
        margin-bottom: 20px;
    }
    button.submit_btn {
        width: 100%;
    }
    .per_day {
        display: flex;
        align-items: center;
    }
    input.price_input {
        width: 88%;
    }
    .para {
        margin-left: 8px;
    }

</style>
    <form id="upload" enctype="multipart/form-data">
        <div class="col-12">
            <div class="form_group mb-4">
                <label for="" class="gen_label">Desired URL</label>
                <p class="desc">www.thingsandinfo.com/.../DESIRED_URL_NAME</p>
                <input type="text" name= "title" placeholder="Enter Desired URL" class="gen_input"  required>
            </div>

            <div class="form_group mb-4">
                <label for="" class="gen_label">Select Folder</label>
                <select name="folders">
                    <option value="" selected hidden disabled>Select Folder</option>
                    <?php foreach (get_posts(['post_type' => 'folders', 'numberposts' => -1,  'author' => $user->ID,]) as $post): ?>
                        <?php if ($post->ID != 137): ?>
                        <option value="<?php echo esc_attr($post->ID); ?>"><?php echo esc_html($post->post_title); ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>

            </div>

            <div class="form_group mb-4">
                <label for="" class="gen_label">Desciption</label>
                <textarea name= "desciption" class="gen_input"></textarea>
            </div>

            <div class="form_group mb-4">
                <label for="" class="gen_label">Select File</label>
                <input type="file" name= "upload_file"  class="gen_input"  required>
            </div>
         

            <div class="form_group mb-4">
                <label for="" class="gen_label">How many days do you want it online?</label>
                <div class="per_day">
                    <input type="number" min="1" value="1" name= "expiration_days"  class="gen_input price_input"  required>
                    <p class="para">$<span class="price_per_day">0.50 </span>/day</p>      
                    <!-- <p class="para"><span class="price_per_day">$0.50 </span><span class="currency_symbol">USD</span>/day</p>       -->
                </div>
            </div>

            <div class="form_group mb-4">
                <label for="" class="gen_label">Enter Your Card Details</label>
                <div id="card-element"></div> 
            </div>

        </div>
        <div class="col-6">
            <div class="form_group mt-4">
                <button type ="submit" class="submit_btn">Get Link</button>
            </div>
        </div>
        <input type="hidden" name="action" value="get_link" />

    </form>
<?php } else { wp_redirect('/my-account');
}  ?>
 <script>
(function($){ 
    $(document).ready(function(){      
        // stripe 
        // console.log(stripe_private_key.key_url);
        var stripe = Stripe(stripe_private_key.key_url);
   
		var elements = stripe.elements();
		var cardElement =  elements.create('card', {
            hidePostalCode: true,
        });
		cardElement.mount('#card-element');

        jQuery(document).on('change', '#currencyDropdown', function () {
            jQuery('.currency_symbol').text(jQuery(this).val());
        });

        $('#upload').submit(function(e) {
			e.preventDefault();

			// Collect form data
			var form = new FormData(this);
			$('body').waitMe({
				effect : 'facebook',
				text : '',
				bg : 'rgba(255,255,255,0.7)',
				color : '#000',
				maxSize : '',
				waitTime : -1,
				textPos : 'vertical',
				fontSize : '',
				source : '',
			});

            stripe.createToken(cardElement).then(function(result) {
                if (result.error) {
                    // Handle error
                    Swal.fire({
                        title: 'Error',
                        text: result.error.message,
                        icon: "error",
                    })
                    $('body').waitMe('hide');
                    return false;
                } else {
                    // Attach the token or source to the form data
                    form.append('stripeToken', result.token.id);
                   	// Make the API call
                    $.ajax({
                        type: 'post',
                        url: '<?= admin_url( 'admin-ajax.php' ); ?>',
                        data: form,
                        dataType : 'json',
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function(response) {	
                            $('body').waitMe('hide');
                            Swal.fire({
                                title: response.icon,
                                text: response.message,
                                icon: response.icon,
                            })
                            // Handle the API response
                            console.log(response.url);
                            if(response.status){
                                $('#upload')[0].reset();
                                $('#upload').after('<div class="transfer-link"><input class="transfer-link__url" readonly="" value="'+response.url+'"><button class="copy-link">Copy Link</button></div>');
                                $('#upload').hide();
                            }
                        },
                        error: function(error) {
                            $('body').waitMe('hide');
                        
                            // Handle the API error
                            console.error(error);
                        }
                    });
                }
            }); 
		});

        $(document).on('change', '.price_input', function() {
            var day = $(this).val();
            $('.price_per_day').text(day*0.50);
        })
    });
})(jQuery);
</script>
