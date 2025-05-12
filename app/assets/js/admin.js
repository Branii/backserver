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

    const translator = JSON.parse(document.getElementById("translation-container").getAttribute("data-translations"));
    const request = (url,params) => {
        let elem = $(".load")
        elem.addClass("bx-loader bx-spin").removeClass("bx-check-shieldn")
        setTimeout(() => {
            $.post(url,params,function(result){
                if(JSON.parse(result).type == 'success'){
                    elem.removeClass("bx-loader bx-spin").addClass("bx-check-shieldn")
                    showToast(translator["Success"],translator["Signin successful"],"success")
                    setTimeout(function(){
                        window.location.href = JSON.parse(result).url
                    },1000)
                }else{
                    elem.removeClass("bx-loader bx-spin").addClass("bx-check-shieldn")
                    showToast(translator["Heads up!!"],translator["Invalid email or password"],"error")
                }
            })
        },1000)
    }

    $(".signin").on("click",function(evt){
        evt.preventDefault()
        let params = {email: $(".email").val().trim(),password: $(".password").val().trim()};
        let isEmpty = Object.values(params).some(param => param === "");
        !isEmpty ? request('admin/signin',params) : showToast(translator["Heads up!!"],translator["All fields are mandatory"],"info");
    })

    

    $(".lang").on("change",function(){
        const language = $(this).val()
        $.post("/admin/limvo/admin/changelang/" + language , function(){
                window.location.href = ""
        })
    })

})