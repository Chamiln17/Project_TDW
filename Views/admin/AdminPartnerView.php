<?php

class AdminPartnerView {
    private $controller;

    function __construct() {
        if ($this->controller == null)
            $this->controller = new \Controllers\AdminPartnerController();
    }

    private function getUniqueCities($partners) {
        $cities = array_unique(array_map(function($partner) {
            return $partner['city'];
        }, $partners));
        sort($cities);
        return $cities;
    }

    private function getCategories($partners) {
        $categories = array_unique(array_map(function($partner) {
            return [
                'id' => $partner['category_id'],
                'name' => $partner['category_name']
            ];
        }, $partners), SORT_REGULAR);

        usort($categories, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $categories;
    }

    public function displayPartnerManagement($partners, $stats,$formData = null, $action = '') {
        $cities = $this->getUniqueCities($partners);
        $categories = $this->getCategories($partners);

        require_once "./views/includes/header.php";
        ?>
    <main class="ml-64">

    <div class="min-h-screen bg-gray-100 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex-1 min-w-0">
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Gestion des Partenaires
                        </h2>
                    </div>
                    <div class="mt-4 flex md:mt-0 md:ml-4">
                        <form method="POST" action="/admin/partners/new">
                            <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Ajouter un Partenaire
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($stats as $stat): ?>
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="rounded-md bg-red-500 p-3">
                                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                <?= htmlspecialchars($stat['category_name']) ?>
                                            </dt>
                                            <dd class="flex items-baseline">
                                                <div class="text-2xl font-semibold text-gray-900">
                                                    <?= $stat['partner_count'] ?> partenaires
                                                </div>
                                                <div class="ml-2 text-sm text-gray-600">
                                                    <?= number_format($stat['avg_discount'], 1) ?>% réduction moyenne
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Filters -->
                <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg p-6">
                    <form id="filterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ville</label>
                            <select name="city" id="cityFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                                <option value="">Toutes les villes</option>
                                <?php foreach ($cities as $city): ?>
                                    <option value="<?= htmlspecialchars($city) ?>"><?= htmlspecialchars($city) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catégorie</label>
                            <select name="category" id="categoryFilter" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm rounded-md">
                                <option value="">Toutes les catégories</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Partners Table -->
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Logo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Ville
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Catégorie
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Réduction
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="partnersTableBody">
                                    <?php foreach ($partners as $partner): ?>
                                        <tr class="partner-row"
                                            data-city="<?= htmlspecialchars($partner['city']) ?>"
                                            data-category-id="<?= htmlspecialchars($partner['category_id']) ?>"
                                            data-category-name="<?= htmlspecialchars($partner['category_name']) ?>">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover"
                                                         src="<?= htmlspecialchars($partner['logo']) ?>"
                                                         alt="Logo">
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($partner['name']) ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">
                                                    <?= htmlspecialchars($partner['city']) ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        <?= htmlspecialchars($partner['category_name']) ?>
                    </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= htmlspecialchars($partner['offer']) ?>%
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form method="POST" action="/Project_TDW/admin/partners/edit/<?= $partner['partner_id'] ?>" class="inline">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                                        Modifier
                                                    </button>
                                                </form>
                                                <form method="POST" action="/admin/partners/delete/<?= $partner['partner_id'] ?>" class="inline ml-4" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce partenaire?');">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <div id="pagination" class="px-6 py-4 bg-white border-t border-gray-200">
                                    <!-- Pagination will be inserted here by JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Partner Form Section -->
        <?php if ($action === 'new' || $action === 'edit'): ?>
            <div class="mt-8 bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <?= $action === 'new' ? 'Ajouter un Partenaire' : 'Modifier le Partenaire' ?>
                    </h3>
                    <form method="POST" action="<?= $action === 'new' ? '/admin/partners/create' : '/admin/partners/update/'.$formData['partner_id'] ?>"
                          class="mt-5 space-y-4" enctype="multipart/form-data">

                        <?php if ($action === 'edit'): ?>
                            <input type="hidden" name="partner_id" value="<?= htmlspecialchars($formData['partner_id']) ?>">
                        <?php endif; ?>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="name" id="name"
                                       value="<?= $action === 'edit' ? htmlspecialchars($formData['name']) : '' ?>"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                       required>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                <input type="text" name="city" id="city"
                                       value="<?= $action === 'edit' ? htmlspecialchars($formData['city']) : '' ?>"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                       required>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Catégorie</label>
                                <select name="category" id="category"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                        required>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"
                                            <?= ($action === 'edit' && $formData['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div>
                                <label for="offer" class="block text-sm font-medium text-gray-700">Réduction (%)</label>
                                <input type="number" name="offer" id="offer"
                                       value="<?= $action === 'edit' ? htmlspecialchars($formData['offer']) : '' ?>"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                       required>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                                <?php if ($action === 'edit' && !empty($formData['logo'])): ?>
                                    <div class="mt-2">
                                        <img src="<?= htmlspecialchars($formData['logo']) ?>" alt="Current logo" class="h-20 w-20 object-cover rounded-full">
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="logo" id="logo"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                                    <?= $action === 'new' ? 'required' : '' ?>>
                            </div>
                        </div>

                        <div class="mt-5 flex justify-end space-x-3">
                            <a href="/admin/partners"
                               class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Annuler
                            </a>
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <?= $action === 'new' ? 'Ajouter' : 'Mettre à jour' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        </div>
        </div>
        </main>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rows = document.querySelectorAll('.partner-row');
                const pageSize = 10;
                const pagination = document.getElementById('pagination');
                let currentPage = 1;

                // Filter functionality
                const cityFilter = document.getElementById('cityFilter');
                const categoryFilter = document.getElementById('categoryFilter');

                function filterPartners() {
                    const selectedCity = cityFilter.value;
                    const selectedCategory = categoryFilter.value;
                    let visibleRows = [];

                    rows.forEach(row => {
                        const rowCity = row.dataset.city;
                        const rowCategoryId = row.dataset.categoryId;

                        // Check if the row matches both filters
                        const cityMatch = !selectedCity || rowCity === selectedCity;
                        const categoryMatch = !selectedCategory || rowCategoryId === selectedCategory;

                        // Show/hide the row based on filter matches
                        if (cityMatch && categoryMatch) {
                            row.classList.remove('hidden');
                            visibleRows.push(row);
                        } else {
                            row.classList.add('hidden');
                        }
                    });

                    // Update pagination
                    currentPage = 1;
                    showPage(currentPage, visibleRows);
                    createPagination(visibleRows);
                }

                function showPage(page, visibleRows) {
                    const start = (page - 1) * pageSize;
                    const end = start + pageSize;

                    visibleRows.forEach((row, index) => {
                        if (index >= start && index < end) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                function createPagination(visibleRows) {
                    const pageCount = Math.ceil(visibleRows.length / pageSize);
                    pagination.innerHTML = '';

                    // Previous button
                    const prevBtn = document.createElement('button');
                    prevBtn.className = `inline-flex px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-l-md mx-1
            ${currentPage === 1 ? 'opacity-50 cursor-not-allowed' : ''}`;
                    prevBtn.textContent = 'Précédent';
                    prevBtn.disabled = currentPage === 1;
                    prevBtn.addEventListener('click', () => {
                        if (currentPage > 1) {
                            currentPage--;
                            showPage(currentPage, visibleRows);
                            createPagination(visibleRows);
                        }
                    });
                    pagination.appendChild(prevBtn);

                    // Page numbers
                    for (let i = 1; i <= pageCount; i++) {
                        const button = document.createElement('button');
                        button.className = `inline-flex px-3 py-2 text-sm rounded-md mx-1
                ${i === currentPage ? 'bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300'}`;
                        button.textContent = i;
                        button.addEventListener('click', () => {
                            currentPage = i;
                            showPage(currentPage, visibleRows);
                            createPagination(visibleRows);
                        });
                        pagination.appendChild(button);
                    }

                    // Next button
                    const nextBtn = document.createElement('button');
                    nextBtn.className = `inline-flex px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-r-md mx-1
            ${currentPage === pageCount ? 'opacity-50 cursor-not-allowed' : ''}`;
                    nextBtn.textContent = 'Suivant';
                    nextBtn.disabled = currentPage === pageCount;
                    nextBtn.addEventListener('click', () => {
                        if (currentPage < pageCount) {
                            currentPage++;
                            showPage(currentPage, visibleRows);
                            createPagination(visibleRows);
                        }
                    });
                    pagination.appendChild(nextBtn);
                }

                // Initial setup
                const visibleRows = Array.from(rows);
                showPage(currentPage, visibleRows);
                createPagination(visibleRows);

                // Event listeners
                cityFilter.addEventListener('change', filterPartners);
                categoryFilter.addEventListener('change', filterPartners);
            });
        </script>
        <?php
        require_once "./views/includes/footer.php";
    }
}