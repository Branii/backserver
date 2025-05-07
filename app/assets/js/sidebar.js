// function toggleAccordion(header) {
//     var content = header.nextElementSibling;
//     if (content.style.maxHeight) {
//         content.style.maxHeight = null;
//     } else {
//         var active = document.querySelector('.accordion-content.active');
//         if (active) {
//             active.style.maxHeight = null;
//             active.classList.remove('active');
//         }
//         content.style.maxHeight = content.scrollHeight + 'px';
//         content.classList.add('active');
//     }
// }



function toggleAccordion(header) {
    var content = header.nextElementSibling;

    if (content.style.maxHeight) {
        // Collapse this accordion-content
        content.style.maxHeight = null;
        content.classList.remove('active');
    } else {
        // Only collapse sibling accordion-contents within the same parent
        var siblingContents = header.parentElement.parentElement.querySelectorAll('.accordion-content');

        siblingContents.forEach(function (sibling) {
            if (sibling !== content) {
                sibling.style.maxHeight = null;
                sibling.classList.remove('active');
            }
        });

        // Expand the clicked accordion-content
        content.classList.add('active');

        // Calculate scrollHeight dynamically
        if (content.querySelector('.partner-item')) {
            // Main Menu level: Calculate total height of partner items + their contents (even if hidden)
            let totalHeight = 0;
            content.querySelectorAll('.partner-item').forEach(function (partner) {
                // Partner header height
                totalHeight += partner.querySelector('.accordion-header').offsetHeight;

                // Partner submenu height (even if hidden)
                const partnerContent = partner.querySelector('.accordion-content');
                if (partnerContent) {
                    totalHeight += partnerContent.scrollHeight;  // Always use scrollHeight
                }
            });
            content.style.maxHeight = totalHeight + 'px';
        } else {
            // Partner level: Submenu scrollHeight
            content.style.maxHeight = content.scrollHeight + 'px';
        }
    }
}

$(() => {

    $(document).on("click",".pn-wrapper",function(){
      const partnerData =  $(this).attr("id").split("-");
      $("#partner-holder").val(partnerData[0]);
      $("#partner-holder").attr("data-partner-id",partnerData[1]);
    });

});