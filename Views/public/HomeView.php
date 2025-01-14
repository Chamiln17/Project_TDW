<?php
require_once __DIR__ . "/../../Controllers/HomeController.php";
use Controllers\HomeController;
class HomeView
{
    private $controller;
    function __construct()
    {   if ($this->controller == null)
        $this->controller = new HomeController();
    }


    public function afficherHome() {


        // Determine the current page
        $page = 1;
        $itemsPerPage = 10;
        $partners = $this->controller->getPartners();

// Calculate the offset
        $offset = ($page - 1) * $itemsPerPage;

// Fetch the total number of partners
        $totalPartners = $this->controller->getTotalPartners();
// Calculate the total number of pages
        $totalPages = ceil($totalPartners / $itemsPerPage);



        require_once "./views/includes/header.php"?>
        <div class="max-w-6xl mx-auto px-4 py-12">
            <!-- Hero Section -->
            <main class="relative min-h-screen ">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <!-- Text Content -->
                        <div>
                            <h1 class="text-6xl font-bold text-gray-800 leading-tight mb-8">
                                Un coeur qui<br>
                                bat pour<br>
                                l'espoir.
                            </h1>
                            <a href="#" class="inline-block bg-red-600 hover:bg-red-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition-colors duration-200">
                                Faites Une Donation
                            </a>
                        </div>

                        <!-- Heart Image -->
                        <div class="relative">
                            <div class="aspect-square relative">
                                <img
                                        src="./assets/images/heart-hands.png"
                                        alt="Hands sharing heart"
                                        class="w-full h-full object-contain"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- News Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Actualités</h2>
                <div class="relative h-[400px] bg-gray-100 rounded-xl overflow-hidden">
                    <!-- News Slides -->
                    <div class="slide h-full relative active">
                        <img src="./assets/images/image1.webp" class="absolute inset-0 w-full h-full object-cover z-10">
                        <div class="absolute inset-0 h-full bg-black/60 z-20"></div>
                        <div class="absolute z-50 p-8 flex flex-col justify-end h-full">
                            <h3 class="text-2xl text-white font-bold mb-2 ">Campagne de sensibilisation 2024</h3>
                            <p class="text-white/90">Notre nouvelle campagne démarre le mois prochain dans toutes les écoles partenaires.</p>
                        </div>
                    </div>

                    <div class="slide">
                        <img src="./assets/images/image2.webp" class="absolute inset-0 w-full h-full object-cover z-10">
                        <div class="absolute inset-0 h-full bg-black/60 z-20 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute z-50 p-8 flex flex-col justify-end h-full">
                            <h3 class="text-white text-2xl font-bold mb-2">Don record en 2023</h3>
                            <p class="text-white/90">Grâce à votre générosité, nous avons pu aider plus de 1000 familles cette année.</p>
                        </div>
                    </div>
                    <div class="slide">
                        <img src="./assets/images/image3.webp" class="absolute inset-0 w-full h-full object-cover z-10">
                        <div class="absolute inset-0 h-full bg-black/60 z-20 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute z-50 p-8 flex flex-col justify-end h-full">
                            <h3 class="text-white text-2xl font-bold mb-2">Nouveau partenariat médical</h3>
                            <p class="text-white/90">5 nouvelles cliniques rejoignent notre réseau de soins solidaires.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Avantages membres Section -->
            <section class="max-w-7xl mx-auto">
                <div class="p-8">
                    <h2 class="text-4xl font-bold text-gray-800 mb-3">Avantages Membres</h2>
                    <p class="text-gray-500 mb-8">Découvrez tous les avantages exclusifs de nos partenaires</p>

                    <!-- Table Container -->
                    <div class="overflow-hidden shadow-xl rounded-xl bg-white border border-gray-100">
                        <table class="w-full border-collapse bg-white">
                            <thead>
                            <tr class="bg-gray-50">
                                <th class="px-8 py-5 text-left text-sm font-semibold text-gray-700">Logo</th>
                                <th class="px-8 py-5 text-left text-sm font-semibold text-gray-700">Nom Partenaire</th>
                                <th class="px-8 py-5 text-left text-sm font-semibold text-gray-700">Catégorie</th>
                                <th class="px-8 py-5 text-left text-sm font-semibold text-gray-700">Ville</th>
                                <th class="px-8 py-5 text-left text-sm font-semibold text-gray-700">Réduction</th>
                            </tr>
                            </thead>
                            <tbody id="partners-table">
                            <!-- Rows will be populated via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Buttons -->
                    <div class="mt-8 flex items-center justify-between">
                        <button id="prev-btn" class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg">Précédent</button>
                        <span id="page-info"></span>
                        <button id="next-btn" class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg">Suivant</button>
                    </div>
            </section>
            <?
            $columns= ['Logo', 'Nom Partenaire', 'Catégorie', 'Ville', 'Réduction'];
            $rows = $partners;
            renderDiscountsSection($columns, $rows);?>
            <!-- Partners Section -->
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Nos Partenaires</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Partners Slides Container -->
                    <div class="col-span-full bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="partner-slider h-32 flex items-center justify-center">
                            <?php $array = array_chunk($partners, 6);
                            foreach ($array as $partnerGroup): ?>
                                <div class="slide <?= $partnerGroup === reset($array) ? 'active' : '' ?>">
                                    <div class="w-full grid grid-cols-6 gap-12 items-center px-4">
                                        <?php foreach ($partnerGroup as $partner): ?>
                                            <div class="flex flex-col items-center justify-between">
                                                <div class="h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <img src="<?= htmlspecialchars($partner['partnerLogo']) ?>" alt="<?= htmlspecialchars($partner['partnerName']) ?>" class="h-12 object-contain">
                                                </div>
                                                <p class="text-gray-500 text-sm mt-2 text-center"><?= htmlspecialchars($partner['partnerName']) ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>

            // Pagination buttons
            document.addEventListener('DOMContentLoaded', () => {
                // Fetch partner data passed from PHP
                const partners = <?= json_encode($partners) ?>;
                console.log(partners['logo']);
                // Debug: Ensure the data is loaded

                const itemsPerPage = <?= $itemsPerPage ?>;
                const totalPartners = partners.length;
                const totalPages = Math.ceil(totalPartners / itemsPerPage);

                const partnersTable = document.getElementById('partners-table');
                const pageInfo = document.getElementById('page-info');
                const prevBtn = document.getElementById('prev-btn');
                const nextBtn = document.getElementById('next-btn');

                let currentPage = 1;

                function renderTable(page) {
                    // Calculate start and end indices
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;

                    // Get the current slice of partners
                    const currentPartners = partners.slice(start, end);

                    // Debug: Check the slice being rendered

                    // Generate HTML for table rows
                    partnersTable.innerHTML = currentPartners.map(partner => `
                <tr class="table-row-fade">
                <td class="px-8 py-6">
                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden">
                        <img src="${partner.partnerLogo}" alt="Logo" class="w-full h-full object-cover"/>
                    </div>
                </td>
                <td class="px-8 py-6">
                    <div>
                        <div class="text-sm font-semibold text-gray-800">${partner.partnerName}</div>
                        <div class="text-xs text-gray-500">Cuisine française</div> <!-- Adjust if dynamic -->
                    </div>
                </td>
                <td class="px-8 py-6">
                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-md text-sm">${partner.partnerCategory}</span>
                </td>
                <td class="px-8 py-6 text-sm text-gray-600">${partner.city}</td>
                <td class="px-8 py-6">
                    <span class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-medium">
                        ${partner.offer}%
                    </span>
                </td>
            </tr>
            `).join('');

                    // Update page info and button states
                    pageInfo.textContent = `Page ${page} sur ${totalPages}`;
                    prevBtn.disabled = page === 1;
                    nextBtn.disabled = page === totalPages;
                }

                prevBtn.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable(currentPage);
                    }
                });

                nextBtn.addEventListener('click', () => {
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderTable(currentPage);
                    }
                });

                // Initial render
                renderTable(currentPage);
            });


            // Function to handle slides
            function setupSlider(containerClass) {
                const slides = document.querySelectorAll(`${containerClass} .slide`);
                let currentSlide = 0;

                function showSlide(index) {
                    slides.forEach(slide => slide.classList.remove('active'));
                    slides[index].classList.add('active');
                }

                function nextSlide() {
                    currentSlide = (currentSlide + 1) % slides.length;
                    showSlide(currentSlide);
                }

                // Initial setup
                showSlide(0);

                // Change slide every 3 seconds
                setInterval(nextSlide, 3000);
            }

            // Initialize both sliders
            document.addEventListener('DOMContentLoaded', () => {
                setupSlider('.relative'); // News slider
                setupSlider('.partner-slider'); // Partners slider
            });
        </script>


        <?php
        require_once "./views/includes/footer.php";
    }

}