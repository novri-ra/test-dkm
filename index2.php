<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>

    <div class="container py-5">
        <h1 class="mb-4">Kalkulator Jumlah Patung yang Diperlukan</h1>

        <?php
        function neededStatues(array $heights): array
        {
            if (empty($heights)) {
                return ['count' => 0, 'needed' => []];
            }
            sort($heights);
            $min = $heights[0];
            $max = end($heights);
            $fullRange = range($min, $max);
            $needed = array_values(array_diff($fullRange, $heights));
            return ['count' => count($needed), 'needed' => $needed];
        }

        $examples = [
            [6, 2, 3, 8],
            [0, 3, 5]
        ];
        ?>

        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>
                        <center>Tinggi Patung</center>
                    </th>
                    <th>
                        <center>Jumlah Dibutuhkan</center>
                    </th>
                    <th>
                        <center>Tinggi Patung yang Dibutuhkan</center>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($examples as $idx => $patung): ?>
                    <?php $result = neededStatues($patung); ?>
                    <tr>
                        <td class="fw-bold">Contoh <?= $idx + 1 ?></td>
                        <td>[<?= implode(', ', $patung) ?>]</td>
                        <td><?= $result['count'] ?></td>
                        <td>
                            <?php if (empty($result['needed'])): ?>
                                <em>Tidak ada</em>
                            <?php else: ?>
                                [<?= implode(', ', $result['needed']) ?>]
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
    </script>
</body>

</html>