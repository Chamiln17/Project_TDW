<?php
use Controllers\CatalogueController;

class CatalogueView {
    private $controller;

    function __construct() {
        if ($this->controller == null)
            $this->controller = new CatalogueController();
    }

    // Helper function to get unique cities
    private function getUniqueCities($partners) {
        return array_unique(array_map(function($partner) {
            return $partner['city'];
        }, $partners));
    }

    // Helper function to get unique categories
    private function getUniqueCategories($partners) {
        return array_unique(array_map(function($partner) {
            return $partner['partnerCategory'];
        }, $partners));
    }

    // Helper function to group partners by category
    private function groupPartnersByCategory($partners) {
        $grouped = [];
        foreach ($partners as $partner) {
            $category = $partner['partnerCategory'];
            if (!isset($grouped[$category])) {
                $grouped[$category] = [];
            }
            $grouped[$category][] = $partner;
        }
        return $grouped;
    }

    function afficherCatalogue() {
        require_once "./views/includes/header.php";
        $partners = $this->controller->getPartners();
        $cities = $this->getUniqueCities($partners);
        $categories = $this->getUniqueCategories($partners);
        $groupedPartners = $this->groupPartnersByCategory($partners);
        ?>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-nav-gray mb-8">Catalogue des Partenaires</h1>

            <!-- Filters -->
            <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par ville</label>
                        <select id="cityFilter" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-red focus:border-brand-red">
                            <option value="">Toutes les villes</option>
                            <?php foreach($cities as $city): ?>
                                <option value="<?= htmlspecialchars($city) ?>">
                                    <?= htmlspecialchars($city) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filtrer par catégorie</label>
                        <select id="categoryFilter" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-brand-red focus:border-brand-red">
                            <option value="">Toutes les catégories</option>
                            <?php foreach($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category) ?>">
                                    <?= htmlspecialchars($category) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Partners Sections -->
            <?php foreach($groupedPartners as $category => $categoryPartners): ?>
                <section class="mb-12 partner-section" data-category="<?= htmlspecialchars($category) ?>">
                    <h2 class="text-2xl font-semibold text-nav-gray mb-6"><?= htmlspecialchars($category) ?></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($categoryPartners as $partner): ?>
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden partner-card"
                                 data-city="<?= htmlspecialchars($partner['city']) ?>"
                                 data-category="<?= htmlspecialchars($partner['partnerCategory']) ?>">
                                <div class="p-6">
                                    <?php if($partner['partnerLogo']): ?>
                                        <img src="<?= htmlspecialchars($partner['partnerLogo']) ?>"
                                             alt="<?= htmlspecialchars($partner['partnerName']) ?>"
                                             class="h-16 w-auto mb-4 object-contain">
                                    <?php endif; ?>
                                    <h3 class="text-lg font-semibold text-nav-gray mb-2">
                                        <?= htmlspecialchars($partner['partnerName']) ?>
                                    </h3>
                                    <p class="text-gray-600 mb-2"><?= htmlspecialchars($partner['city']) ?></p>
                                    <p class="text-brand-red font-semibold mb-4"><?= htmlspecialchars($partner['offer']) ?></p>
                                    <a href="/Project_TDW/catalogue/<?= $partner['partnerId'] ?>"
                                       class="text-nav-gray hover:text-brand-red font-medium">
                                        Plus de détails →
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </main>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cityFilter = document.getElementById('cityFilter');
                const categoryFilter = document.getElementById('categoryFilter');
                const partnerCards = document.querySelectorAll('.partner-card');
                const partnerSections = document.querySelectorAll('.partner-section');

                function filterPartners() {
                    const selectedCity = cityFilter.value;
                    const selectedCategory = categoryFilter.value;

                    partnerCards.forEach(card => {
                        const cardCity = card.dataset.city;
                        const cardCategory = card.dataset.category;

                        // Check if the card matches both filters
                        const cityMatch = !selectedCity || cardCity === selectedCity;
                        const categoryMatch = !selectedCategory || cardCategory === selectedCategory;

                        // Show/hide the card based on filter matches
                        if (cityMatch && categoryMatch) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });

                    // Show/hide sections based on visible cards
                    partnerSections.forEach(section => {
                        const sectionCategory = section.dataset.category;
                        const hasVisibleCards = section.querySelector('.partner-card:not(.hidden)');

                        if ((!selectedCategory || sectionCategory === selectedCategory) && hasVisibleCards) {
                            section.classList.remove('hidden');
                        } else {
                            section.classList.add('hidden');
                        }
                    });
                }

                // Add event listeners
                cityFilter.addEventListener('change', filterPartners);
                categoryFilter.addEventListener('change', filterPartners);
            });
        </script>

        <?php
        require_once "./views/includes/footer.php";
    }
}