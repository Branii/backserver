$(function(){

    function showToast(title, message, type) {
        $.toast({
            position: "bottom-right",
            title: title,
            message: message,
            type: type,
            duration: 3000, // auto-dismiss after 3s
        });
        let savedLang = localStorage.getItem("selectedLanguage") || "en";
        loadTranslations(savedLang);
    }

    const request = (url,params) => {
        $(".load").removeClass("bx-check-shield").addClass("bx-loader bx-spin");
        setTimeout(function(){
            $.post(url, params, function (result) {
              console.log(result);
              $(".load").removeClass("bx-loader bx-spin").addClass("bx-check-shield");
              if(JSON.parse(result).type == 'success'){
                  window.location.href = JSON.parse(result).url
              }else{
               showToast("<span class='translatable' data-key='heads_up'>Heads up!!</span>","<span class='translatable' data-key='wrong_password'>Wrong email or password</span>","error")
              }

            });
        },1000)
    }

    $(".signin").on("click",function(evt){
        evt.preventDefault()
        let params = {email: $(".email").val().trim(),password: $(".password").val().trim()};
        let isEmpty = Object.values(params).some(param => param === "");
        !isEmpty ? request('../limvo/auth/signin',params) : showToast('<span class="translatable" data-key="heads_up">Heads up!!</span>','<span class="translatable" data-key="required_fields">All fields are required</span>','info');
    })

    $(document).on("click", "#en_lang", function() {
        loadTranslations("en");
    })
    
    $(document).on("click", "#zh_lang", function() {
        loadTranslations("zh");
    })
    
    function loadTranslations(lang) {
        if (localStorage.getItem(`selectedLanguage`) == lang) {
            applyTranslations(JSON.parse(localStorage.getItem(`translations`)));
        } else {
            $.getJSON("../../admin/app/assets/lang/lang.json", function (data) {
                if (data[lang]) {
                    localStorage.setItem(`translations`, JSON.stringify(data[lang]));
                    localStorage.setItem("selectedLanguage", lang);
                    applyTranslations(data[lang]);
                }
            });
        }
   }

   function applyTranslations(translations) {
        $(".translatable").each(function () {
            let key = $(this).data("key");
            if (translations[key]) {
                $(this).text(translations[key]);
                $(this).attr("placeholder", translations[key]);
            }
        });
    }

    let savedLang = localStorage.getItem("selectedLanguage") || "en";
    loadTranslations(savedLang);

})


