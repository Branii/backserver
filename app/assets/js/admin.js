$(function(){

    function showToast(title,message,type){
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
    }

    const request = (url,params) => {
        $.post(url,params,function(result){

           let data = JSON.parse(result)
            if(JSON.parse(result).type == 'success'){
                window.location.href = JSON.parse(result).url
            }else{
                showToast("Heads up!!","Wrong email or password.","error")
            }
        
        })
    }

    $(".signin").on("click",function(evt){
        evt.preventDefault()
        let params = {email: $(".email").val().trim(),password: $(".password").val().trim()};
        let isEmpty = Object.values(params).some(param => param === "");
        !isEmpty ? request('admin/signin',params) : showToast("Heads up!!","All fields are mandatory","info");
    })

})