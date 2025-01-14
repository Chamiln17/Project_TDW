<?php
use Controllers\PartnerController;

class PartnerView {
    private $controller;

    function __construct() {
        if ($this->controller == null) {
            $this->controller = new PartnerController();
        }
    }

    public function afficherPartner($partnerId): void
    {
        require_once "./views/includes/header.php";
        $partner = $this->controller->getPartnerDetails($partnerId);
        $advantages = $this->controller->getPartnerAdvantages($partnerId);
        $discounts = $this->controller->getPartnerDiscounts($partnerId);
        ?>

        <div class="min-h-screen bg-gray-50">
            <!-- Hero Section -->
            <div class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <div class="md:w-1/3">
                            <img src="<?= htmlspecialchars($partner['logo']) ?>"
                                 alt="<?= htmlspecialchars($partner['name']) ?>"
                                 class="w-full h-48 object-contain">
                        </div>
                        <div class="md:w-2/3">
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">
                                <?= htmlspecialchars($partner['name']) ?>
                            </h1>
                            <div class="flex items-center gap-4 text-gray-600 mb-4">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?= htmlspecialchars($partner['city']) ?>
                                </span>
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    <?= htmlspecialchars($partner['categoryName']) ?>
                                </span>
                            </div>
                            <?php if (isset($_SESSION['user_id'])): ?>
                                <button id="favoriteBtn"
                                        class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-700 transition duration-150"
                                        onclick="toggleFavorite(<?= $partnerId ?>)">
                                    <?= $partner['isFavorite'] ? 'Retirer des favoris' : 'Ajouter aux favoris' ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Sections -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Advantages Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Avantages</h2>
                        <div class="space-y-4">
                            <?php foreach ($advantages as $advantage): ?>
                                <div class="border-l-4 border-red-600 pl-4">
                                    <p class="text-gray-700"><?= htmlspecialchars($advantage['description']) ?></p>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Valable du <?= date('d/m/Y', strtotime($advantage['start_date'])) ?>
                                        au <?= date('d/m/Y', strtotime($advantage['end_date'])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Discounts Section -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Remises</h2>
                        <div class="space-y-4">
                            <?php foreach ($discounts as $discount): ?>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-lg font-semibold text-red-600">
                                            <?= number_format($discount['discount_percentage'], 2) ?>% de remise
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            <?= htmlspecialchars($discount['membershipType']) ?>
                                        </span>
                                    </div>
                                    <p class="text-gray-700"><?= htmlspecialchars($discount['description']) ?></p>
                                    <p class="text-sm text-gray-500 mt-2">
                                        Valable du <?= date('d/m/Y', strtotime($discount['start_date'])) ?>
                                        au <?= date('d/m/Y', strtotime($discount['end_date'])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleFavorite(partnerId) {
                fetch('/toggle-favorite.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ partnerId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const btn = document.getElementById('favoriteBtn');
                            if (data.isFavorite) {
                                btn.textContent = 'Retirer des favoris';
                            } else {
                                btn.textContent = 'Ajouter aux favoris';
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>

        <?php
        require_once "./views/includes/footer.php";
    }
}