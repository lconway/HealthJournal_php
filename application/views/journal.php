
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
        // $('#dateForm').submit(function(){
        //     var dateValue = $('#journal_date').val();

        // });

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
            <form id="dateForm" action="/process/set_date" method="post">
                <button id="left_button" type="button"><</button>
                <input id="journal_date" name="journal_date" class="datepicker" 
                    type="text" value="<?=$this->session->userdata('journal_date')?>">
                <button id="right_button" type="button">></button>
                <input type="submit" value="Show journal for date">
            </form>
            

<?php
            //echo "user id is " . $this->session->userdata('user_id') . "<br>";
            foreach($meals as $meal) {  
                // echo "<pre>";
                // var_dump($meal);
                // echo "</pre>";
              
                //echo "meal id is " . $meal['id . "<br>";
                $this->session->set_userdata('meal_id', $meal['id']);
?>
            <form id="thisForm<?=$meal['id']?>" class="mealForm" action="/process/foods" method="post">
                <label><?=$meal['name']?></label>
                <input type="submit" value="Add Food">
                <input type="hidden" name="mealId" value="<?=$meal['id']?>">
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
                    $row = 1;
                    foreach($meal['myFoods'] as $food) {
                        $rowType = $row % 2 ? "oddRow" : "evenRow";
 ?>                      
                        <tr class = <?=$rowType?>>
                            <td><?=$food['foodName']?></td>
                            <td><?=$food['serving_size']?> <?=$food['measureName']?></td>
                            <td><?=$food['calories']?></td>
                            <td><?=$food['protein']?></td>
                            <td><?=$food['carbs']?></td>
                            <td><?=$food['fat']?></td>
                        </tr>
<?php
                        $row++;
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