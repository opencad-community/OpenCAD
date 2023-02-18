<?= $doctype ?>
<html>

<head>
    <meta charset="UTF-8">
    <title>
        <?= $title ?>
    </title>
</head>

<body>
    <h1>Welcome to my page!</h1>
    <p>This is a sample page created using HTML.</p>

    <?php
    
    use Opencad\App\Forms\DynamicForm;

    $form = new DynamicForm('/');
    $form->addField('name', 'text');
    $form->addField('email', 'text');
    $form->addField('gender', 'select', ['Male', 'Female']);
    $form->addField('agree', 'checkbox');

    $form->render();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = $form->handleData();
        // handle the form data here
        var_dump($data);
    }

    ?>
</body>

</html>