<?php
require '../Public/utility.php';
session_start();
if($_SESSION['pseudo']=="") {
    header('location:../Forms/connexion.php');
}
?>

<?php require '../Views/header.php'; ?>

<?php 
if($_SERVER['REQUEST_METHOD'] === '$_POST') {
    $validator = new Calendrier\ValidatorEvent();
    $errors=$validator->validates($_POST);

    if (empty($errors)) {
        debug($errors);
    }
}
?>

<legendfield class="h2">Ajout d'un nouvel événement</legendfield>
<form action="" method="post" class="mt-4 form-ajout-event">
    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" class="form-control" id="name" name="name" value="TestValue">
        <?php if ($errors['name']): ?>
        <p class="help-block"><?php $errors['name']; ?></p>
        <?php endif;?>
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label">Description</label>
        <textarea type="text" class="form-control" name="desc" id="desc"></textarea>
    </div>
    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date" class="form-control" name="date" id="date" value ="2021-10-10">
    </div>
    <div class="mb-3">
        <label for="start" class="form-label">Début de l'événement</label>
        <input type="time" class="form-control" name="start" id="start" placeholder="HH:MM" value="10:00">
    </div>
    <div class="mb-3">
        <label for="end" class="form-label">fin de l'événement</label>
        <input type="time" class="form-control" name="end" id="end" placeholder="HH:MM" value="12:00">
    </div>
    <button type="submit" class="btn btn-primary mb-4">Ajouter</button>
</form>




<?php include('../Views/footer.php'); ?>