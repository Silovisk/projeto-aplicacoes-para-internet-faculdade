<?php

$bookControllerPath = dirname(__DIR__).'/App/BookController.php';

if (file_exists($bookControllerPath)) {
    require $bookControllerPath;
} else {
    echo "O arquivo BookController.php não existe.\n";
    exit;
}

$book = \BookController::getInstance();
$result = $book->getBooks();

?>

<?php include 'header.php'; ?>
    <div class="container">
        <h1>Lista de Livros</h1>
        <table class="table table-striped" id="tableBooks">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Autor</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['autor']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php include 'footer.php'; ?>

<script>
    const PageScript = {
        init: () => {
            PageScript.initDataTables();
        },

        initDataTables: () => {
            $('#tableBooks').DataTable({
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese-Brasil.json'
                },
                columnDefs: [
                    { className: "text-center", "targets": "_all" }
                ]
            });
        },
    };
    
    PageScript.init();
</script>