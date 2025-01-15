<?php

namespace members;
class DonationHistoryView
{
    private $controller;

    function __construct()
    {
        if ($this->controller == null) {
            $this->controller = new \Controllers\DonationController();
        }
    }

    public function display()
    {
        $user_id = $_SESSION['user_id'];
        $donations = $this->controller->getUserDonations($user_id);
        $stats = $this->controller->getDonationStats($user_id);
        require_once "./views/includes/header.php";
        ?>
        <div class="max-w-6xl mx-auto px-4 py-12">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Historique des dons</h1>
                <button onclick="exportToPDF()"
                        class="bg-red-600 text-white rounded-lg py-2 px-4 hover:bg-red-700 transition-colors">
                    Exporter en PDF
                </button>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Donations -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total des dons</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= number_format($stats['total_amount'], 2) ?> DZD</p>
                        </div>
                    </div>
                </div>

                <!-- Number of Donations -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Nombre de dons</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= $stats['total_donations'] ?></p>
                        </div>
                    </div>
                </div>

                <!-- Delivered Donations -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Dons délivrés</p>
                            <p class="text-2xl font-semibold text-gray-900"><?= $stats['delivered_donations'] ?? 0 ?></p>
                        </div>
                    </div>
                </div>

                <!-- Average Donation -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Don moyen</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                <?= number_format($stats['total_amount'] / ($stats['total_donations'] ?: 1), 2) ?> DZD
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donations Table -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Delivrée
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Delivrée le
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($donations as $donation): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= date('d/m/Y', strtotime($donation['donation_date'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= number_format($donation['amount'], 2) ?> DZD
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($donation['is_delivered']): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Oui
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        En attente
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($donation['delivery_date']): ?>
                                    <?= date('d/m/Y', strtotime($donation['delivery_date'])) ?>
                                <?php else: ?>
                                    <span class="text-gray-400">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="pagination" class="flex justify-center mt-4"></div>
            </div>
        </div>

        <script>
            function exportToPDF() {
                // Implement PDF export functionality

                window.location.href = `/Project_TDW/donation/export/pdf?user_id=<?= $user_id ?>`;
            }
            // Pagination
            document.addEventListener('DOMContentLoaded', function () {
                const rows = document.querySelectorAll('table tbody tr');
                const pageSize = 10;
                const pageCount = Math.ceil(rows.length / pageSize);
                const pagination = document.getElementById('pagination');
                let currentPage = 1;

                // Function to show rows for the current page
                function showPage(page) {
                    rows.forEach((row, index) => {
                        if (index >= (page - 1) * pageSize && index < page * pageSize) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                }

                // Function to create pagination buttons
                function createPagination() {
                    pagination.innerHTML = '';

                    // Previous button
                    const prevBtn = document.createElement('button');
                    prevBtn.className = 'inline-flex px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-l-md mx-1';
                    prevBtn.textContent = 'Previous';
                    prevBtn.disabled = currentPage === 1;
                    if (currentPage === 1) {
                        prevBtn.className += ' opacity-50 cursor-not-allowed';
                    }
                    prevBtn.setAttribute('aria-label', 'Previous page');
                    prevBtn.addEventListener('click', () => {
                        if (currentPage > 1) {
                            currentPage--;
                            createPagination();
                            showPage(currentPage);
                        }
                    });
                    pagination.appendChild(prevBtn);

                    // Page number buttons
                    for (let i = 1; i <= pageCount; i++) {
                        const button = document.createElement('button');
                        button.className = `inline-flex px-3 py-2 text-sm bg-gray-600 hover:bg-gray-300 rounded-md mx-1 ${i === currentPage ? 'bg-blue-500 text-white font-bold' : ''}`;
                        button.textContent = i;
                        button.setAttribute('aria-label', `Page ${i}`);
                        button.addEventListener('click', () => {
                            currentPage = i;
                            createPagination();
                            showPage(currentPage);
                        });
                        pagination.appendChild(button);
                    }

                    // Next button
                    const nextBtn = document.createElement('button');
                    nextBtn.className = 'inline-flex px-3 py-2 text-sm bg-gray-200 hover:bg-gray-300 rounded-r-md mx-1';
                    nextBtn.textContent = 'Next';
                    nextBtn.disabled = currentPage === pageCount;
                    if (currentPage === pageCount) {
                        nextBtn.className += ' opacity-50 cursor-not-allowed';
                    }
                    nextBtn.setAttribute('aria-label', 'Next page');
                    nextBtn.addEventListener('click', () => {
                        if (currentPage < pageCount) {
                            currentPage++;
                            createPagination();
                            showPage(currentPage);
                        }
                    });
                    pagination.appendChild(nextBtn);
                }

                // Initial load
                if (rows.length > 0) {
                    showPage(currentPage);
                    createPagination();
                } else {
                    document.querySelector('table').style.display = 'none';
                    const message = document.createElement('p');
                    message.textContent = 'Aucun don enregistré.';
                    message.className = 'text-center text-gray-600';
                    document.querySelector('.bg-white.rounded-xl.shadow-lg.overflow-hidden').appendChild(message);
                }
            });
        </script>
        <?php
        require_once "./views/includes/footer.php";
    }
}