$(function () {
 
    $(".lang").on("click", function () {
      let lang = $(this).attr("value")
      $.post(`../admin/changelang/${lang}`,
        function(data){
            window.location.href =""
   
        })
       
    });

  
  
  });
  