<?php

class AdminMemberView
{
    private $controller;

    public function __construct()
    {   if ($this->controller == null)
        $this->controller = new \Controllers\MemberController();
    }
    public function displayMemberList($members)
    {
        $membershipTypes=$this->controller->getMembershipsType();
        require_once "./views/includes/header.php";
        ?>
        <main class="ml-64 bg-gray-50 min-h-screen">
            <div class="p-6">
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">Gestion des Membres</h1>
                    <p class="mt-2 text-gray-600">Gérez les membres, approuvez les nouvelles demandes et consultez les informations</p>
                </div>

                <!-- Filters -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtres</h2>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                            <input type="text" id="searchFilter" placeholder="Nom, email..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date d'inscription</label>
                            <input type="date" id="dateFilter"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de carte</label>
                            <select id="membershipFilter"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tous</option>
                                <?php foreach ($membershipTypes as $type): ?>
                                    <option value="<?= htmlspecialchars($type['type_name']) ?>">
                                        <?= htmlspecialchars($type['type_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select id="statusFilter"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Tous</option>
                                <option value="pending">En attente</option>
                                <option value="approved">Approuvé</option>
                                <option value="blocked">Bloqué</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Members Table -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Membre
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type de carte
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date d'inscription
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($members as $member): ?>
                                <tr class="hover:bg-gray-50 member-row"data-status="<?= $member['is_blocked'] ? 'blocked' : ($member['is_validated'] ? 'approved' : 'pending') ?>" data-membership="<?= htmlspecialchars($member['membership_type']) ?>">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <?php if ($member['photo']): ?>
                                                <img class="h-10 w-10 rounded-full object-cover"
                                                     src="/Project_TDW/<?= htmlspecialchars($member['photo']) ?>"
                                                     alt="<?= htmlspecialchars($member['first_name']) ?>">
                                            <?php else: ?>
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                        <span class="text-gray-500 font-medium">
                                                            <?= strtoupper(substr($member['first_name'], 0, 1)) ?>
                                                        </span>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?>
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    @<?= htmlspecialchars($member['username']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= htmlspecialchars($member['email']) ?></div>
                                        <div class="text-sm text-gray-500"><?= htmlspecialchars($member['telephone']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <?= htmlspecialchars($member['membership_type']) ?>
                                            </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                        $statusClass = match($member['is_validated']) {
                                            1 => 'bg-green-100 text-green-800',
                                            0 => 'bg-yellow-100 text-yellow-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        $statusText = match($member['is_validated']) {
                                            1 => 'Approuvé',
                                            0 => 'En attente',
                                            default => 'Non défini'
                                        };
                                        ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                <?= $statusText ?>
                                            </span>
                                        <?php if ($member['is_blocked']): ?>
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Bloqué
                                                </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?= date('d/m/Y', strtotime($member['registration_date'])) ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="/Project_TDW/admin/members/<?= $member['member_id'] ?>"
                                               class="text-blue-600 hover:text-blue-900">Détails</a>
                                            <?php if (!$member['is_validated']): ?>
                                                <form action="/Project_TDW/admin/members/approve/<?= $member['member_id'] ?>" method="POST" style="display: inline;">
                                                    <button type="submit" class="text-green-600 hover:text-green-900">Approuver</button>
                                                </form>
                                            <?php endif; ?>
                                            <form action="/Project_TDW/admin/members/toggle-block/<?= $member['member_id'] ?>" method="POST" style="display: inline;">
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                    <?= $member['is_blocked'] ? 'Débloquer' : 'Bloquer' ?>
                                                </button>
                                            </form>
                                            <form action="/Project_TDW/admin/members/delete/<?= $member['member_id'] ?>" method="POST" style="display: inline;">
                                                <button type="submit" class="text-red-600 hover:text-red-900">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Affichage de <span class="font-medium"><?= count($members) ?></span> membres
                            </div>
                            <div id="pagination" class="flex space-x-2">
                                <!-- Pagination will be inserted here by JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rows = document.querySelectorAll('.member-row'); // Sélectionner les lignes des membres
                const pageSize = 10; // Nombre de membres par page
                const pagination = document.getElementById('pagination'); // Conteneur de la pagination
                let currentPage = 1;

                // Fonction pour afficher une page spécifique
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

                // Fonction pour créer les boutons de pagination
                function createPagination(visibleRows) {
                    const pageCount = Math.ceil(visibleRows.length / pageSize);
                    pagination.innerHTML = '';

                    // Bouton "Précédent"
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

                    // Boutons des numéros de page
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

                    // Bouton "Suivant"
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
                // Fonction pour filtrer les membres
                function filterMembers() {
                    const statusFilter = document.getElementById('statusFilter').value;
                    const membershipFilter = document.getElementById('membershipFilter').value;
                    let visibleRows = [];

                    rows.forEach(row => {
                        const rowStatus = row.dataset.status; // Assurez-vous d'ajouter data-status à chaque ligne
                        const rowMembership = row.dataset.membership; // Assurez-vous d'ajouter data-membership à chaque ligne

                        // Vérifier si la ligne correspond aux filtres
                        const statusMatch = !statusFilter || rowStatus === statusFilter;
                        const membershipMatch = !membershipFilter || rowMembership === membershipFilter;

                        // Afficher/masquer la ligne en fonction des filtres
                        if (statusMatch && membershipMatch) {
                            row.classList.remove('hidden');
                            visibleRows.push(row);
                        } else {
                            row.classList.add('hidden');
                        }
                    });

                    // Mettre à jour la pagination
                    currentPage = 1;
                    showPage(currentPage, visibleRows);
                    createPagination(visibleRows);
                }

                // Ajouter des écouteurs d'événements aux filtres
                document.getElementById('statusFilter').addEventListener('change', filterMembers);
                document.getElementById('membershipFilter').addEventListener('change', filterMembers);

                // Initialisation
                const visibleRows = Array.from(rows);
                showPage(currentPage, visibleRows);
                createPagination(visibleRows);
            });

        </script>
        <?php
    }
}