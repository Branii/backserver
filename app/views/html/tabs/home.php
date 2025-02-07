<?php 

$adminEmail = $controller->getSeesion("isUserLoggedIn");
$userPermissions = $controller->getUserPermissions($adminEmail);

if (empty($userPermissions)) {
    ?>

  <!-- Card: All Games -->
  <div class="row" >
  <div class="col-md-6 col-lg-3" style="margin-left:30%;margin-top:180px;">
    <div class="card ">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-error bx-flashing" style="font-size:50px;color:#da352b"></i>
        </h6>
        <p class=""><?= $translator['permissionAlert']; ?></p>
        <p class=""><?= $translator['permissionMess']; ?></p>
      </div>
      <div class="d-md-flex align-items-center">
        <div class="form-check">
        </div>
        <div class="mt-3 mt-md-0 ms-auto" style="margin:10px">
        <a href="../admin/signout">
          <button type="submit" class="signin btn hstack gap-6" style="border:solid 1px #ccc">
          <?= $translator['signout']; ?>
          </button>
          </a>
        </div>
      </div>
    </div>
  </div>
  </div>

    <?php
    return;
}
?>
<div class="row">
  <!-- Card: All Games -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-dice-6" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['List of all available games']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['All Games']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Revenue -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-pie-chart-alt-2" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['View revenue graph and statistics']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Revenue']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Activity Logs -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-history" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['Track activities and system loggings']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Activity Logs']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: System Settings -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-cog" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['System configuration and platform settings']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['System Settings']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Notifications -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-bell" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['View general system alert and notifications']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Notifications']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Total Users -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-user" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['List of registered platform users']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Total Users']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Draw History -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-bowling-ball" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
         <?= $translator['View list of available game draw history']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Draw History'];?></a>
      </div>
    </div>
  </div>

  <!-- Card: Security -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-shield-x" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
         <?= $translator['System security and update']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Security Breaches']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Policies -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-receipt" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
         <?= $translator['System policies and legal documentations']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Privacy and Policies']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: Administrators -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-user-check" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
          <?= $translator['System administrators and permission']; ?>
        </p>
        <p class="card-link card-text pt-2"><?= $translator['Administrators']; ?></a>
      </div>
    </div>
  </div>

  <!-- Card: App Version -->
  <div class="col-md-6 col-lg-3 hvr-grow">
    <div class="card maincard">
      <div class="card-body">
        <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center">
          <i class="bx bx-info-circle" style="font-size:50px;"></i>
        </h6>
        <p class="card-text pt-2">
        <?= $translator['System information and app versions']; ?>
      
        </p>
        <p class="card-link card-text pt-2"><?= $translator['App Version']; ?></a>
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
          <p class="card-link card-text pt-2">Add new</a>
        </div>
      </div>
    </div> -->

    <div class="col-md-6 col-lg-3 hvr-grow addup" aria-label="Execute" data-bs-toggle="modal" data-bs-target="#view-menus"
    data-bs-placement="top" data-bs-title="Edit dashboard">
    <div class="card maincard">
      <div class="card-body">
      <h6 class="card-subtitle mb-2 text-muted d-flex align-items-center"><i class='bx bx-plus' style="font-size:50px;"></i></h6>
        <p class="card-text pt-2">
          Personalise your dashboard
        </p>
        <p class="card-link card-text pt-2">Manage dashboard</a>
      </div>
    </div>
  </div>

</div>

<div id="view-menus" class="modal fade" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content" style="padding:20px">
      <div class="d-flex justify-content-between">
        <h4 class="card-title">Personalise</h4>
        <div><i class='bx bx-message-square-x tclose' style='color:#868c87;font-size:25px;cursor:pointer;' data-bs-dismiss="modal" aria-label="Close"></i></div>
      </div>
      <p></p>
      <div class="">

      <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <ul class="list-group">
                    <li class="list-group-item">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="list1" />
                        <label class="form-check-label" for="list1">
                          Todo list 1
                        </label>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="list2" />
                        <label class="form-check-label" for="list2">
                          Todo list 2
                        </label>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="list3" />
                        <label class="form-check-label" for="list3">
                          Todo list 3
                        </label>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="list4" />
                        <label class="form-check-label" for="list4">
                          Todo list 4
                        </label>
                      </div>
                    </li>
                    <li class="list-group-item">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="list5" />
                        <label class="form-check-label" for="list5">
                          Todo list 5
                        </label>
                      </div>
                    </li>
                  </ul>
                </div>

                <div class="col-lg-12 d-flex align-items-stretch">
                    <div class=" w-100 position-relative overflow-hidden">
                      <div class="p-1">
                        <div class="modal-footer" id="savemenu">
                          <button type="button" class="btn" data-bs-dismiss="modal" style="border:solid 1px #eee">
                          <i class='bx bx-save' style="font-size:15px"></i> Save menu
                          </button>
                        </div>
                      </div>
                    </div>
                </div>

              </div>
      </div>


 
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