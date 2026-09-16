<?php
header('Content-Type: application/json');
require_once 'db.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'fetch_all':
        fetchAllCourses($conn);
        break;

    case 'create':
        createCourse($conn);
        break;

    case 'get_course':
        getCourse($conn);
        break;

    case 'update':
        updateCourse($conn);
        break;

    case 'delete':
        deleteCourse($conn);
        break;

    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid action requested'
        ]);
        break;
}

// 1. Fetch all courses
function fetchAllCourses($conn) {
    $sql = "SELECT * FROM courses ORDER BY id DESC";
    $result = $conn->query($sql);

    $courses = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $courses[] = $row;
        }
    }

    echo json_encode([
        'status' => 'success',
        'data' => $courses
    ]);
}

// 2. Create course
function createCourse($conn) {
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if ($name === '' || $price === '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course name and price are required.'
        ]);
        return;
    }

    if (!is_numeric($price) || floatval($price) < 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a valid positive price.'
        ]);
        return;
    }

    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course image is required.'
        ]);
        return;
    }

    $uploadResult = handleImageUpload($_FILES['image']);
    if ($uploadResult['status'] !== 'success') {
        echo json_encode($uploadResult);
        return;
    }

    $imageName = $uploadResult['filename'];

    $stmt = $conn->prepare("INSERT INTO courses (name, price, image) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database prepare failed: ' . $conn->error
        ]);
        return;
    }

    $formattedPrice = number_format((float)$price, 2, '.', '');
    $stmt->bind_param("sds", $name, $formattedPrice, $imageName);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Course added successfully!'
        ]);
    } else {
        // Delete uploaded file if insert fails
        $filePath = __DIR__ . '/uploads/' . $imageName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to add course: ' . $stmt->error
        ]);
    }
    $stmt->close();
}

// 3. Get single course by ID for Edit Modal
function getCourse($conn) {
    $id = intval($_GET['id'] ?? $_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid course ID.'
        ]);
        return;
    }

    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'status' => 'success',
            'data' => $row
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course not found.'
        ]);
    }
    $stmt->close();
}

// 4. Update course
function updateCourse($conn) {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $price = trim($_POST['price'] ?? '');

    if ($id <= 0 || $name === '' || $price === '') {
        echo json_encode([
            'status' => 'error',
            'message' => 'All fields (ID, name, price) are required.'
        ]);
        return;
    }

    if (!is_numeric($price) || floatval($price) < 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Please enter a valid price.'
        ]);
        return;
    }

    // Check if course exists
    $stmtCheck = $conn->prepare("SELECT image FROM courses WHERE id = ?");
    $stmtCheck->bind_param("i", $id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $existing = $resultCheck->fetch_assoc();
    $stmtCheck->close();

    if (!$existing) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course not found.'
        ]);
        return;
    }

    $oldImage = $existing['image'];
    $newImage = null;

    // Check if new image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = handleImageUpload($_FILES['image']);
        if ($uploadResult['status'] !== 'success') {
            echo json_encode($uploadResult);
            return;
        }
        $newImage = $uploadResult['filename'];
    }

    $formattedPrice = number_format((float)$price, 2, '.', '');

    if ($newImage !== null) {
        // Update with new image
        $stmt = $conn->prepare("UPDATE courses SET name = ?, price = ?, image = ? WHERE id = ?");
        $stmt->bind_param("sdsi", $name, $formattedPrice, $newImage, $id);
    } else {
        // Update without changing image
        $stmt = $conn->prepare("UPDATE courses SET name = ?, price = ? WHERE id = ?");
        $stmt->bind_param("sdi", $name, $formattedPrice, $id);
    }

    if ($stmt->execute()) {
        // If image updated successfully, remove old image
        if ($newImage !== null && !empty($oldImage)) {
            $oldPath = __DIR__ . '/uploads/' . $oldImage;
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Course updated successfully!'
        ]);
    } else {
        // If failed and new image was uploaded, remove the new image
        if ($newImage !== null) {
            $newPath = __DIR__ . '/uploads/' . $newImage;
            if (file_exists($newPath)) {
                unlink($newPath);
            }
        }
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update course: ' . $stmt->error
        ]);
    }
    $stmt->close();
}

// 5. Delete course
function deleteCourse($conn) {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid course ID.'
        ]);
        return;
    }

    // Get image filename to delete
    $stmt = $conn->prepare("SELECT image FROM courses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();
    $stmt->close();

    if (!$course) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course not found.'
        ]);
        return;
    }

    // Delete record from database
    $stmtDel = $conn->prepare("DELETE FROM courses WHERE id = ?");
    $stmtDel->bind_param("i", $id);

    if ($stmtDel->execute()) {
        // Delete image file from server
        if (!empty($course['image'])) {
            $filePath = __DIR__ . '/uploads/' . $course['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        echo json_encode([
            'status' => 'success',
            'message' => 'Course deleted successfully!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to delete course: ' . $stmtDel->error
        ]);
    }
    $stmtDel->close();
}

// Helper: Image upload validation and processing
function handleImageUpload($file) {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
    $fileTmpPath = $file['tmp_name'];
    $fileName = $file['name'];
    $fileSize = $file['size'];

    // Check file size (limit to 5MB)
    if ($fileSize > 5 * 1024 * 1024) {
        return [
            'status' => 'error',
            'message' => 'Image size exceeds maximum limit of 5MB.'
        ];
    }

    $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) {
        return [
            'status' => 'error',
            'message' => 'Invalid image format. Allowed formats: ' . implode(', ', $allowedExtensions)
        ];
    }

    // Verify MIME type using getimagesize
    $imageInfo = @getimagesize($fileTmpPath);
    if ($imageInfo === false) {
        return [
            'status' => 'error',
            'message' => 'The uploaded file is not a valid image.'
        ];
    }

    // Generate unique filename
    $newFileName = 'course_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $destPath = __DIR__ . '/uploads/' . $newFileName;

    if (move_uploaded_file($fileTmpPath, $destPath)) {
        return [
            'status' => 'success',
            'filename' => $newFileName
        ];
    } else {
        return [
            'status' => 'error',
            'message' => 'Failed to save uploaded image. Check directory permissions.'
        ];
    }
}
?>
