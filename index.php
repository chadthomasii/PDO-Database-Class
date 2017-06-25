<?php 
require 'classes/Database.php';

$database = new Database;


//Sanatizes input of the post variable
$post = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

//If post was equal to delete
if(isset($_POST['delete']))
{
    //Get the Delete ID
    $delete_id = $_POST['delete_id'];
    
    $database->query('DELETE FROM posts WHERE id = :id');
    $database->bind(':id', $delete_id );
    $database->execute();
}


//Waits for post variable of submit, and adds to database
if(isset($post['submit']))
{
    //Set Post Vars from form
    $id = $post['id'];
    $title = $post['title'];
    $body = $post['body'];
    
    $database->query('UPDATE posts SET title = :title, body = :body WHERE id= :id');
    $database->bind(':title', $title);
    $database->bind(':body', $body);
    $database->bind(':id', $id);
    $database->execute();
 
}

//Gets all the posts
$database ->query('SELECT * FROM posts'); 
$rows = $database->resultset(); //Returned Result set

?>

<h1>Add Post</h1>
<form method="post" action="<?php $_SERVER['PHP_SELF']; //Form submits to itelf?>">
    <label>Post ID</label><br />
    <input type="text" name="id" placeholder="Specify ID"/> <br /><br />
    <label>Post Title</label><br />
    <input type="text" name="title" placeholder="Add a Title"/> <br /><br />
    <label>Post Body</label><br />
    <textarea name="body"></textarea><br /><br />
    <input type="submit" name="submit" value="Submit"/>


</form>

<h1>Posts</h1>
<div>

    <?php foreach($rows as $row) : //Loops througheach row Displays form title/body ?> 
    
        <div>
            
            <h3><?php echo $row['title']; ?></h3>
            <p><?php echo $row['body']; ?></p>
            <br />
            <form method="post" action="<?php $_SERVER['PHP_SELF']; //Form submits to itelf?>">
                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                <input type="submit" name="delete" value="Delete"/>
            </form>


        </div>
    
    <?php endforeach;?>
    
</div>