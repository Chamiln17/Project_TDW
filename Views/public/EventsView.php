<?php

class EventsView {
    private $controller;

    function __construct() {
        if ($this->controller == null)
            $this->controller = new \Controllers\EventController();
    }

    public function displayEventsList(): void
    {
        $events=$this->controller->getEvents();
        require_once "./Views/includes/header.php";
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Événements</h1>

            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($events as $event): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h2 class="text-xl font-semibold text-gray-900"><?= htmlspecialchars($event['event_name']) ?></h2>
                                <span class="px-3 py-1 rounded-full text-sm font-medium <?= $event['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $event['status'] === 'open' ? 'Ouvert' : 'Fermé' ?>
                                </span>
                            </div>

                            <div class="mb-4">
                                <p class="text-gray-600"><?= htmlspecialchars(substr($event['description'], 0, 150)) ?>...</p>
                            </div>

                            <div class="flex items-center text-sm text-gray-500 mb-4">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?= date('d/m/Y', strtotime($event['event_date'])) ?>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <?= $event['volunteer_count'] ?> bénévoles
                                </div>

                                <a href="/Project_TDW/events/<?= $event['event_id'] ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Détails
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        require_once "./Views/includes/footer.php";
    }

    public function displayEventDetails($event): void
    {
        require_once "./Views/includes/header.php";
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($event['event_name']) ?></h1>
                        <span class="px-4 py-2 rounded-full text-sm font-medium <?= $event['status'] === 'open' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                            <?= $event['status'] === 'open' ? 'Inscriptions ouvertes' : 'Inscriptions fermées' ?>
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-2">
                            <div class="prose max-w-none">
                                <h2 class="text-xl font-semibold text-gray-900 mb-4">À propos de l'événement</h2>
                                <p class="text-gray-600"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                            </div>

                            <?php if ($event['status'] === 'open' && isset($_SESSION['user_id'])): ?>
                                <div class="mt-8">
                                    <button onclick="registerAsVolunteer(<?= $event['event_id'] ?>)" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        S'inscrire comme bénévole
                                    </button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations</h3>
                            <dl class="space-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?= date('d/m/Y', strtotime($event['event_date'])) ?></dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Bénévoles inscrits</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?= $event['volunteer_count'] ?> personnes</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        require_once "./Views/includes/footer.php";
    }
}