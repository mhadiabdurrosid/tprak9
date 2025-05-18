<?php
require_once '../classes/Shoe.php';

$shoe = new Shoe();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan trim spasi
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

    // Jika tidak ada error, simpan data
    if (empty($errors)) {
        $data = [
            'brand' => $brand,
            'model' => $model,
            'size' => (int)$size,
            'price' => (float)$price,
        ];

        if ($shoe->create($data)) {
            // Redirect ke index dengan pesan sukses (bisa juga pakai session)
            header('Location: ../index.php');
            exit;
        } else {
            $errors[] = 'Gagal menyimpan data ke database.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Sepatu - Sistem Toko Sepatu</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
<div class="container">
    <h1>Tambah Sepatu Baru</h1>
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
        <input type="text" id="brand" name="brand" value="<?= htmlspecialchars($_POST['brand'] ?? '') ?>" required /><br /><br />

        <label for="model">Model:</label><br />
        <input type="text" id="model" name="model" value="<?= htmlspecialchars($_POST['model'] ?? '') ?>" required /><br /><br />

        <label for="size">Size:</label><br />
        <input type="number" id="size" name="size" value="<?= htmlspecialchars($_POST['size'] ?? '') ?>" required min="1" /><br /><br />

        <label for="price">Price (Rp):</label><br />
        <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required min="0" /><br /><br />

        <button type="submit" class="btn btn-add">Simpan</button>
    </form>
</div>
</body>
</html>
