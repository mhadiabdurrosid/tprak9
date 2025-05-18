<?php
require_once '../classes/Shoe.php';

$shoe = new Shoe();
$errors = [];
$success = '';

// Pastikan ada parameter id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../index.php');
    exit;
}

$id = (int)$_GET['id'];
$data = $shoe->getById($id);

if (!$data) {
    // Jika data tidak ditemukan, redirect ke index
    header('Location: ../index.php');
    exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = trim($_POST['brand'] ?? '');
    $model = trim($_POST['model'] ?? '');
    $size = trim($_POST['size'] ?? '');
    $price = trim($_POST['price'] ?? '');

    // Validasi sederhana
    if ($brand === '') {
        $errors[] = 'Brand wajib diisi.';
    }
    if ($model === '') {
        $errors[] = 'Model wajib diisi.';
    }
    if ($size === '' || !filter_var($size, FILTER_VALIDATE_INT)) {
        $errors[] = 'Size wajib diisi dengan angka bulat.';
    }
    if ($price === '' || !is_numeric($price)) {
        $errors[] = 'Price wajib diisi dengan angka yang benar.';
    }

    // Jika validasi lolos
    if (empty($errors)) {
        $updateData = [
            'brand' => $brand,
            'model' => $model,
            'size' => (int)$size,
            'price' => (float)$price,
        ];

        if ($shoe->update($id, $updateData)) {
            header('Location: ../index.php');
            exit;
        } else {
            $errors[] = 'Gagal mengupdate data di database.';
        }
    }
} else {
    // Jika belum submit, isi form dengan data lama
    $brand = $data['brand'];
    $model = $data['model'];
    $size = $data['size'];
    $price = $data['price'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Sepatu - Sistem Toko Sepatu</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
<div class="container">
    <h1>Edit Sepatu (ID: <?= htmlspecialchars($id) ?>)</h1>
    <a href="../index.php" class="btn btn-add" style="background-color:#34495e; margin-bottom:20px;">&larr; Kembali</a>

    <?php if (!empty($errors)): ?>
        <div style="background:#e74c3c; color:#fff; padding:12px; border-radius:5px; margin-bottom:15px;">
            <ul>
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="brand">Brand:</label><br />
        <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($brand ?? '') ?>" required /><br /><br />

        <label for="model">Model:</label><br />
        <input type="text" id="model" name="model" value="<?= htmlspecialchars($model ?? '') ?>" required /><br /><br />

        <label for="size">Size:</label><br />
        <input type="number" id="size" name="size" value="<?= htmlspecialchars($size ?? '') ?>" required min="1" /><br /><br />

        <label for="price">Price (Rp):</label><br />
        <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($price ?? '') ?>" required min="0" /><br /><br />

        <button type="submit" class="btn btn-add">Update</button>
    </form>
</div>
</body>
</html>
