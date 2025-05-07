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


    $(document).on("click",".settingsbtn",function(){
       $("#autho").modal("show")
      })


      // $(document).on("click",".setupauth",function(){
      //   const email = $(this).val()
      //   const button = $(this); 
      //   $.post(`../admin/activateotp/${email}`,
      //       function (response) {
      //      const result = JSON.parse(response)
      //      if (result.trim() == "Updated successfully") {
      //       showToast("Heads up!!", result, "success");
      //   } else {
      //       showToast("Heads up!!",result, "info");
      //   }
      //       });
     
      // })

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
                    <p><strong>Scan the QR code with your Authenticator app:</strong></p>
                    <img src="${result.qrUrl}" alt="QR Code" style="max-width:200px;">
                    <p>Manual Secret: <code>${result.secret}</code></p>
                    <input type="text" id="otp" placeholder="Enter code from app" />
                    <button class="btn btn-success" onclick="verifyOTP('${email}')">Verify Code</button>
                    <div id="otp-status"></div>
                `);
            } else {
                showToast("Error", result.message || "Unable to enable 2FA.", "error");
            }
        });
      });
    


  
});
