<?php /* Template Name: Enquiry Form */ ?> 
<?php get_header() ?> 
<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
		<div class="headingtopp">
			<h2>
			Planning Bill Campaign Email	
			</h2>
		</div>
        <div class="container main-content2">
            <div class="row1 wpb_row vc_row-fluid vc_row full-width-section vc_row-o-equal-height vc_row-flex vc_row-o-content-middle">
                <form id="enquiry-form">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">First Name *</label>
                            <input type="text" class="form-control" id="firstName" name="firstname" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputName">Last Name *</label>
                            <input type="text" class="form-control" id="lastName" name="lastname" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputName">Phone Number *</label>
                            <input type="number" class="form-control" id="PhoneNumber" name="PhoneNumber" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputName">EIR Code *</label>
                            <input type="text" class="form-control" id="EIRCode" name="EIRCode" required>
                        </div>
                    </div>
                    <div class="form-group tet">
                        <div class="form-group col-md-6">
                            <label for="city">Province *</label>
                            <select id="city" class="form-control" name="City">
                                <option selected>Please Select Your Province</option>
                               
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="constituency">Constituency *</label>
                            <select id="constituency" class="form-control" name="Constituency">
                                <option selected>Please Select Your Constituency</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="form-group hid">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputsent">Sent To *</label>
                            <input type="text" class="form-control" id="send-to" placeholder="To" name="send_email_to">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputemail">Email Address *</label>
                            <input type="email" class="form-control" id="email-addr" placeholder="Enter Your Email Address" name="from_email">
                            <div class="chk">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="bcc" name="bcc" checked>
                                    <label class="form-check-label" for="bcc"> BCC </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ccc" name="ccc">
                                    <label class="form-check-label" for="ccc"> CC </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- hidden fields -->
                    <div class="form-group col-md-12 ccc_email">
                        <label for="inputccc">CC</label>
                        <input type="text" class="form-control" id="ccc_email" name="inputccc">
                    </div>
                    <div class="form-group col-md-12 bcc_email" style="display: block;">
                        <label for="inputbcc">BCC</label>
                        <input type="text" class="form-control" id="bcc_email" name="inputbcc">
                    </div>
                    <!-- end -->
                    <div class="form-group col-md-12">
                        <label for="inputName">Subject *</label>
                        <input type="text" class="form-control" id="petition" placeholder="Petition" name="petition" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="inputName">Email Text *</label>
                        <!-- <textarea class="form-control" id="petition_description" rows="3" name="petition_description" required></textarea> -->
                        <?php
                            $petition_description = get_field('petition_description', 'option');
                            
                            // Use wp_editor to display a rich text editor
                            wp_editor($petition_description , 'petition_description', array(
                              'textarea_name' => 'petition_description',
                              'textarea_rows' => 30, // Adjust as needed
                              'teeny'         => true, // Use the "teeny" mode for a simplified toolbar
                              'media_buttons' => false, // Disable media buttons if not needed
                              'tinymce'       => array(
                                  'resize'            => true,
                                  'wp_autoresize_on' => true,
                              ),
                            ));

                          ?>
                    </div>
                    <!-- <div class="awsm-job-form-group" data-orginal-font-size="16" data-orginal-line-height="26" data-orginal-letter-spacing="0" style="font-size: 16px;">
                        <label for="awsm-cover-letter" data-orginal-font-size="16" data-orginal-line-height="26" data-orginal-letter-spacing="0" style="font-size: 16px;">Signature<span class="awsm-job-form-error" data-orginal-font-size="16" data-orginal-line-height="26" data-orginal-letter-spacing="0" style="font-size: 16px;">*</span>
                            <i class="fa fa-check sig_check" aria-hidden="true" style="color: #11d611; font-size: 20px; float: right; display:none"></i>
                        </label>
                        <canvas id="sig-canvas" width="450" height="160" style="border: 2px dotted #CCCCCC; border-radius: 15px; cursor: crosshair;"> Get a better browser, bro. </canvas>
                        <div class="col-md-12 btn">
                            <button style="cursor: pointer" type='button' class="btn" id="sig-submitBtn">Submit Signature</button>
                            <button style="cursor: pointer" type='button' class="btn" id="sig-clearBtn">Clear Signature</button>
                            <input type="hidden" id="sig-dataUrl" name="signature" value="">
                        </div>
                    </div> -->
                    <button type="submit" class="btn btn-primary submit">Submit</button>
                </form>
            </div>
        </div>
    </body>
</html> 
<?php get_footer() ?>

<script>
    window.requestAnimFrame = (function(callback) {
        return window.requestAnimationFrame ||
          window.webkitRequestAnimationFrame ||
          window.mozRequestAnimationFrame ||
          window.oRequestAnimationFrame ||
          window.msRequestAnimaitonFrame ||
          function(callback) {
            window.setTimeout(callback, 1000 / 60);
          };
      })();

      this.canvas = document.getElementById("sig-canvas");
    if(this.canvas){ 
      // this.canvas = document.getElementById("sig-canvas1");
      var ctx = this.canvas.getContext("2d");
      ctx.strokeStyle = "#222222";
      ctx.lineWidth = 4;

      var drawing = false;
      var mousePos = {
        x: 0,
        y: 0
      };
      var lastPos = mousePos;

      this.canvas.addEventListener("mousedown", function(e) {
        drawing = true;
        lastPos = getMousePos(canvas, e);
      }, false);

      this.canvas.addEventListener("mouseup", function(e) {
        drawing = false;
      }, false);

      this.canvas.addEventListener("mousemove", function(e) {
        mousePos = getMousePos(canvas, e);
      }, false);

      // Add touch event support for mobile
      this.canvas.addEventListener("touchstart", function(e) {

      }, false);

      this.canvas.addEventListener("touchmove", function(e) {
        var touch = e.touches[0];
        var me = new MouseEvent("mousemove", {
          clientX: touch.clientX,
          clientY: touch.clientY
        });
        canvas.dispatchEvent(me);
      }, false);

      this.canvas.addEventListener("touchstart", function(e) {
        mousePos = getTouchPos(canvas, e);
        var touch = e.touches[0];
        var me = new MouseEvent("mousedown", {
          clientX: touch.clientX,
          clientY: touch.clientY
        });
        canvas.dispatchEvent(me);
      }, false);

      this.canvas.addEventListener("touchend", function(e) {
        var me = new MouseEvent("mouseup", {});
        canvas.dispatchEvent(me);
      }, false);

      function getMousePos(canvasDom, mouseEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
          x: mouseEvent.clientX - rect.left,
          y: mouseEvent.clientY - rect.top
        }
      }

      function getTouchPos(canvasDom, touchEvent) {
        var rect = canvasDom.getBoundingClientRect();
        return {
          x: touchEvent.touches[0].clientX - rect.left,
          y: touchEvent.touches[0].clientY - rect.top
        }
      }

      function renderCanvas() {
        // console.log("Rendering canvas");

        if (drawing) {
          // console.log("Drawing in progress");

          ctx.moveTo(lastPos.x, lastPos.y);
          ctx.lineTo(mousePos.x, mousePos.y);
          ctx.stroke();
          lastPos = mousePos;
        }
      }

      // Prevent scrolling when touching the canvas
      document.body.addEventListener("touchstart", function(e) {
        if (e.target == this.canvas) {
          e.preventDefault();
        }
      }, false);
      document.body.addEventListener("touchend", function(e) {
        if (e.target == this.canvas) {
          e.preventDefault();
        }
      }, false);
      document.body.addEventListener("touchmove", function(e) {
        if (e.target == this.canvas) {
          e.preventDefault();
        }
      }, false);

      (function drawLoop() {
        
        requestAnimFrame(drawLoop);
        renderCanvas();
      })();

      function clearCanvas() {
        this.canvas.width = this.canvas.width;
      }

      // Set up the UI
      var sigText = document.getElementById("sig-dataUrl");
      //var sigImage = document.getElementById("sig-image");
      var clearBtn = document.getElementById("sig-clearBtn");
      var submitBtn = document.getElementById("sig-submitBtn");
      clearBtn.addEventListener("click", function(e) {
        clearCanvas();
        jQuery('.sig_check').hide();
        //sigText.innerHTML = "Data URL for your signature will go here!";
        //sigImage.setAttribute("src", "");
      }, false);
      submitBtn.addEventListener("click", function(e) {
        var dataUrl = canvas.toDataURL();
        console.log("dataUrl",dataUrl);
        sigText.value = dataUrl;
        if(dataUrl){jQuery('.sig_check').show();}	
        //sigImage.setAttribute("src", dataUrl);
      }, false);

      
    }
</script>