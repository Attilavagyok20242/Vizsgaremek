$(document).ready(function () {
    loadUsers();

    $(document).on('click', '.delete-btn', function () {
        var userId = $(this).data('id');
        $.ajax({
            url: 'assets/felhasznalo.php',
            method: 'GET',
            data: { id: userId },
            success: function (response) {
                alert(response); 
                loadUsers(); 
            },
            error: function () {
                alert('Hiba történt a törlés során.');
            }
        });
    });
});

function loadUsers() {
    $.ajax({
        url: 'assets/felhasznalo.php',
        method: 'GET',
        success: function (response) {
            var users = JSON.parse(response);
            var tableHtml = '<h1>Felhasznalo Informacio</h1><table border="1"><tr><th>ID</th><th>Felhasználó neve</th><th>Email</th><th>Művelet</th></tr>';
            
            users.forEach(function (user) {
                tableHtml += `<tr>
                    <td>${user.id}</td>
                    <td>${user.nev}</td>
                    <td>${user.email}</td>
                    <td><button class="delete-btn" data-id="${user.id}">Törlés</button></td>
                </tr>`;
            });

            tableHtml += '</table>';
            $('#felhasznalo_torles').html(tableHtml); // A lista megjelenítése
        },
        error: function () {
            alert('Hiba történt a felhasználók lekérdezésekor.');
        }
    });
}