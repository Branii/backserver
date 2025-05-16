$(function () {
    function showToast(title, message, type) {
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
    }

    $(document).on("click", ".settingsbtn", function () {
        const email = $(this).val(); // assuming button value contains user's email
      // console.log(email)
         $("#autho").modal("show");
        // $.post(`../admin/checkotpstatus`, function (response) {
        //   //  const result = JSON.parse(response);
        //     console.log(response)
        //     return
        //     if (result.status === "enabled") {
        //         // Show modal with "Disable 2FA" option
        //         $("#autho").modal("show");
        //         $("#setupauth-button").text("Disable 2FA").removeClass("btn-primary").addClass("btn-danger").data("action", "disable");
        //     } else {
        //         // Show modal with "Enable 2FA" option
        //         $("#autho").modal("show");
        //         $("#setupauth-button").text("Enable 2FA").removeClass("btn-danger").addClass("btn-primary").data("action", "enable");
        //     }
        // });
    });

    // $(document).on("click",".settingsbtn",function(){
    //    $("#autho").modal("show")
    // })

    $(document).on("click", ".setupauth", function () {
    const email = $(this).val(); // Button value should be user's email
    $.post(`../admin/activateotp/${email}`, function (response) {
         const result = JSON.parse(response);
       
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
                    <i class='bx bx-loader-circle bx-spin bx-rotate-90 verifyme' style='color:#0c0c0c;display:none;'></i>
                    Verify Code
                </button>
                <div id="otp-status"></div>
            `);
            
        } else {
            showToast( "Unable to enable 2FA.", "error");
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

         $(".verifyme").show()
            $.post(`../admin/verifyotp/${otpcode}`, function (response) {
                const result = JSON.parse(response);
            if (result ==="success") {
                showToast("2FA Verified", "Your two-factor authentication has been successfully verified.", "success");
                $("#authot").modal("hide");
            } else {
                $("#otp-status").html(`<p style='color:red;'> Invalid OTP code entered</p>`);
                 $(".verifyme").hide()
            }
        });
        
    });

    $(".otpstatus").hide()

    //mobile......
    $(document).on("click", ".setupmobile", function () {
       const email = $(this).val(); // Button value should be user's email
      $.post(`../admin/activateotpmobile/${email}`, function (response) {
            const result = JSON.parse(response);
            if (result.status === "success") {
                showToast("2FA Setup successfully",  "success");
                $("#autho").modal("hide")
            } else {
                showToast( "Unable to enable 2FA.", "error");
            }
        });
    });

    //reset
      $(document).on("click", ".resetauth", function () {
      $.post(`../admin/resetauth`, function (response) {
            const result = JSON.parse(response);
            if (result.status === "success") {
                showToast("2FA Disabled", "successfully", "success");
                  $("#autho").modal("hide")
            } else {
                showToast( "Unable to enable 2FA.", "error");
            }
        });
    })
    

});
