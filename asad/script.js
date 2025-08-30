

function showContent(contentId) {
    const containers = document.querySelectorAll('.main-content .container');
    containers.forEach(container => container.classList.remove('active'));
    document.getElementById(contentId).classList.add('active');

    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => link.classList.remove('active-link'));
    // handle nested icon clicks
    const link = event.target.closest('a');
    if (link) link.classList.add('active-link');
}
function openEditModal(id) {
    // Fetch the tortoise details using the ID
    const row = document.querySelector(`tr[data-id="${id}"]`);
    const name = row.querySelector('td:nth-child(2)').textContent;
    const species = row.querySelector('td:nth-child(3)').textContent;
    const age = parseInt(row.querySelector('td:nth-child(4)').textContent);
    const gender = row.querySelector('td:nth-child(5)').textContent;
    const health = row.querySelector('td:nth-child(6)').textContent;
    const enclosure = row.querySelector('td:nth-child(7)').textContent;

    // Populate the modal fields
    document.getElementById('tortoiseId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('species').value = species;
    document.getElementById('age').value = age;
    document.getElementById('gender').value = gender;
    document.getElementById('health').value = health;
    document.getElementById('enclosure').value = enclosure;

    // Show the modal
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function openAddModal() {
    // Clear the modal fields
    document.getElementById('tortoiseId').value = ''; // Clear hidden ID field
    document.getElementById('name').value = '';
    document.getElementById('species').value = '';
    document.getElementById('age').value = '';
    document.getElementById('gender').value = '';
    document.getElementById('health').value = 'Healthy'; // Default to 'Healthy'
    document.getElementById('enclosure').value = '';

    // Show the modal
    document.getElementById('modal').classList.remove('hidden');
}

function deleteTortoise(id) {
    if (confirm("Are you sure you want to delete this tortoise?")) {
        // Send a DELETE request to the server
        fetch(`delete_tortoise.php?id=${id}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Tortoise deleted successfully.");
                // Remove the row from the table
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) row.remove();
            } else {
                alert("Failed to delete tortoise: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the tortoise.");
        });
    }
}

// Get the modal
var modal = document.getElementById("editModal");

// Get the button that opens the modal
var btn = document.getElementById("editButton");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

// Get references to the page sections
const tortoiseDetailsPage = document.getElementById("tortoise-details-page");
const dashboardPage = document.getElementById("dashboard-page");
const detailsTable = document.getElementById("details-table");

// Function to navigate to the tortoise details page
function showTortoiseDetailsPage() {
    tortoiseDetailsPage.style.display = "block";
    dashboardPage.style.display = "none";
}

// Function to navigate to the dashboard page
function showDashboardPage() {
    dashboardPage.style.display = "block";
    tortoiseDetailsPage.style.display = "none";

    // Hide or reset the details table
    if (detailsTable) {
        detailsTable.style.display = "none"; // Hide the table
    }
}

// Example: Add event listeners for navigation buttons
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("nav-to-details")?.addEventListener("click", showTortoiseDetailsPage);
    document.getElementById("nav-to-dashboard")?.addEventListener("click", showDashboardPage);
});


function openEnclosureModal() {
    document.getElementById('enclosure-modal').classList.remove('hidden');
}

// Close the Enclosure Modal
function closeEnclosureModal() {
    document.getElementById('enclosure-modal').classList.add('hidden');
}

// Open the Edit Enclosure Modal with pre-filled data
// Open the Edit Enclosure Modal with pre-filled data
function openEditEnclosureModal(id, name, type, capacity, occupancy) {
    document.getElementById('enclosureId').value = id;
    document.getElementById('enclosureName').value = name;
    document.getElementById('enclosureType').value = type;
    document.getElementById('capacity').value = capacity;
    document.getElementById('currentOccupancy').value = occupancy;

    openEnclosureModal(); // show modal
}


function deleteEnclosure(id) {
    if (confirm("Are you sure you want to delete this enclosure?")) {
        fetch(`delete_enclosure.php?id=${id}`, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Enclosure deleted successfully.");
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) row.remove();
            } else {
                alert("Failed to delete enclosure: " + data.message);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the enclosure.");
        });
    }
}


// Open Add Breeding Modal
function openBreedingModal() {
    document.getElementById('breedingForm').reset();
    document.getElementById('breedingId').value = '';
    document.getElementById('breeding-modal').classList.remove('hidden');
}

// Close Breeding Modal
function closeBreedingModal() {
    document.getElementById('breeding-modal').classList.add('hidden');
}

// Open Edit Breeding Modal with data
function openEditBreedingModal(id) {
    // Find the row in the table
    const row = document.querySelector(`#breedingTable tr[data-id='${id}']`);
    if (!row) return;

    document.getElementById('breedingId').value = id;
    document.getElementById('femaleAnimal').value = getOptionValue('femaleAnimal', row.cells[1].innerText);
    document.getElementById('maleAnimal').value = getOptionValue('maleAnimal', row.cells[2].innerText);
    document.getElementById('species').value = row.cells[3].innerText;
    document.getElementById('matingDate').value = row.cells[4].innerText;
    document.getElementById('nestingDate').value = row.cells[5].innerText === '-' ? '' : row.cells[5].innerText;
    document.getElementById('eggCount').value = row.cells[6].innerText === '-' ? '' : row.cells[6].innerText;
    document.getElementById('incubationStart').value = row.cells[7].innerText === '-' ? '' : row.cells[7].innerText;
    document.getElementById('incubationPeriod').value = row.cells[8].innerText === '-' ? '' : row.cells[8].innerText;
    document.getElementById('hatchDate').value = row.cells[9].innerText === '-' ? '' : row.cells[9].innerText;
    document.getElementById('hatchingSuccess').value = row.cells[10].innerText === '-' ? '' : row.cells[10].innerText;
    document.getElementById('observations').value = row.cells[11].innerText === '-' ? '' : row.cells[11].innerText;

    document.getElementById('breeding-modal').classList.remove('hidden');
}

// Helper: Get option value by text (e.g., "Tortoise Name (Species)")
function getOptionValue(selectId, text) {
    const select = document.getElementById(selectId);
    for (let option of select.options) {
        if (option.text.trim() === text.trim()) return option.value;
    }
    return '';
}

// Delete Breeding Record
function deleteBreedingRecord(id) {
    if (!confirm('Are you sure you want to delete this breeding record?')) return;
    window.location.href = `delete_breeding.php?id=${id}`;
}

// Open Add/Edit Surveillance Modal
function openSurveillanceModal(
    id = '', enclosureId = '', size = '', habitat_type = '',
    current_occupants = '', maintenance_schedule = '', temperature = '',
    humidity = '', light_level = '', observations = ''
) {
    document.getElementById('survId').value = id;
    document.getElementById('enclosureSelect').value = enclosureId;
    document.getElementById('size').value = size;
    document.getElementById('habitat_type').value = habitat_type;
    document.getElementById('current_occupants').value = current_occupants;
    document.getElementById('maintenance_schedule').value = maintenance_schedule;
    document.getElementById('temperature').value = temperature;
    document.getElementById('humidity').value = humidity;
    document.getElementById('light_level').value = light_level;
    document.getElementById('observations').value = observations;

    document.getElementById('surveillance-modal').classList.remove('hidden');
}

// Close modal
function closeSurveillanceModal() {
    document.getElementById('surveillance-modal').classList.add('hidden');
    document.getElementById('surveillanceForm').reset();
}

// Delete Surveillance Record
function deleteSurveillance(id) {
    if(confirm("Are you sure you want to delete this surveillance record?")) {
        window.location.href = `delete_surveillance.php?id=${id}`;
    }
}

// Auto-fill size, habitat_type, current occupants when enclosure changes
document.getElementById('enclosureSelect').addEventListener('change', function() {
    const enclosureId = this.value;
    if (!enclosureId) {
        document.getElementById('size').value = '';
        document.getElementById('habitat_type').value = '';
        document.getElementById('current_occupants').value = '';
        return;
    }

    fetch(`get_enclosure_info.php?id=${enclosureId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('size').value = data.size || '';
            document.getElementById('habitat_type').value = data.type || '';
            document.getElementById('current_occupants').value = data.current_occupants || '';
        })
        .catch(err => console.error('Error fetching enclosure info:', err));
});


// Open Add/Edit Feeding Modal
function openFeedingModal(id = '', tortoiseId = '', staffName = '', feedingTime = '', foodType = '', quantity = '', status = '', observations = '') {
    const modal = document.getElementById('feeding-modal');
    modal.classList.remove('hidden');

    document.getElementById('feedingId').value = id;
    document.getElementById('tortoiseSelect').value = tortoiseId;
    document.getElementById('staffSelect').value = staffName;
    document.getElementById('feedingTime').value = feedingTime;
    document.getElementById('foodType').value = foodType;
    document.getElementById('quantity').value = quantity;
    document.getElementById('status').value = status;
    document.getElementById('observations').value = observations;
}

// Close modal
function closeFeedingModal() {
    const modal = document.getElementById('feeding-modal');
    modal.classList.add('hidden');
    document.getElementById('feedingForm').reset();
}

// Delete Feeding Record
function deleteFeeding(id) {
    if (confirm("Are you sure you want to delete this feeding record?")) {
        window.location.href = `delete_feeding.php?id=${id}`;
    }
}

function openFoodModal(id = '', food_item = '', quantity = '') {
    document.getElementById('foodId').value = id;
    document.getElementById('foodName').value = food_item;
    document.getElementById('foodQuantity').value = quantity;
    document.getElementById('food-modal').classList.remove('hidden');
}

function openFoodModal(id = '', food_item = '', quantity = '', added_at = '') {
    document.getElementById('foodId').value = id;
    document.getElementById('foodName').value = food_item;
    document.getElementById('foodQuantity').value = quantity;

    if(added_at){
        // convert from DB datetime to input datetime-local format
        document.getElementById('addedAt').value = added_at.replace(' ', 'T');
    } else {
        document.getElementById('addedAt').value = '';
    }

    document.getElementById('food-modal').classList.remove('hidden');
}


function deleteFood(id) {
    if(confirm('Are you sure you want to delete this food item?')) {
        fetch('delete_food.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id=${id}`
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                location.reload(); // reload the page to reflect changes
            } else {
                alert(data.error || 'Failed to delete');
            }
        });
    }
}



async function generateReport(reportType) {
    const statusDiv = document.getElementById('report-status');
    statusDiv.innerText = 'Fetching data...';

    try {
        const response = await fetch('report.php?report=' + reportType);
        const data = await response.json();

        if (!data || data.length === 0) {
            statusDiv.innerText = 'No records found.';
            return;
        }

        // Access jsPDF from global window
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.setFontSize(16);
        doc.text(reportType.replace('_', ' ').toUpperCase(), 14, 20);

        const headers = Object.keys(data[0]);
        let startY = 30;
        doc.setFontSize(10);

        // Table headers
        headers.forEach((h, i) => doc.text(h, 14 + i * 40, startY));

        // Table rows
        data.forEach((row, rowIndex) => {
            const y = startY + 10 + rowIndex * 8;
            headers.forEach((h, colIndex) => {
                let value = String(row[h]);
                if (value.length > 15) value = value.substring(0, 15) + '...';
                doc.text(value, 14 + colIndex * 40, y);
            });
        });

        doc.save(`${reportType}.pdf`);
        statusDiv.innerText = 'PDF generated successfully!';
    } catch (err) {
        console.error(err);
        statusDiv.innerText = 'Error generating report.';
    }
}
