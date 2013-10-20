
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

<?php
foreach ($meals as $meal)
{
?>
<label><?=$meal->id?></label>
<label><?=$meal->name?></label>
<?php
                    foreach($meals as $meal) {
?>
            <form id="thisForm<?=$meal->id?>" class="mealForm" action="create" method="post">
                <label><?=$meal->name?></label>
                <input type="submit" value="Add Food">
                <table id="<?=$meal->name?>">
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
                    </tbody>
                </table>
            </form>
<?php
                   }
?>
<?php
}
 ?>

        <div class="clear"></div>
        <div id="journalPageHoriz">
            <div id="dateHeader">
                <button id="left_button" type="button"><</button>
                <input class="datepicker" type="text">
                <button id="right_button" type="button">></button>
            </div>
            
            <form id="mealForm1" class="mealForm" action="create" method="post">
                <label>Breakfast</label>
                <input type="submit" value="Add Food">
                <table id="breakfast">
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
                        <tr class="oddRow">
                            <td>grapenuts</td>
                            <td>1/2 cup</td>
                            <td>110</td>
                            <td>20</td>
                            <td>3</td>
                            <td>6</td>
                        </tr>
                        <tr class="evenRow">
                            <td>non-fat milk</td>
                            <td>1/2 cup</td>
                            <td>40</td>
                            <td>3</td>
                            <td>10</td>
                            <td>0</td>
                        </tr>
                       <tr class="totals">
                             <td></td>
                            <td></td>
                            <td>150</td>
                            <td>23</td>
                            <td>13</td>
                            <td>6</td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <form id="mealForm2" class="mealForm" action="" method="post">
                <label>Snack</label>
                <input type="submit" value="Add Food">
                <table id="snack">
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
                        <tr class="oddRow">
                            <td>banana</td>
                            <td>1</td>
                            <td>100</td>
                            <td>0</td>
                            <td>8</td>
                            <td>0</td>
                        </tr>
                        <tr class="evenRow">
                            <td>choc chip cookie</td>
                            <td>2</td>
                            <td>300</td>
                            <td>5</td>
                            <td>15</td>
                            <td>10</td>
                        </tr>
                       <tr class="oddRow">
                             <td>almonds</td>
                            <td>10</td>
                            <td>100</td>
                            <td>10</td>
                            <td>13</td>
                            <td>8</td>
                        </tr>
                       <tr class="totals">
                             <td></td>
                            <td></td>
                            <td>500</td>
                            <td>15</td>
                            <td>36</td>
                            <td>18</td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <form id="mealForm3" class="mealForm" action="" method="post">
                <label>Lunch</label>
                <input type="submit" value="Add Food">
                <table id="lunch">
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
                        <tr class="oddRow">
                            <td>turkey sand</td>
                            <td>1</td>
                            <td>100</td>
                            <td>0</td>
                            <td>8</td>
                            <td>0</td>
                        </tr>
                        <tr class="evenRow">
                            <td>smoothie</td>
                            <td>2</td>
                            <td>300</td>
                            <td>5</td>
                            <td>15</td>
                            <td>10</td>
                        </tr>
                        <tr class="totals">
                             <td></td>
                            <td></td>
                            <td>500</td>
                            <td>15</td>
                            <td>36</td>
                            <td>18</td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <form id="mealForm4" class="mealForm" action="" method="post">
                <label>Dinner</label>
                <input type="submit" value="Add Food">
                <table id="dinner">
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
                        <tr class="oddRow">
                            <td>salmon</td>
                            <td>4 oz</td>
                            <td>400</td>
                            <td>25</td>
                            <td>18</td>
                            <td>15</td>
                        </tr>
                        <tr class="evenRow">
                            <td>brown rice</td>
                            <td>1/2 cup</td>
                            <td>150</td>
                            <td>2</td>
                            <td>20</td>
                            <td>10</td>
                        </tr>
                       <tr class="oddRow">
                             <td>brocoli</td>
                            <td>1/2 cup</td>
                            <td>20</td>
                            <td>0</td>
                            <td>3</td>
                            <td>0</td>
                        </tr>
                        <tr class="evenRow">
                            <td>red wine</td>
                            <td>8 oz</td>
                            <td>210</td>
                            <td>0</td>
                            <td>15</td>
                            <td>0</td>
                        </tr>
                       <tr class="oddRow">
                             <td>fudgecycle</td>
                            <td>1</td>
                            <td>110</td>
                            <td>6</td>
                            <td>12</td>
                            <td>0</td>
                        </tr>
                       <tr class="totals">
                             <td></td>
                            <td></td>
                            <td>500</td>
                            <td>15</td>
                            <td>36</td>
                            <td>18</td>
                        </tr>
                    </tbody>
                </table>
            </form>
 

            </div>
        </div>
    </div>   <!-- end of wrapper-->
</body>

</html>