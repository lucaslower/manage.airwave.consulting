<?php
// THE VIEW.PHP FILE
// single project page

// set the page title for header
$page_title = 'Projects';

// grab the header
include "/var/www/m.airwave.consulting/include/header.php";

// get project details from db (if they got to view.php on error send em' back to index)
if(isset($_GET['project'])){
  $project_id = $_GET['project'];
  $info = $db_handler->project_info($project_id);
}
else{
  header("Location: https://m.airwave.consulting/projects/index.php");
}
?>

<header class="content_header">
<h1><?php echo $info['name']; ?> <a class="delete">Delete Project<i class="fa fa-trash"></i></a><a href="new.php?archive=<?php echo $info['id']; ?>">Archive Project<i class="fa fa-archive"></i></a><a href="new.php?edit=<?php echo $info['id']; ?>">Edit Project<i class="fa fa-pencil"></i></a></h1>
</header>

<?php
// grab the footer
include "/var/www/m.airwave.consulting/include/footer.php";
?>
