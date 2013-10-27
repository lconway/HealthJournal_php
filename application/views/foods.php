
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Food Lists</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css"/>
    <script type="text/javascript" src="<?=base_url()?>/assets/jquery/jquery-1.10.2.js"></script>
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#allFoodsSelect').change(function() {
                //alert("Foods List selection");
                var selectValue = $('#allFoodsSelect').val();
                //alert(selectValue);
                var mealId = $('#mealId').val();
                if (mealId >= 0)
                {
                    //alert(mealId);
                } else
                {
                    //alert("no meal id");
                }
                $('.foodListButton').prop('disabled',false);
                $('.myFoodListButton').prop('disabled',true);
           });

            $('#myFoodsSelect').change(function() {
                //alert("MyFoods List selection");
                $('.foodListButton').prop('disabled',true);
                $('.myFoodListButton').prop('disabled',false);
            });
        });
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

            <form id="allFoodList" class="foodList" action="/process/food_actions" method="post">
                <label>Foods</label><br>
                <input type="text" class="inputText" placeholder="search foods"><br>
                <select id="allFoodsSelect" name="allFoods[]" multiple="multiple">
<?php
                foreach ($foods as $food)
                {
?>
                    <option><?=$food['name']?></option>
<?php
                }
?>
                </select>
                </br>
                </br>
                <input type=submit class="foodListButton" disabled name="action" value="Add To Meal"><br>
                <input type=submit class="foodListButton" disabled name="action" value="Delete From Foods List"><br>
                <input type=submit class="foodListButton" disabled name="action" value="Add To My Foods"><br>
                <input type="hidden" id="userMealId" name="userMealId" value="<?=$userMealId?>">
                <input type="hidden" name="listType" value="allFoods">
            </form>   <!-- end of allFoodList-->

            <form id="myFoodList" class="foodList" action="/process/food_actions" method="post">
                <label>My Foods</label><br>
                <input type="text" class="inputText" placeholder="search my foods"><br>
                <select id="myFoodsSelect" name="myFoods[]" multiple="multiple">
<?php
                foreach ($myFoods as $food)
                {
?>
                    <option><?=$food['name']?></option>
<?php
                }
?>
                </select>
                </br>
                </br>
                <input type=submit class="myFoodListButton" disabled name="action" value="Add To Meal"><br>
                <input type=submit class="myFoodListButton" disabled name="action" value="Delete From My Foods List">
                <input type="hidden" name="userMealId" value="<?=$userMealId?>">
               <input type="hidden" name="listType" value="myFoods">
            </form>   <!-- end of myFoodList-->
        
            <div class="clear"></div>

            <p id="foodsHorizontalLine"></p>

            <form action="/process/actions" method="post">
                <input type="hidden" name="action" value="createNewFood">
                <input type="submit" value="Create New Food">
            </form>

        </div>   <!-- end of journalPage-->


    </div>   <!-- end of wrapper-->
</body>

</html>