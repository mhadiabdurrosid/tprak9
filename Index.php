<?php
require_once 'classes/Shoe.php';
$shoe = new Shoe();
$data = $shoe->getAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sistem Toko Sepatu</title>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>
<div class="container">
    <h1>Daftar Sepatu</h1>
    <a href="pages/add.php" class="btn btn-add">Tambah Sepatu</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Size</th>
                <th>Price (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data) > 0): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td data-label="ID"><?= htmlspecialchars($row['id']) ?></td>
                        <td data-label="Brand"><?= htmlspecialchars($row['brand']) ?></td>
                        <td data-label="Model"><?= htmlspecialchars($row['model']) ?></td>
                        <td data-label="Size"><?= htmlspecialchars($row['size']) ?></td>
                        <td data-label="Price"><?= number_format($row['price'], 2, ',', '.') ?></td>
                        <td data-label="Aksi">
                            <a href="pages/edit.php?id=<?= $row['id'] ?>" class="btn btn-edit">Ubah</a>
                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-delete">Hapus</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">Tidak ada data.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<script src="assets/js/main.js"></script>
</body>
</html>
