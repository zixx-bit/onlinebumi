<?php

    require_once $_SERVER['DOCUMENT_ROOT'].'/online store/core/init.php';
    $childID = (int)$_POST['childID'];
    $selected = sanitize($_POST['selected']);
    $childQuery = $db->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");
     ob_start(); ?>

      <option value=""></option>
      <?php while ($child = mysqli_fetch_assoc($childQuery)): ?>
        <option value="<?=$child['id']; ?>"<?=(($selected == $child['id'])?' selected':'');?>> <?=$child['category']; ?></option>
       <?php endwhile; ?>
    <?php echo ob_get_clean(); ?>
