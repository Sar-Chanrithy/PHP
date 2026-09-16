<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-sm" style="width: 100%; max-width: 420px;">
            <div class="card-body p-4">
                
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="./index.php" class="btn btn-primary">Back</a>
                    <h1 class="h5 mb-0">Create</h1>
                </div>
                
                <!-- Form -->
                <form action="./store.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter subject name" required>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <button type="submit" name="save" class="btn btn-dark w-100 py-2">Create</button>
                </form>

            </div>
        </div>
    </div>
</body>
</html>