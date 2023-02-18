
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function getUsers() {
            $.ajax({
                url: "/api/user",
                type: 'GET',
                success: function (data) {
                    console.log(data);
                    updateTable(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error(textStatus, errorThrown);
                }
            });
        }

        function updateTable(data) {
            var users = data;
            var table = $('#user-table tbody');
            table.empty();

            for (var i = 0; i < users.length; i++) {
                var user = users[i];
                var row = $('<tr>');

                row.append($('<td>').text(user.id));
                row.append($('<td>').text(user.name));
                row.append($('<td>').text(user.email));
                row.append($('<td>').text(user.created_on));

                table.append(row);

                table.append(row);
            }
        }

        $(document).ready(function () {

            getUsers();
            setInterval(getUsers, 5000);
        });
    </script>
</head>

<body>
    <table id="user-table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created On</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

    <style>
        #user-table {
            width: 100%;
            margin-top: 20px;
        }

        #user-table th,
        #user-table td {
            text-align: center;
            padding: 10px;
        }

        #user-table thead tr {
            background-color: #333;
            color: #fff;
        }

        #user-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>

</body>

</html>