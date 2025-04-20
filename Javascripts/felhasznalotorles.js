$(document).ready(function () {
    loadUsers();

    // Törlés gombra kattintás
    $(document).on('click', '.delete-btn', function () {
        var userId = $(this).data('id');

        $.ajax({
            url: 'assets/felhasznalo.php',
            method: 'GET',
            data: { id: userId },
            success: function (response) {
                if (typeof response === 'string') {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        alert("Hibás válasz a szervertől.");
                        console.error("Parse error:", response);
                        return;
                    }
                }

                if (response.status === "success") {
                    alert(response.message);
                    loadUsers(); // Újratöltés
                } else {
                    alert("Hiba: " + response.message);
                }
            },
            error: function () {
                alert('Hiba történt a törlés során.');
            }
        });
    });
});

// Felhasználók betöltése és megjelenítése
function loadUsers() {
    $.ajax({
        url: 'assets/felhasznalo.php',
        method: 'GET',
        success: function (response) {
            let users;
            try {
                users = (typeof response === 'object') ? response : JSON.parse(response);
            } catch (e) {
                alert("Nem sikerült betölteni a felhasználókat.");
                console.error("JSON parse hiba:", response);
                return;
            }

            let tableHtml = '<h2>Felhasználók</h2><table border="1"><tr><th>ID</th><th>Név</th><th>Email</th><th>Művelet</th></tr>';
            users.forEach(function (user) {
                tableHtml += `<tr>
                    <td>${user.id}</td>
                    <td>${user.nev}</td>
                    <td>${user.email}</td>
                    <td><button class="delete-btn" data-id="${user.id}">Törlés</button></td>
                </tr>`;
            });
            tableHtml += '</table>';

            $('#felhasznalo_torles').html(tableHtml);
        },
        error: function () {
            alert('Hiba történt a felhasználók lekérdezésekor.');
        }
    });
}
