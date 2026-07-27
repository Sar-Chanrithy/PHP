<?php
$users = [
    ['id' => 1, 'name' => 'Sar Chanrithy', 'email' => 'rithysar@gmail.com', 'role' => 'Admin', 'status' => 'Active', 'action' => '<button>Edit</button> <button>Delete</button>'],
    ['id' => 2, 'name' => 'Yorn reaksa', 'email' => 'reaksa@gmail.com', 'role' => 'User', 'status' => 'Inactive', 'action' => '<button>Edit</button> <button>Delete</button>'],
    ['id' => 3, 'name' => 'Sem Dara', 'email' => 'dara@gmail.com', 'role' => 'Editor', 'status' => 'Inactive', 'action' => '<button>Edit</button> <button>Delete</button>'],
    ['id' => 4, 'name' => 'Sem Somnea', 'email' => 'somnea@gmail.com', 'role' => 'User', 'status' => 'Active', 'action' => '<button>Edit</button> <button>Delete</button>'],
];
$product = array_map(function($user){
    return "
        <tr>
            <td>{$user['id']}</td>
            <td>{$user['name']}</td>
            <td>{$user['email']}</td>
            <td>{$user['role']}</td>
            <td>{$user['status']}</td>
            <td>{$user['action']}</td>
        </tr>
    ";
}, $users);
// $product = array_filter($users, function($user){
//     return $user['status'] == 'Active';
// });
// ?>

<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
        }
        th {
            background: #333;
            color: white;
        }
    </style>
</head>
<body>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>status</th>
        <th>action</th>
    </tr>
    <?= implode("", $product) ?>
    <?php foreach($product as $user): ?>
<!-- <tr>
    <td><?= $user['id'] ?></td>
    <td><?= $user['name'] ?></td>
    <td><?= $user['email'] ?></td>
    <td><?= $user['role'] ?></td>
    <td><?= $user['status'] ?></td>
    <td><?= $user['action'] ?></td>
</tr>
<?php endforeach; ?> -->
</table>
</body>
</html>