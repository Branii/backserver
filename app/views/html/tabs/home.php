<!-- <div class="card">
<div class="card-body">
    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
    <div class="mb-3 mb-sm-0">
        <h4 class="card-title fw-semibold">Revenue Updates</h4>
        <p class="card-subtitle mb-0">Overview of Profit</p>
    </div>
    </div>
    <div class="row align-items-center">
    <div id="chart"></div>
    </div>
</div>
</div> -->

<div class="row">
  <!-- Card: All Games -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-dice-6" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['List of all available games']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['All Games']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Revenue -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-pie-chart-alt-2" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['View revenue graph and statistics']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Revenue']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Activity Logs -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-history" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['Track activities and system loggings']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Activity Logs']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: System Settings -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-cog" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['System configuration and platform settings']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['System Settings']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Notifications -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-bell" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['View general system alert and notifications']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Notifications']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Total Users -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-user" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['List of registered platform users']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Total Users']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Draw History -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-bowling-ball" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
         <?= $translator['View list of available game draw history']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Draw History'];?></a>
      </div>
    </div>
  </div>

  <!-- Card: Security -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-shield-x" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
         <?= $translator['System security and update']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Security Breaches']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Policies -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-receipt" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
         <?= $translator['System policies and legal documentations']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Privacy and Policies']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Administrators -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-user-check" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['System administrators and permission']; ?>
        </p>
        <a href="#" class="card-link"><?= $translator['Administrators']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: App Version -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-info-circle" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
        <?= $translator['System information and app versions']; ?>
      
        </p>
        <a href="#" class="card-link"><?= $translator['App Version']; ?></a>
      </div>
    </div>
  </div>

  <!-- <div class="col-md-6 col-lg-3 hvr-grow">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title"></h5>
          <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center"><i class='bx bx-plus' style="font-size:50px;"></i></h6>
          <p class="card-text pt-2">
             Sample information
          </p>
          <a href="#" class="card-link">Add new</a>
        </div>
      </div>
    </div> -->

    <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card">
      <div class="card-body">
      <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center"><i class='bx bx-plus' style="font-size:50px;"></i></h6>
        <!-- <p class="card-text pt-2">
          System administrators and permissions
        </p>
        <a href="#" class="card-link">Administrators</a> -->
      </div>
    </div>
  </div>


</div>




<style>
  /* Grow */
.hvr-grow {
    display: inline-block;
    vertical-align: middle;
    transform: translateZ(0);
    box-shadow: 0 0 1px rgba(0, 0, 0, 0);
    backface-visibility: hidden;
    -moz-osx-font-smoothing: grayscale;
    transition-duration: 0.3s;
    transition-property: transform;
    cursor: pointer;
}

.hvr-grow:hover,
.hvr-grow:focus,
.hvr-grow:active {
    transform: scale(1.1);
}
</style>