<?php

class EventDetailsView {
    private $controller;

    function __construct() {
        if ($this->controller == null)
            $this->controller = new \Controllers\EventController();
    }

    public function displayEventDetails($event): void
    {
        // Check if user is registered for this event
        $isRegistered = false;
        if (isset($_SESSION['user_id'])) {
            $isRegistered = $this->controller->getVolunteerStatus($_SESSION['user_id'], $event['event_id']);
        }
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
                                    <form action="/Project_TDW/events/<?= $event['event_id'] ?>/register" method="POST">
                                        <?php if (isset($_SESSION['error'])): ?>
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                                <span class="block sm:inline"><?= htmlspecialchars($_SESSION['error']) ?></span>
                                            </div>
                                            <?php unset($_SESSION['error']); ?>
                                        <?php endif; ?>

                                        <?php if (isset($_SESSION['success'])): ?>
                                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                                <span class="block sm:inline"><?= htmlspecialchars($_SESSION['success']) ?></span>
                                            </div>
                                            <?php unset($_SESSION['success']); ?>
                                        <?php endif; ?>
                                        <?php if ($isRegistered): ?>
                                            <input type="hidden" name="action" value="deregister">
                                            <button type="submit"
                                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                                Vous êtes inscrit - Se désinscrire
                                            </button>
                                        <?php else: ?>
                                            <input type="hidden" name="action" value="register">
                                            <button type="submit"
                                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                S'inscrire comme bénévole
                                            </button>
                                        <?php endif; ?>
                                    </form>
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