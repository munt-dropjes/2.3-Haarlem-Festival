<div class="yummieDetail-tabcontent-box">
    <div class="row justify-content-center text-center">
        <!-- Linkerkant: Menu items -->
        <div class="col-md-6">
            <div class="menu-info-container" style="width: 450px;">
                <?php foreach ($restaurant->menu_items as $menu_item): ?>
                    <?php /** @var  \Models\MenuItemModel $menu_item */ ?>
                    <div class="starter-info-content">
                        <h1 class="menu-category"><?= $menu_item->category; ?></h1>
                        <h2 class="menu-item"><?= $menu_item->name; ?></h2>
                        <p class="menu-description"><?= $menu_item->description; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Rechterkant: Extra menu-info -->
        <div class="col-md-6 d-flex align-items-center">
            <div class="menu-extra-info-box">
                <p class="menu-extra-info"><?= nl2br($restaurant->extra_info_menu); ?></p>
            </div>
        </div>
    </div>
</div>
