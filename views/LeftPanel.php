<?php require_once("BoxBuilder.php");?>
<div class="rowleft">
    <div class="join">
      <button name="add" value="group"  />
    </div>
    <h1>My Teams</h1>
    <?php buildBoxes(getGroupByUser($_SESSION['userid'])); ?>
  </div>