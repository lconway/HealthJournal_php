
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Food Entry</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css"/>
    <script type="text/javascript" src="<?=base_url()?>/assets/jquery/jquery-1.10.2.js"></script>
    </script>
</head>

<body>
    <div id="wrapper">
        <div id="journalHeader">
            <ul id="journalLinks">
                <li><a href="journal">Journal</a></li>
                <li><a href="create">Food Entry</a></li>
                <li><a href="foods">Foods</a></li>
                <li><a href="logout">Logout</a></li>
            </ul>
        </div>
        <div id="journalPage">
           <br>
            <h2>Add New Food</h2><br>
            <br>
             <form id ="foodEntryForm" action="/process/process_create" method="post">
                <label>Food Name or Description</label>
                <input type="text" name="foodName"><br>
                <label>Food Catgory</label>
                <select name="category">
<?php
                    foreach($categories as $category) {
                        echo "<option value=".$category->id.">".$category->name."</option>";
                   }
?>
                </select><br>
                <label>Serving Size</label>
                <input type="text" name="serveSize">
                <select name="measurement">
<?php
                     foreach($measurements as $measurement) {
                        echo "<option value=".$measurement->id.">".$measurement->name."</option>";
                   }
?>
                </select><br>
                <label>Servings per container</label>
                <input type="text" name="perContainer"><br>
                <label>Calories</label>
                <input type="text" name="calories"><br>
                <label>Carbs</label>
                <input type="text" name="carbs"><br>
                <label>Fats</label>
                <input type="text" name="fats"><br>
                <label>Protein</label>
                <input type="text" name="protein"><br>
                <label>Sodium</label>
                <input type="text" name="sodium"><br>
                <label>Sugar</label>
                <input type="text" name="sugar"><br>
                <input class="journalButton" type="submit" value="Add to food journal">
           </form>
            <br>
        </div>   <!-- end of journalPage-->
</body>
    </div>   <!-- end of wrapper-->
</body>

</html>