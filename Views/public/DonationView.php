<?php

class DonationView
{
    public function afficherDonation(): void
    {
        require_once "./views/includes/header.php";
        ?>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Hero Section -->
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Faites un don</h1>
                    <p class="text-lg text-gray-600">Votre générosité fait la différence dans la vie des autres</p>
                </div>

                <!-- Donation Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <form action="/Project_TDW/donation" id="donationForm" class="space-y-6" method="POST" enctype="multipart/form-data">
                        <!-- Amount Input -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Montant du don
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">DZD</span>
                                </div>
                                <input type="number" name="amount" id="amount" min="1" step="0.01" required
                                       class="focus:ring-red-500 focus:border-red-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md"
                                       placeholder="0.00">
                            </div>
                        </div>

                        <!-- Receipt Upload -->
                        <div>
                            <label for="receipt" class="block text-sm font-medium text-gray-700 mb-2">
                                Reçu de paiement
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 " stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="recu_paiement" class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                                            <span>Téléverser un fichier</span>
                                            <input id="recu_paiement" name="recu_paiement" type="file" class="sr-only" accept=".pdf,.jpg,.png">
                                        </label>
                                        <p class="pl-1">ou glisser-déposer</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        PDF, PNG, JPG jusqu'à 10MB
                                    </p>
                                </div>
                            </div>
                            <span class="file-preview"></span>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Faire un don
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Information Cards -->
                <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Tax Information -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Déduction fiscale</h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <p>66% de votre don est déductible de vos impôts</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Security Information -->
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-red-100 rounded-md p-3">
                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <div class="ml-5">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Paiement sécurisé</h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <p>Toutes vos transactions sont sécurisées</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // File upload preview
            const fileInput = document.getElementById('recu_paiement');
            fileInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const fileName = file.name;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                    const previewElement = document.querySelector('.file-preview');
                    if (previewElement) {
                        previewElement.textContent = `${fileName} (${fileSize})`;
                    }
                }
            });
        </script>

        <?php
        require_once "./views/includes/footer.php";
    }
}