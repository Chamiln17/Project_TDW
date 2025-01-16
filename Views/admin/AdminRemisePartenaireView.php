<?php

class AdminRemisePartenaireView
{
    private $controller;

    function __construct()
    {
        $this->controller = new \Controllers\AdminRemisePartenaireController();
    }

    public function displayRemisePartenaire($partner, $discounts, $advantages)
    {
        $partner = $partner[0]; // Ensure $partner is an array
        require_once "./views/includes/header.php";
        ?>

        <main class="ml-64">
            <div class="min-h-screen bg-gray-100 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Header -->
                    <div class="md:flex md:items-center md:justify-between">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                                Remises et Avantages pour <?= htmlspecialchars($partner['name']) ?>
                            </h2>
                        </div>
                    </div>

                    <!-- Add Discount Form -->
                    <div class="mt-8 bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Ajouter une Remise</h3>
                        <form action="/Project_TDW/admin/partners/remises/<?= $partner['partner_id'] ?>/add-discount" method="POST">                            <div>
                                <label for="discount_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="discount_description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Pourcentage de Réduction</label>
                                <input type="number" step="0.01" name="discount_percentage" id="discount_percentage" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Date de Début</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="membership_type_id" class="block text-sm font-medium text-gray-700">Type de Membre</label>
                                <select name="membership_type_id" id="membership_type_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                    <option value="1">Classic</option>
                                    <option value="2">Premium</option>
                                    <option value="3">Youth</option>
                                    <option value="4">Senior</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    Ajouter Remise
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Add Advantage Form -->
                    <div class="mt-8 bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-xl font-semibold text-gray-900">Ajouter un Avantage</h3>
                        <form action="/Project_TDW/admin/partners/remises/<?= $partner['partner_id'] ?>/add-advantage" method="POST" class="mt-4 space-y-4">
                            <div>
                                <label for="advantage_description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="advantage_description" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Date de Début</label>
                                <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                                <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                            </div>
                            <div>
                                <label for="membership_type_id" class="block text-sm font-medium text-gray-700">Type de Membre</label>
                                <select name="membership_type_id" id="membership_type_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                    <option value="1">Classic</option>
                                    <option value="2">Premium</option>
                                    <option value="3">Youth</option>
                                    <option value="4">Senior</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                    Ajouter Avantage
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Discounts Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-900">Remises</h3>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <?php foreach ($discounts as $discount): ?>
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($discount['description']) ?>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Réduction: <?= htmlspecialchars($discount['discount_percentage']) ?>%
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Valide du <?= htmlspecialchars($discount['start_date']) ?> au <?= htmlspecialchars($discount['end_date']) ?>
                                    </div>
                                    <div class="mt-4 flex space-x-2">
                                        <a href="/Project_TDW/admin/partners/remises/<?= $partner['partner_id'] ?>/edit-discount/<?= $discount['discount_id'] ?>" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                        <form action="/Project_TDW/admin/partners/remises/<?= $partner['partner_id'] ?>/delete-discount/<?= $discount['discount_id'] ?>" method="POST" class="inline">
                                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Advantages Section -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-900">Avantages</h3>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            <?php foreach ($advantages as $advantage): ?>
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg p-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?= htmlspecialchars($advantage['description']) ?>
                                    </div>
                                    <div class="mt-2 text-sm text-gray-500">
                                        Valide du <?= htmlspecialchars($advantage['start_date']) ?> au <?= htmlspecialchars($advantage['end_date']) ?>
                                    </div>
                                    <div class="mt-4 flex space-x-2">
                                        <a href="/Project_TDW/admin/partners/remises/<?= $partner['partner_id'] ?>/edit-advantage/<?= $advantage['advantage_id'] ?>" class="text-blue-600 hover:text-blue-900">Modifier</a>
                                        <form action="/Project_TDW/admin/partners/remises/<?= $partner['partner_id'] ?>/delete-advantage/<?= $advantage['advantage_id'] ?>" method="POST" class="inline">
                                            <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php
        require_once "./views/includes/footer.php";
    }

    public function displayEditDiscountForm($partnerId, $discount)
    {
        require_once "./views/includes/header.php";
        ?>

        <main class="ml-64">
            <div class="min-h-screen bg-gray-100 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Modifier la Remise
                    </h2>
                    <form action="/Project_TDW/admin/partners/remises/<?= $partnerId ?>/update-discount/<?= $discount['discount_id'] ?>" method="POST" class="mt-4 space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="text" name="description" id="description" value="<?= htmlspecialchars($discount['description']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Pourcentage de Réduction</label>
                            <input type="number" step="0.01" name="discount_percentage" id="discount_percentage" value="<?= htmlspecialchars($discount['discount_percentage']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Date de Début</label>
                            <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($discount['start_date']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                            <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($discount['end_date']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <?php
        require_once "./views/includes/footer.php";
    }

    public function displayEditAdvantageForm($partnerId, $advantage)
    {
        require_once "./views/includes/header.php";
        ?>

        <main class="ml-64">
            <div class="min-h-screen bg-gray-100 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                        Modifier l'Avantage
                    </h2>
                    <form action="/Project_TDW/admin/partners/remises/<?= $partnerId ?>/update-advantage/<?= $advantage['advantage_id'] ?>" method="POST" class="mt-4 space-y-4">
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="text" name="description" id="description" value="<?= htmlspecialchars($advantage['description']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Date de Début</label>
                            <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($advantage['start_date']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                            <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($advantage['end_date']) ?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        </div>
                        <div>
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

        <?php
        require_once "./views/includes/footer.php";
    }
}