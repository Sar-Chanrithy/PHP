<?php 
  $num = 2;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container mt-4 ">
    <table class="table">
      <thead class="table-dark text-center">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Expression</th>
          <th scope="col">Result</th>
        </tr>
      </tr>
      </thead>
      <tbody class="text-center">
        <?php 
          for($i=1;$i<=10;$i++){
            echo '
              <tr>
                <th scope="row">'.$i.'</th>
                <td>'.$num."*".$i.'</td>
                <td>'.$num*$i.'</td>
              </tr>
            ';
          }
        ?>
      </tbody>
    </table>
  </div>
</body>

</html>