<?php
use Controllers\UserDashboardController;
class DashboardView
{
    private $controller;

    function __construct()
    {
        if ($this->controller == null) {
            $this->controller = new UserDashboardController();
        }
    }
    function renderDiscountsSection($columns, $rows, $itemsPerPage = 10): void
    {
        $columnsJSON = json_encode($columns);
        $rowsJSON = json_encode($rows);
        ?>
        <!-- Discounts Section -->
        <section class="max-w-7xl mx-auto">
            <div class="p-8">
                <h2 class="text-4xl font-bold text-gray-800 mb-3">Les Remises</h2>
                <p class="text-gray-500 mb-8">Découvrez les réductions exclusives réservées à nos membres</p>

                <!-- Table Container -->
                <div class="overflow-hidden shadow-xl rounded-xl bg-white border border-gray-100">
                    <table class="w-full border-collapse bg-white">
                        <thead>
                        <tr class="bg-gray-50">
                            <?php foreach ($columns as $column) : ?>
                                <th class="px-8 py-5 text-left text-sm font-semibold text-gray-700">
                                    <?= htmlspecialchars($column) ?>
                                </th>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody id="discounts-table">
                        <!-- Rows will be populated dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Buttons -->
                <div class="mt-8 flex items-center justify-between">
                    <button id="prev-btn" class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg">Précédent</button>
                    <span id="page-info"></span>
                    <button id="next-btn" class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg">Suivant</button>
                </div>
            </div>
        </section>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const columns = <?= $columnsJSON ?>;
                const rows = <?= $rowsJSON ?>;
                const itemsPerPage = <?= $itemsPerPage ?>;
                const discountsTable = document.getElementById('discounts-table');
                const pageInfo = document.getElementById('page-info');
                const prevBtn = document.getElementById('prev-btn');
                const nextBtn = document.getElementById('next-btn');

                let currentPage = 1;
                const totalItems = rows.length;
                const totalPages = Math.ceil(totalItems / itemsPerPage);

                function renderTable(page) {
                    const start = (page - 1) * itemsPerPage;
                    const end = start + itemsPerPage;
                    const currentRows = rows.slice(start, end);

                    discountsTable.innerHTML = currentRows.map(row => `
                    <tr>
                        ${columns.map(column => `
                            <td class="px-8 py-6">${row[column]}</td>
                        `).join('')}
                    </tr>
                `).join('');

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

                renderTable(currentPage);
            });
        </script>
        <?php
    }
    public function afficherDashboard()
    {
        $member=$this->controller->get_member($_SESSION["user_id"]);
        $prenom=$member[0]['first_name'];
        $nom=$member[0]['last_name'];
        $id=$member[0]['member_id'];
        $photo=$member[0]['photo'];
        $type_adhesion=$member[0]['type_adhesion'];
        $expiration_date=$member[0]['expiration_date'];
        $qrCode = $this->controller->generate_member_qr($id);
        $discounts = $this->controller->getDiscounts($id);

        require_once "./views/includes/header.php";
        ?>

        <div class="container mx-auto mt-8 p-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">Bienvenue, <?php echo htmlspecialchars($prenom); ?></h1>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Votre carte de membre</h2>

                <!-- Updated Card Design -->
                <div class="relative w-full max-w-md mx-auto h-56 rounded-xl overflow-hidden bg-white shadow-lg">
                    <!-- Curved Background -->
                    <div class="absolute top-0 right-0 h-full w-1/2 overflow-hidden">
                        <img src="./assets/shapes/shape_card.svg" alt="Background Shape" class="h-full w-full object-cover ">
                    </div>

                    <!-- Logo -->
                    <div class="absolute top-4 right-4 z-20">
                        <img src="./assets/shapes/logo.svg" alt="Coeur espoir" class="h-8">
                    </div>

                    <!-- Member Information -->
                    <div class="relative z-20 p-6 flex flex-row h-full justify-between">
                        <div class="space-y-4">
                            <!-- Profile Section -->
                            <div class="flex  items-start space-x-3">
                                <div class="w-16 h-16 rounded-lg overflow-hidden">
                                    <img
                                            src="<?php echo htmlspecialchars($photo); ?>"
                                            alt="Photo de profil"
                                            class="w-full h-full object-cover"
                                    >
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900">
                                        <?php echo htmlspecialchars($prenom . ' ' . $nom); ?>
                                    </h3>
                                    <p class="text-sm text-gray-600">Membre</p>
                                </div>
                            </div>

                            <!-- Member Details -->
                            <div class="space-y-1">
                                <p class="text-sm text-gray-600">
                                    ID: <span class="text-lg font-bold"><?php echo htmlspecialchars($id); ?></span>
                                </p>
                                <p class="text-sm  text-gray-600">
                                    Type carte: <span class="text-lg font-bold"><?php echo htmlspecialchars(ucfirst($type_adhesion)); ?></span>
                                </p>
                                <p class="text-sm  text-gray-600">
                                    Valide jusqu'au: <span class="text-lg font-bold"><?php echo htmlspecialchars(ucfirst($expiration_date)); ?></span>
                                </p>
                            </div>
                        </div>

                        <!-- QR Code -->
                        <?php if ($qrCode): ?>
                            <div class="absolute bottom-4 right-4 z-20 bg-white rounded-lg p-1">
                                <img src="<?php echo $qrCode; ?>"
                                     alt="QR Code"
                                     class="w-20 h-20">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php
            $columns = ['Partenaire', 'Type dadhésion', 'Remise (%)', 'Date début', 'Date fin'];

            $this->renderDiscountsSection($columns, $discounts); ?>

        </div>
        </div>
    <?php
        require_once "./views/includes/footer.php";
    }




}