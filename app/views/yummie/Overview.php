<main>
    <div class="yummieOverview-hero">
        <img src="images/yummie/Grote-Markt-Haarlem.jpg" class="img-fluid w-100" alt="Stadsgezicht">
    </div>
    <!-- Filterbalk -->
    <form method="GET" action="" class="container my-4">
        <div class="row yummieOverview-filter-bar text-center p-3 justify-content-center">

            <!-- Duration -->
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn yummieOverview-dropdown dropdown-toggle w-100" type="button"
                        id="dropdownDuration" data-bs-toggle="dropdown" aria-expanded="false">
                        Duration
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php foreach ($durations as $duration): ?>
                            <li><a class="dropdown-item" href="javascript:void(0);"
                                    onclick="applyFilter('duration', '<?= $duration ?>')"><?= $duration ?> h</a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <!-- Open Time -->
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn yummieOverview-dropdown dropdown-toggle w-100" type="button"
                        id="dropdownOpen_time" data-bs-toggle="dropdown" aria-expanded="false">
                        Open time
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php foreach ($openTimes as $time): ?>
                            <li><a class="dropdown-item" href="javascript:void(0);"
                                    onclick="applyFilter('open_time', '<?= $time ?>')"><?= $time ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Cuisine -->
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn yummieOverview-dropdown dropdown-toggle w-100" type="button" id="dropdownCuisine"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Cuisine
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php foreach ($cuisines as $cuisine): ?>
                            <li><a class="dropdown-item" href="javascript:void(0);"
                                    onclick="applyFilter('cuisine', '<?= $cuisine ?>')"><?= $cuisine ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Rating -->
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn yummieOverview-dropdown dropdown-toggle w-100" type="button" id="dropdownRating"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Rating
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php foreach ($ratings as $rating): ?>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="applyFilter('rating', '<?= $rating ?>')">
                                    <?= str_repeat('★', $rating) . str_repeat('☆', 5 - $rating); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Cost -->
            <div class="col-md-2">
                <div class="dropdown">
                    <button class="btn yummieOverview-dropdown dropdown-toggle w-100" type="button" id="dropdownCost"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Cost
                    </button>
                    <ul class="dropdown-menu w-100">
                        <?php foreach ($costs as $costValue => $costLabel): ?>
                            <li>
                                <a class="dropdown-item" href="javascript:void(0);"
                                    onclick="applyFilter('cost', '<?= $costValue ?>')">
                                    <?= $costLabel ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>
    </form>

    <div class="container">
        <div id="restaurant-list">
            <?php require_once __DIR__ . '../../components/yummie/restaurant-list.php'; ?>
        </div>
    </div>
</main>

<script src="/js/common.js"></script>
<script src="/js/yummie-overview.js"></script>