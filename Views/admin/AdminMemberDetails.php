<?php

class AdminMemberDetails
{

    public function displayMemberDetails($member, $donations = [], $volunteers = [])
    {
        require_once "./views/includes/header.php";
        ?>
        <main class="ml-64 bg-gray-50 min-h-screen">
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex justify-between items-center">
                        <h1 class="text-3xl font-bold text-gray-900">Détails du Membre</h1>
                        <a href="/Project_TDW/admin/members"
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Retour à la liste
                        </a>
                    </div>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="flex items-center">
                            <?php if ($member['photo']): ?>
                                <img class="h-16 w-16 rounded-full object-cover"
                                     src="<?= htmlspecialchars($member['photo']) ?>"
                                     alt="<?= htmlspecialchars($member['first_name']) ?>">
                            <?php else: ?>
                                <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-2xl text-gray-500 font-medium">
                                        <?= strtoupper(substr($member['first_name'], 0, 1)) ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            <div class="ml-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?>
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Membre depuis <?= date('d/m/Y', strtotime($member['registration_date'])) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <?= htmlspecialchars($member['email']) ?>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Téléphone</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <?= htmlspecialchars($member['telephone']) ?>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Adresse</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <?= htmlspecialchars($member['address']) ?><br>
                                    <?= htmlspecialchars($member['city']) ?>
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Type de carte</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?= htmlspecialchars($member['membership_type']) ?>
                                    </span>
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Documents</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                        <?php if ($member['id_document']): ?>
                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                <div class="w-0 flex-1 flex items-center">
                                                    <span class="ml-2 flex-1 w-0 truncate">Pièce d'identité</span>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <a href="<?= htmlspecialchars($member['id_document']) ?>" target="_blank"
                                                       class="font-medium text-blue-600 hover:text-blue-500">
                                                        Télécharger
                                                    </a>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($member['recu_paiement']): ?>
                                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                <div class="w-0 flex-1 flex items-center">
                                                    <span class="ml-2 flex-1 w-0 truncate">Reçu de paiement</span>
                                                </div>
                                                <div class="ml-4 flex-shrink-0">
                                                    <a href="<?= htmlspecialchars($member['recu_paiement']) ?>" target="_blank"
                                                       class="font-medium text-blue-600 hover:text-blue-500">
                                                        Télécharger
                                                    </a>
                                                </div>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Member Actions -->
                <div class="mt-6 flex space-x-3">
                    <?php if (!$member['is_validated']): ?>
                        <form action="/Project_TDW/admin/members/approve/<?= $member['member_id'] ?>" method="POST" style="display: inline;">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Approuver le membre
                            </button>
                        </form>
                    <?php endif; ?>
                    <form action="/Project_TDW/admin/members/toggle-block/<?= $member['member_id'] ?>" method="POST" style="display: inline;">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <?= $member['is_blocked'] ? 'Débloquer' : 'Bloquer' ?> le membre
                        </button>
                    </form>
                    <form action="/Project_TDW/admin/members/delete/<?= $member['member_id'] ?>" method="POST" style="display: inline;">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Supprimer le membre
                        </button>
                    </form>
                </div>
            </div>
        </main>

        <?php
    }

}