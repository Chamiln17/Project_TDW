<?php

class MemberView
{
    public function displayMemberList($members)
    {
        require_once "./views/includes/header.php";
        ?>
        <main class="ml-64">
            <section id="members-list" class="p-6">
                <h2 class="text-2xl font-bold mb-6">Liste des Membres</h2>

                <!-- Filters -->
                <div class="grid grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date d'inscription</label>
                        <input type="date" id="dateFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type de carte</label>
                        <select id="cardTypeFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Tous</option>
                            <option value="Classic">Classic</option>
                            <option value="Premium">Premium</option>
                            <option value="Youth">Youth</option>
                            <option value="Senior">Senior</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Secteur préféré</label>
                        <select id="sectorFilter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Tous</option>
                            <option value="Hotels">Hotels</option>
                            <option value="Clinics">Clinics</option>
                            <option value="Schools">Schools</option>
                            <option value="Travel Agencies">Travel Agencies</option>
                            <option value="Restaurants">Restaurants</option>
                            <option value="Pharmacies">Pharmacies</option>
                        </select>
                    </div>
                </div>

                <!-- Members Table -->
                <div class="overflow-x-auto bg-white rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prénom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'inscription</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type de carte</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remises préférées</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($member['last_name']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($member['first_name']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($member['registration_date']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($member['membership_type']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($member['preferred_sectors']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="/Project_TDW/admin/members/<?= $member['member_id'] ?>" class="text-blue-500 hover:text-blue-700">Détails</a>
                                    <a href="/Project_TDW/admin/members/approve/<?= $member['member_id'] ?>" class="text-green-500 hover:text-green-700 ml-2">Approuver</a>
                                    <a href="/Project_TDW/admin/members/reject/<?= $member['member_id'] ?>" class="text-red-500 hover:text-red-700 ml-2">Refuser</a>
                                    <a href="/Project_TDW/admin/members/delete/<?= $member['member_id'] ?>" class="text-red-500 hover:text-red-700 ml-2">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
        <?php
        require_once "./views/includes/footer.php";
    }

    public function displayMemberDetails($member, $donations, $volunteers)
    {
        require_once "./views/includes/header.php";
        ?>
        <main class="ml-64">
            <section id="member-details" class="p-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-6">Détails du Membre</h2>

                    <!-- Personal Information -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Informations Personnelles</h3>
                            <div class="space-y-3">
                                <p><span class="font-medium">Nom:</span> <?= htmlspecialchars($member['last_name']) ?></p>
                                <p><span class="font-medium">Prénom:</span> <?= htmlspecialchars($member['first_name']) ?></p>
                                <p><span class="font-medium">Email:</span> <?= htmlspecialchars($member['email']) ?></p>
                                <p><span class="font-medium">Téléphone:</span> <?= htmlspecialchars($member['telephone']) ?></p>
                                <p><span class="font-medium">Type de carte:</span> <?= htmlspecialchars($member['membership_type']) ?></p>
                            </div>
                        </div>

                        <!-- History -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Historique</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-medium">Dons</h4>
                                    <ul id="donationsList" class="list-disc pl-5">
                                        <?php foreach ($donations as $donation): ?>
                                            <li><?= htmlspecialchars($donation['amount']) ?> DZD - <?= htmlspecialchars($donation['donation_date']) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="font-medium">Bénévolat</h4>
                                    <ul id="volunteeringList" class="list-disc pl-5">
                                        <?php foreach ($volunteers as $volunteer): ?>
                                            <li><?= htmlspecialchars($volunteer['event_name']) ?> - <?= htmlspecialchars($volunteer['event_date']) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex space-x-4">
                        <a href="/Project_TDW/admin/members/edit/<?= $member['member_id'] ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Modifier les informations
                        </a>
                        <a href="/Project_TDW/admin/members/add-payment/<?= $member['member_id'] ?>" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Ajouter un paiement
                        </a>
                    </div>
                </div>
            </section>
        </main>
        <?php
        require_once "./views/includes/footer.php";
    }
}