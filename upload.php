<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireAuth();

$message = '';
$upload_path = 'assets/uploads/';
$json_file = 'assets/uploads.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate inputs
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        
        // Handle file upload
        if (empty($_FILES['image']['name'])) {
            throw new Exception('No file uploaded');
        }
        
        $file = $_FILES['image'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        // Validate file
        if (!in_array($file['type'], $allowed_types)) {
            throw new Exception('Only JPG, PNG, and GIF files are allowed');
        }
        
        if ($file['size'] > $max_size) {
            throw new Exception('File size exceeds 5MB limit');
        }
        
        // Generate safe filename
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = generateSafeFilename($title) . '.' . $ext;
        $destination = $upload_path . $filename;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new Exception('Failed to move uploaded file');
        }
        
        // Create thumbnail
        createThumbnail($destination, $upload_path . 'thumbs/' . $filename, 300, 300);
        
        // Load or initialize projects data
        $projects = [];
        if (file_exists($json_file)) {
            $projects = json_decode(file_get_contents($json_file), true) ?: [];
        }
        
        // Add new project
        $projects[] = [
            'id' => uniqid(),
            'title' => $title,
            'description' => $description,
            'category' => $category,
            'filename' => $filename,
            'date' => date('Y-m-d H:i:s'),
            'thumbnail' => 'thumbs/' . $filename
        ];
        
        // Save data
        file_put_contents($json_file, json_encode($projects, JSON_PRETTY_PRINT));
        
        $message = '<div class="alert alert-success">Project uploaded successfully!</div>';
    } catch (Exception $e) {
        $message = '<div class="alert alert-error">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Project | Threat3D</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <a href="index.html" class="logo">Threat<span>3D</span></a>
            <nav class="nav">
                <ul class="nav-list">
                    <li class="nav-item"><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="upload-main">
        <div class="container">
            <h1>Upload New Project</h1>
            <?= $message ?>
            
            <form method="POST" enctype="multipart/form-data" class="upload-form">
                <div class="form-group">
                    <label for="title">Project Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="product">Product Design</option>
                        <option value="character">Characters</option>
                        <option value="environment">Environments</option>
                        <option value="stylized">Stylized</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="image">Project Image (JPG, PNG, GIF - max 5MB)</label>
                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif" required>
                    <div class="image-preview" id="imagePreview"></div>
                </div>
                
                <button type="submit" class="btn btn-primary">Upload Project</button>
            </form>
            
            <div class="recent-uploads">
                <h2>Recent Uploads</h2>
                <div id="recentProjects" class="recent-projects-grid"></div>
            </div>
        </div>
    </main>

    <script src="js/upload.js"></script>
</body>
</html>
