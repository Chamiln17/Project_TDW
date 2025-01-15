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

    public function display($donations)
    {
        require_once "./views/includes/header.php";
        ?>
        <div class="max-w-6xl mx-auto px-4 py-12">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900">Historique des dons</h1>
                <button onclick="exportToPDF()"
                        class="bg-red-600 text-white rounded-lg py-2 px-4 hover:bg-red-700 transition-colors">
                    Exporter en PDF
                </button>
            </div>

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
                            Mode de paiement
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
                                <?= htmlspecialchars($donation['payment_method']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        require_once "./views/includes/footer.php";
    }
}
