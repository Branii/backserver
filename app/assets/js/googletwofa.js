$(function () {
  function showToast(title, message, type) {
    $.toast({
      position: "bottom-right",
      title: title,
      message: message,
      type: type,
      duration: 3000 // auto-dismiss after 3s
    });
  }

  $(document).on("click", ".settingsbtn", function () {
    $("#autho").modal("show");
  });

  //password settings form
  $(".changepasswordbtn").click(function () {
    $("#autho").modal("hide");
    $("#authopassword").modal("show");
  });

  //updatepassword

  $(document).on("click", ".changepassword", function (e) {
    e.preventDefault(); // Prevent default form submission

    const email = $("#adminEmail").val();
    const currentPassword = $("#currentPassword").val();
    const repeatPassword = $("#repeatPassword").val();

    // console.log("Email:", email);
    // console.log("Current Password:", currentPassword);
    // console.log("Repeat Password:", repeatPassword);

    if (currentPassword !== repeatPassword) {
      showToast("Error!", "Passwords do not match!", "error");
      return;
    }

    // Send POST request with email and password in URL (no postData)
    $.post(
      `../admin/changerAdminpassword/${email}/${repeatPassword}`,
      function (response) {
        const result = JSON.parse(response);

    $(document).on("click",".settingsbtn",function(){
       $("#autho").modal("show")
    })

    $(document).on("click", ".setupauth", function () {
    const email = $(this).val(); // Button value should be user's email
    const button = $(this);
    $.post(`../admin/activateotp/${email}`, function (response) {
        const result = JSON.parse(response);
        console.log(result)

        if (result.status === "success") {
            showToast("2FA Setup", "Scan the QR code to complete setup.", "success");
            $("#autho").modal("hide")
            $("#authot").modal("show")
            // Dynamically display the QR code and secret
            $("#qr-container").html(`
                <p>Scan the QR code using Google Authenticator</p>
                <img src="${result.qrUrl}" alt="QR Code" style="max-width:200px;">
                <div id="otp-inputs" class="otp-input-container">
                    <input type="text" maxlength="1" class="otp-box" />
                    <input type="text" maxlength="1" class="otp-box" />
                    <input type="text" maxlength="1" class="otp-box" />
                    <input type="text" maxlength="1" class="otp-box" />
                    <input type="text" maxlength="1" class="otp-box" />
                    <input type="text" maxlength="1" class="otp-box" />
                </div>
                <button class="btn btn-success verify-otp-btn">
                <span class="" role="status" aria-hidden="true"></span>
                <span class="btn-text">Verify Code</span>
                </button>
                <div id="otp-status"></div>
            `);
            
        } else {
            showToast("Error", result.message || "Unable to enable 2FA.", "error");
        }
    });
    });

    $(document).on('input', '.otp-box', function () {
    const $input = $(this);
    const value = $input.val();
    // Remove non-digit characters
    const digit = value.replace(/\D/g, '');
    $input.val(digit); // Set only digit
    if (digit.length === 1) {
        $input.next('.otp-box').focus();
    }
    });

    $(document).on('keydown', '.otp-box', function (e) {
        if (e.key === "Backspace" && $(this).val() === "") {
            $(this).prev('.otp-box').focus();
        }
    });
        
    $(document).on('click', '.verify-otp-btn', function () {
        const otpcode = $('.otp-box').map(function () {
            return $(this).val();
        }).get().join('');
       
        if (!otpcode) {
            $("#otp-status").html("<p style='color:red;'>Please enter the OTP code.</p>");
            return;
         }
        $(".spinner-border-sm").show()
      
            $.post(`../admin/verifyotp/${otpcode}`, function (response) {
                const result = JSON.parse(response);
            if (result) {
                showToast("2FA Verified", "Your two-factor authentication has been successfully verified.", "success");
                $("#authot").modal("hide");
            } else {
                $("#otp-status").html(`<p style='color:red;'>${result.message || "Invalid OTP code."}</p>`);
            }
        });
        
    });

    $(".otpstatus").hide()

    $(document).on('click', '.verifybtn', function () {
        const optcode = $('.otp-box').map(function () {
            return $(this).val();
        }).get().join('');
    
        if (!optcode) {
            $(".otpstatus").show()
            $(".otpstatus").html("<p style='color:red;'>Please enter the OTP code.</p>");
            return;
        }
        $('.bx-loader-circle').show();
        $.post(`../admin/verifyloginotp/${optcode}`, function (response) {
                const result = JSON.parse(response);
                // $spinner.addClass('d-none');
                // $btn.prop('disabled', false); // Re-enable button
            if (result.status === "success") {
                window.location.href = result.url
            } else {
                $(".otpstatus").html(`<p style='color:red;'>${result.status}</p>`);
                setTimeout(function() {
                    $('.bx-loader-circle').hide();
                }, 300); 
            
            }
        });
        
    });

});
