<?php 

$student = [
    [
        "id" => 1,
        "name" => "Rouske",
        "gender" => "male",
        "address" => "Phnom Penh",
        "grade" => 6,
        "image" => "https://randomuser.me/api/portraits/men/1.jpg"
    ],
    [
        "id" => 2,
        "name" => "Sokha",
        "gender" => "female",
        "address" => "Siem Reap",
        "grade" => 7,
        "image" => "https://randomuser.me/api/portraits/women/2.jpg"
    ],
    [
        "id" => 3,
        "name" => "Dara",
        "gender" => "male",
        "address" => "Battambang",
        "grade" => 6,
        "image" => "https://randomuser.me/api/portraits/men/3.jpg"
    ],
    [
        "id" => 4,
        "name" => "Sreymom",
        "gender" => "female",
        "address" => "Kandal",
        "grade" => 7,
        "image" => "https://randomuser.me/api/portraits/women/1.jpg"
    ],
    [
        "id" => 5,
        "name" => "Visal",
        "gender" => "male",
        "address" => "Takeo",
        "grade" => 8,
        "image" => "https://randomuser.me/api/portraits/men/4.jpg"
    ],
    [
        "id" => 6,
        "name" => "Kanha",
        "gender" => "female",
        "address" => "Kampot",
        "grade" => 7,
        "image" => "https://randomuser.me/api/portraits/women/2.jpg"
    ],
    [
        "id" => 7,
        "name" => "Kiti",
        "gender" => "male",
        "address" => "Kampong Cham",
        "grade" => 8,
        "image" => "https://randomuser.me/api/portraits/men/5.jpg"
    ],
    [
        "id" => 8,
        "name" => "Sophea",
        "gender" => "female",
        "address" => "Prey Veng",
        "grade" => 7,
        "image" => "https://randomuser.me/api/portraits/women/3.jpg"
    ],
    [
        "id" => 9,
        "name" => "Rana",
        "gender" => "male",
        "address" => "Pursat",
        "grade" => 10,
        "image" => "https://randomuser.me/api/portraits/men/6.jpg"
    ],
    [
        "id" => 10,
        "name" => "Kalyan",
        "gender" => "female",
        "address" => "Kep",
        "grade" => 9,
        "image" => "https://randomuser.me/api/portraits/women/4.jpg"
    ]
];

foreach ($student as $st) {
    echo $st['name'] . '<br>';
    echo '<img src="' . $st['image'] . '" alt="">';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CJMcapSmO7SnpJef0486qhLnaZ2cle9d2Lw689A4V" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWtLSNXJ9mgli8mvw4BNC4rE9Dtrad1JIign/j3S5DLy3fe4bKZ" crossorigin="anonymous"></script>
</head>
<body>

<div class="container mt-5">
    <div class="row">

        <?php
        foreach($student as $st){
            echo '
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="'. $st['image'] .'" class="card-img-top" alt="student">
                    <div class="card-body">
                        <h5 class="card-title">'. $st['name'] .'</h5>
                        <p class="card-text">
                            ID: '. $st['id'] .'<br>
                            Gender: '. $st['gender'] .'<br>
                            Address: '. $st['address'] .'<br>
                            Grade: '. $st['grade'] .'
                        </p>
                        <a href="#" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
            ';
        }
        ?>

        <?php foreach($student as $st) { ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="<?php echo $st['image'] ?>" class="card-img-top" alt="student">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $st['name'] ?></h5>
                        <p class="card-text">
                            ID: <?php echo $st['id'] ?><br>
                            Gender: <?php echo $st['gender'] ?><br>
                            Address: <?php echo $st['address'] ?><br>
                            Grade: <?php echo $st['grade'] ?>
                        </p>
                        <a href="#" class="btn btn-primary">View Profile</a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>

</body>
</html>