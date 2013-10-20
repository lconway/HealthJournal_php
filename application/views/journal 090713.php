
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Journal</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css"/>
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/ui-lightness/jquery-ui.css" type="text/css" media="all" />  
    <link href="<?=base_url()?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="<?=base_url()?>/assets/jquery/jquery-1.10.2.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>   
    <script type="text/javascript">

    $(document).ready(function(){

        $('.datepicker').datepicker();

    });
    </script>
</head>

<body>
    <div id="wrapper">
        <div id="journalHeader">
            <h1 id="journalH1">Brooklynn's Food Journal</h1>
            <ul id="journalLinks">
                <li><a href="journal">Journal</a></li>
                <li><a href="create">Food Entry</a></li>
                <li><a href="foods">Foods</a></li>
                <li><a href="logout">Logout</a></li>
            </ul>
        </div>


        <div class="clear"></div>
        <div id="journalPageHoriz">
            <div id="dateHeader">
                <button id="left_button" type="button"><</button>
                <input class="datepicker" type="text">
                <button id="right_button" type="button">></button>
            </div>
            

<?php
            //echo "user id is " . $this->session->userdata('user_id') . "<br>";
            foreach($meals as $meal) {  
                // echo "<pre>";
                // var_dump($meal);
                // echo "</pre>";
              
                //echo "meal id is " . $meal['id . "<br>";
                $this->session->set_userdata('meal_id', $meal['id']);
?>
            <form id="thisForm<?=$meal['id']?>" class="mealForm" action="create" method="post">
                <label><?=$meal['name']?></label>
                <input type="submit" value="Add Food">
                <table id="<?=$meal['name']?>">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Calories</th>
                            <th>Protein</th>
                            <th>Carbs</th>
                            <th>Fats</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
                    
                    foreach($meal['items'] as $items) {
                        // echo "<pre>";
                        // var_dump($items);
                        // echo "</pre>";
                        // $rowType = $row % 2 ? "oddRow" : "evenRow";
 ?>                      
                        <tr>
                            <td><?php
                                //var_dump($food);
                                ?></td>
                          <!--   <td><?=$food['serving_size']?> <?=$food['measureName']?></td>
                            <td><?=$food['calories']?></td>
                            <td><?=$food['protein']?></td>
                            <td><?=$food['carbs']?></td>
                            <td><?=$food['fat']?></td> -->
                        </tr>
<?php
                   }
               //}
?>
                    </tbody>
                </table>
            </form>
<?php
            }
 ?>




            
            
 

            </div>
        </div>
    </div>   <!-- end of wrapper-->
</body>

</html>