<?php
// THE INDEX.PHP FILE FOR PROJECT APP

// set the page title for header
$page_title = 'Project';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// grab the header
include "/var/www/m.airwave.consulting/include/header.php";
?>

<header class="content_header">
<h1>Projects <a href="new.php">Add New<i class="fa fa-plus"></i></a></h1>
</header>

<section class="content">

<!-- setup the 'project added' alert box -->
<?php if(isset($_GET['add']) || isset($_GET['delete']) || isset($_GET['update'])):
  if(isset($_GET['add']) && $_GET['add'] == 'good'){
    $message = 'Project added successfully!';
    $class = 'add';
  }
  if(isset($_GET['delete']) && $_GET['delete'] == 'good'){
    $message = 'Project deleted successfully!';
    $class = 'delete';
  }
  if(isset($_GET['update']) && $_GET['update'] == 'good'){
    $message = 'Project updated successfully!';
    $class = 'add';
  }
?>
<div id="message" class="<?php echo $class; ?>"><?php echo $message; ?><i class="fa fa-times"></i></div>

<!-- hide the box on 'x' click or after 3 seconds -->
<script type="text/javascript">
$(function(){
  setTimeout(function(){
    $('div#message').fadeOut('600',function(){
      $('div#message').remove();
    })
  }, 3000);
});
$('div#message i').click(function(){
  $('div#message').remove();
});
</script>
<?php endif; ?>

<h2>Current Projects</h2>
<!-- ongoing projects table -->
<table>
<tbody>
<tr><th>Project Name</th><th>Client</th><th>Start Date</th><th>Actions</th></tr>
<?php
$results = $db_handler->project_list($username,'current');

if($results){
  $row = '';
  foreach($results as $result){
    // convert dates to be readable
    $start_date = strtotime($result['start_date']);
    $start_date = date('j F Y', $start_date);

    if($row == ''){$row = 'class="alt"';}else{$row = '';}
    echo "<tr $row>";
    echo "<td>" . $result['name'] . "</td>";
    echo "<td>" . $result['client'] . "</td>";
    echo "<td>" . $start_date . "</td>";
    ?>
    <td class="actions"><a title='Edit Project' href='new.php?edit=<?php echo $result['id']; ?>'><i class='fa fa-pencil'></i></a><i class='delete<?php echo $result['id']; ?> fa fa-trash' title='Delete Project'></i><div class='confirm <?php echo $result['id']; ?>'><p>Are you sure you want to delete "<?php echo $result['name']; ?>"? This cannot be undone.</p><a href="https://m.airwave.consulting/project/delete.php?project=<?php echo $result['id']; ?>" class="yes">Yes</a><a class="no">Cancel</a><div></td>
    <?php
    echo "</tr>";
    ?>
      <script type="text/javascript">
        $('i.delete<?php echo $result['id']; ?>').click(function(){
          $('div.confirm.<?php echo $result['id']; ?>').css('display','block');
        });
        $('div.<?php echo $result['id']; ?> a.no').click(function(){
          $('div.confirm.<?php echo $result['id']; ?>').css('display','none');
        });
      </script>
    <?php
  }
}
else{
  echo "<tr><td>No current projects. Start one?</td></tr>";
}
?>
</tbody>
</table>

<h2>Completed Projects</h2>
<!-- ongoing projects table -->
<table>
<tbody>
<tr><th>Project Name</th><th>Client</th><th>Start Date</th><th>End Date</th><th>Actions</th></tr>
<?php
$results = $db_handler->project_list($username,'archive');

if($results){
  $row = '';
  foreach($results as $result){
    // convert dates to be readable
    $start_date = strtotime($result['start_date']);
    $start_date = date('j F Y', $start_date);
    $end_date = strtotime($result['end_date']);
    $end_date = date('j F Y', $end_date);

    if($row == ''){$row = 'class="alt"';}else{$row = '';}
    echo "<tr $row>";
    echo "<td>" . $result['name'] . "</td>";
    echo "<td>" . $result['client'] . "</td>";
    echo "<td>" . $start_date . "</td>";
    echo "<td>" . $end_date . "</td>";
    echo "<td><a title='Edit Project' href='new.php?edit=" . $result['id'] . "'><i class='fa fa-pencil'></i></a><i title='Delete Project' class='fa fa-trash'></i></td>";
    echo "</tr>";
  }
}
else{
  echo "<tr><td>No completed projects. Get something done!</td></tr>";
}
?>
</tbody>
</table>
</section>

<?php
// grab the footer
include "../include/footer.php";
?>
