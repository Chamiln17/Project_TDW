<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userRole = $_SESSION['user_role'] ?? 'public'; ?>
<footer>
    <?php if ($userRole == 'admin') { ?>
        <p>Admin Dashboard | Settings | Logout</p>
    <?php } elseif ($userRole == 'member') { ?>
        <p>Member Profile | Settings | Logout</p>
    <?php } else { ?>
        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Liens Rapides</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-300 hover:text-white">Accueil</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white">A Propos</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white">Contact</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Contact</h3>
                        <p class="text-gray-300">Email: contact@coeurespoir.org</p>
                        <p class="text-gray-300">Tel: +33 1 23 45 67 89</p>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Suivez-nous</h3>
                        <div class="flex space-x-4">
                            <!-- Social Media Icons -->
                        </div>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                    <p>&copy; 2024 Coeur Espoir. Tous droits réservés.</p>
                </div>
            </div>
        </footer>    <?php } ?>
</footer>
</body>
</html>