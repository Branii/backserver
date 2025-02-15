$(function(){

    function showToast(title, message, type) {
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
    }

    const request = (url,params) => {
        $(".load").removeClass("bx-check-shield").addClass("bx-loader bx-spin");
        setTimeout(function(){
            $.post(url, params, function (result) {
              console.log(result);
              $(".load").removeClass("bx-loader bx-spin").addClass("bx-check-shield");
              if(JSON.parse(result).type == 'success'){
                  window.location.href = JSON.parse(result).url
              }
              showToast("Heads up!!","Wrong email or password.","error")
              console.log(JSON.parse(result))
              console.log(result);
            });
        },1000)
    }

    $(".signin").on("click",function(evt){
        evt.preventDefault()
        let params = {email: $(".email").val().trim(),password: $(".password").val().trim()};
        let isEmpty = Object.values(params).some(param => param === "");
        !isEmpty ? request('../limvo/auth/signin',params) : showToast("Heads up!!","All fields are mandatory","info");
    })

})