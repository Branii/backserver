<?php
$controller = new Controller;
$adminEmail = $controller->getSeesion("isUserLoggedIn");
$userPermissions = $controller->getUserPermissions($adminEmail);
$definedPermissions = $controller->getPermissionSidebars();
// steve

foreach ($userPermissions as $sidebar => $menu): ?>
    <div class="accordion-item accord-item">  
        <div class="accordion-header" onclick="toggleAccordion(this)">
            <span style="margin-left:15px"><?= $definedPermissions['title'][$sidebar]['icon'] ?>
              <span style="font-size:16px"><?= $translator[$definedPermissions['title'][$sidebar]['title']] ?></span>
            </span>
        </div>
        <div class="accordion-content">
            <ul class="custom-list">
                <?php foreach ($menu as $item): ?>
                    <li class="tab-button item" value="<?= $definedPermissions['menu'][$item]['content'] ?>">
                        <i class="bx bx-radio-circle-marked" style="font-size:20px;margin-left:10px"></i>
                        <span style="margin-left:7px;font-size:14px"><?= $translator[$definedPermissions['menu'][$item]['title']] ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endforeach; ?>
