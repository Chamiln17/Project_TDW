<?php
class AdvantagesDiscountsView {

    private $controller;

    function __construct()
    {
        if ($this->controller == null) {
            $this->controller = new \Controllers\AdvantagesDiscountsController();
        }
    }
    public function display() {

        // Get member's membership type
        $user_id = $_SESSION['user_id'];
        $memberId = $this->controller->getMemberId($user_id)["member_id"];
        $membershipType = $this->controller->getMembershipType($memberId);


        // Get discounts and advantages
        $discounts = $this->controller->getDiscountsByMembershipType($membershipType['type_id']);
        $advantages = $this->controller->getAdvantagesByMembershipType($membershipType['type_id']);
        require_once "./views/includes/header.php";
        ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Membership Type Header -->
            <div class="mb-12 text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    Avantages <?= htmlspecialchars($membershipType['type_name']) ?>
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    <?= htmlspecialchars($membershipType['benefits_description']) ?>
                </p>
            </div>

            <!-- Discounts Section -->
            <section class="mb-16">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Réductions Disponibles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($discounts as $discount): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden mr-4">
                                        <img src="<?= htmlspecialchars($discount['partner_logo']) ?>"
                                             alt="<?= htmlspecialchars($discount['partner_name']) ?>"
                                             class="w-full h-full object-cover"/>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <?= htmlspecialchars($discount['partner_name']) ?>
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            <?= htmlspecialchars($discount['category_name']) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <span class="inline-flex items-center px-4 py-2 bg-red-50 text-red-600 rounded-lg text-lg font-medium">
                                        -<?= number_format($discount['discount_percentage'], 2) ?>%
                                    </span>
                                </div>

                                <p class="text-gray-600 mb-4">
                                    <?= htmlspecialchars($discount['discount_description']) ?>
                                </p>

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>
                                        <?= htmlspecialchars($discount['city']) ?>
                                    </span>
                                    <span>
                                        Valide jusqu'au <?= date('d/m/Y', strtotime($discount['end_date'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Advantages Section -->
            <section>
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Avantages Exclusifs</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($advantages as $advantage): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                            <div class="p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center overflow-hidden mr-4">
                                        <img src="<?= htmlspecialchars($advantage['partner_logo']) ?>"
                                             alt="<?= htmlspecialchars($advantage['partner_name']) ?>"
                                             class="w-full h-full object-cover"/>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <?= htmlspecialchars($advantage['partner_name']) ?>
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            <?= htmlspecialchars($advantage['category_name']) ?>
                                        </p>
                                    </div>
                                </div>

                                <p class="text-gray-600 mb-4">
                                    <?= htmlspecialchars($advantage['advantage_description']) ?>
                                </p>

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <span>
                                        <?= htmlspecialchars($advantage['city']) ?>
                                    </span>
                                    <span>
                                        Valide jusqu'au <?= date('d/m/Y', strtotime($advantage['end_date'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
        <?php
        require_once "./views/includes/footer.php";
    }
}
