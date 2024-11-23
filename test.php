<aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="<?php echo BASE_URL; ?>main/index.html" class="text-nowrap logo-img">
            <img src="<?php echo BASE_URL; ?>assets/images/logos/dark-logo.svg" class="dark-logo" alt="Logo-Dark" />
            <img src="<?php echo BASE_URL; ?>assets/images/logos/light-logo.svg" class="light-logo" alt="Logo-light" />
          </a>
          <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
            <i class="ti ti-x"></i>
          </a>
        </div>

        <nav class="sidebar-nav scroll-sidebar" data-simplebar>
          <ul id="sidebarnav">
     

          </ul>
        </nav>

        <div class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
          <div class="hstack gap-3">
            <div class="john-img">
              <img src="../assets/images/profile/user-1.jpg" class="rounded-circle" width="40" height="40" alt="modernize-img" />
            </div>
            <div class="john-title">
              <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
              <span class="fs-2">Designer</span>
            </div>
            <button class="border-0 bg-transparent text-primary ms-auto" tabindex="0" type="button" aria-label="logout" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="logout">
              <i class="ti ti-power fs-6"></i>
            </button>
          </div>
        </div>

        <!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->
      </div>
    </aside>



    console.log(typeof(response))
       if(users){

        let html = "";
       users.forEach((user) => { 
         html += `<option value="${user.username}">${user.username}</option>`; 
       }); 
       console.log("html  " + html)
       //$("#userDropdown").html(html)
       dropdown.style.display = searchkey && users.length ? "block" : "none"; 

       }else{
        $("#userDropdown").html("<option>no data</option>");
       }