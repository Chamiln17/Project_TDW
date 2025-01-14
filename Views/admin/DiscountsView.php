<?php

class DiscountsView
{
    public function afficherDiscounts()
    {
        ?>
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-800 text-white">
        <tr>
            <th class="px-6 py-3 text-left text-sm font-medium">
                <input type="checkbox" class="rounded text-red-600" onclick="toggleAllCheckboxes(this)">
            </th>
            <th class="px-6 py-3 text-left text-sm font-medium">Partenaire</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Type d'adhésion</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Remise (%)</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Date début</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Date fin</th>
            <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <?php foreach ($discounts as $discount): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <input type="checkbox" class="rounded text-red-600" value="<?php echo $discount['discount_id']; ?>">
                </td>
                <td class="px-6 py-4"><?php echo htmlspecialchars($discount['partner_name']); ?></td>
                <td class="px-6 py-4"><?php echo htmlspecialchars($discount['type_name']); ?></td>
                <td class="px-6 py-4"><?php echo $discount['discount_percentage']; ?>%</td>
                <td class="px-6 py-4"><?php echo $discount['start_date']; ?></td>
                <td class="px-6 py-4"><?php echo $discount['end_date']; ?></td>
                <td class="px-6 py-4">
                    <button onclick="editDiscount(<?php echo $discount['discount_id']; ?>)"
                            class="text-blue-600 hover:text-blue-800 mr-3">
                        Modifier
                    </button>
                    <button onclick="deleteDiscount(<?php echo $discount['discount_id']; ?>)"
                            class="text-red-600 hover:text-red-800">
                        Supprimer
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
<script>
    // Toggle all checkboxes
    function toggleAllCheckboxes(source) {
        const checkboxes = document.querySelectorAll('tbody input[type="checkbox"]');
        checkboxes.forEach(checkbox => checkbox.checked = source.checked);
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function(e) {
        const searchText = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    // Modal functions
    function openAddModal() {
        document.getElementById('modalTitle').textContent = 'Ajouter une remise';
        document.getElementById('discountId').value = '';
        document.getElementById('discountForm').reset();
        document.getElementById('discountModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('discountModal').classList.add('hidden');
    }

    function editDiscount(id) {
        document.getElementById('modalTitle').textContent = 'Modifier la remise';
        document.getElementById('discountId').value = id;
        // Fetch discount data and populate form
        fetch(`get_discount.php?id=${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('partnerId').value = data.partner_id;
                document.getElementById('membershipTypeId').value = data.membership_type_id;
                document.getElementById('discountPercentage').value = data.discount_percentage;
                document.getElementById('startDate').value = data.start_date;
                document.getElementById('endDate').value = data.end_date;
            });
        document.getElementById('discountModal').classList.remove('hidden');
    }

    function deleteDiscount(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cette remise ?')) {
            fetch('delete_discount.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur lors de la suppression');
                    }
                });
        }
    }

    function handleSubmit(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const id = document.getElementById('discountId').value;
        const url = id ? 'update_discount.php' : 'add_discount.php';

        fetch(url, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erreur lors de l\'enregistrement');
                }
            });
    }

    // Load partner and membership type options when page loads
    fetch('get_partners.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('partnerId');
            data.forEach(partner => {
                const option = new Option(partner.partner_name, partner.partner_id);
                select.add(option);
            });
        });

    fetch('get_membership_types.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('membershipTypeId');
            data.forEach(type => {
                const option = new Option(type.type_name, type.type_id);
                select.add(option);
            });
        });
</script>
<?php
    }

    public function display(mixed $membershipType, $discounts, $advantages)
    {
    }

}