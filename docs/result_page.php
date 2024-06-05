

<?php

   //logic goes here
  include "db_connection.php";

 //Get the current date to use for the order information
 $tm = time(); //current date/time
 $milliseconds = floor(microtime(true) * 1000); // current time for a millisecond format

 $total = 0.00; //total so far of cost
 $local = 0; // is the order local?
date_default_timezone_set('America/Chicago'); //change to my timezone because I like seeing it better
  //Store the warehouse, district, and customer data from the order form
  $dID = $_POST['D_ID'];
  $wID = $_POST['W_ID'];
  $cID = $_POST['C_ID'];

  $ourw = true;// is the warehouse valid?
  $ourd = true; //is the district valid
  $ourc = true;  //is the customer valid

  $iPassed = true; //item id invalid?
  $wPassed = true; //warehouse passed
  //Query and results to use for the warehouse information
  $warehouseSQL = "SELECT * FROM WAREHOUSE WHERE W_ID = $wID";
  $warehouseResult = mysqli_query($mysqli, $warehouseSQL);
  $warehouseRow = mysqli_fetch_assoc($warehouseResult) or $ourw = false; //Validate warehouse ID exists
  if(!$ourw){
   goto end;
  }

  //Query and results to use for the district information
  $districtSQL = "SELECT * FROM DISTRICT WHERE D_ID = $dID";
  $districtResult = mysqli_query($mysqli, $districtSQL); 
  $districtRow = mysqli_fetch_assoc($districtResult) or $ourd = false;; //Validate district ID exists
  if(!$ourd){
   goto end;
  }
  //Query and results to use for the customer information
  $customerSQL = "SELECT * FROM CUSTOMER WHERE C_ID = $cID";
  $customerResult = mysqli_query($mysqli, $customerSQL);
  $customerRow = mysqli_fetch_assoc($customerResult) or $ourc = false; //Validate customer ID exists
  if(!$ourc){
   goto end;
  }


   $array = $_POST;
   $rowcount = ((sizeof($array)) - 3) /3; // subtract for 3 above then divide by 3 because each row has 3 columns
   //go through all orderlines and check if local order or not
    for($x =1;$x<=$rowcount;$x++){
       if($array['OL_SUPPLY_W_ID'.$x] != $wID){
         $local = 1;
       }
    }
   //Add orderr row into tables. Entry date will have to be generated. can't do first since we can't check if local till for loop
   $mysqli -> autocommit(FALSE); // turn of autocommit incase failure
  //get D_NEXT_O_ID
  $O_IDq = "SELECT D_NEXT_O_ID FROM DISTRICT WHERE D_ID = $dID and D_W_ID = $wID";//get next order number
  $O_ID = mysqli_query($mysqli, $O_IDq );
  $D_NEXT_O_ID = mysqli_fetch_assoc($O_ID);// get the next order number for this district and warehouse
  $D_NEXT_O_ID = $D_NEXT_O_ID['D_NEXT_O_ID']; //set variable to it since we use it multiple times
  $UPDATEQ = "UPDATE DISTRICT SET D_NEXT_O_ID = D_NEXT_O_ID  + 1 WHERE D_ID = $dID AND D_W_ID = $wID";//INCREASE THE NEXT ID
  $UPDATER = mysqli_query($mysqli,$UPDATEQ);
  // insert into orderr
  $ORDERRSQL = "INSERT INTO ORDERR (O_ID,O_D_ID,O_W_ID,O_C_ID,O_ENTRY_D,O_CARRIER_ID,O_OL_CNT,O_ALL_LOCAL)	
  VALUES ($D_NEXT_O_ID,$dID,$wID,$cID,CURDATE(),NULL,$rowcount,$local)";
  $ORDDERRR = mysqli_query($mysqli,$ORDERRSQL);
  //insert into new order
  $NEWORSQL = "INSERT INTO NEW_ORDER (NO_O_ID,NO_D_ID,NO_W_ID) VALUES($D_NEXT_O_ID,$dID,$wID)";
  $NEWORDERR = mysqli_query($mysqli,$NEWORSQL);
  
  //go through all order lines and create orderline for database
  $array = $_POST;
  $rowcount = ((sizeof($array)) - 3) /3; // subtract for 3 above then divide by 3 because each row has 3 columns
  //go through all orderlines
  try{
   for($x =1;$x<=$rowcount;$x++){
      $I_IDq = "SELECT * FROM ITEM WHERE I_ID =".$array['OL_I_ID'.$x]; ///get item from current id line
      $I_ID = mysqli_query($mysqli, $I_IDq );//using OL_ID
      $I_ROW = mysqli_fetch_assoc($I_ID);//GET THE ITEM ROW
      if($I_ID->num_rows ==0){ // if the item number isn't valid roll back all transactions done to database like nothing happened
         $iPassed= false;
         $mysqli->rollback();
         break;
         //rollback
      }else{ // it's found
         $price = $I_ROW['I_PRICE']; //item price
         $name = $I_ROW['I_NAME']; //item name
         $data = $I_ROW['I_DATA']; //item data
      }
      $W_IDq = "SELECT * FROM WAREHOUSE WHERE W_ID =".$array['OL_SUPPLY_W_ID'.$x]; ///check current warehouse is valid
      $W_ID = mysqli_query($mysqli, $W_IDq );//using OL_ID
      $W_ROW = mysqli_fetch_assoc($W_ID);//GET THE ITEM ROW for warehouse 
      if($W_ID->num_rows ==0){ // if the item number isn't valid roll back all transactions done to database like nothing happened
         $wPassed= false;
         $mysqli->rollback();
         break;
         //rollback
      }
      $S_IDq = "SELECT * FROM STOCK WHERE S_I_ID =".$array['OL_I_ID'.$x]." and S_W_ID = ".$array['OL_SUPPLY_W_ID'.$x]; ///checkl stock of that item in supply warehouse it has to exist because it passed item check already stock is full of items that exist
      $S_ID = mysqli_query($mysqli, $S_IDq );//using OL_ID
      $S_ROW = mysqli_fetch_assoc($S_ID);//GET THE ITEM ROW
      $stockq = $S_ROW['S_QUANTITY']; //how many of that item are in stock
      $stockd = $S_ROW['S_DATA']; //stock data
      if($dID <10 ){ //not district ten we need to do this because districts don't have a 0 infront of them 
         $stockdt = $S_ROW['S_DIST_0'.$dID]; // stock district number equals this 
      }else{
         $stockdt = $S_ROW['S_DIST_'.$dID];// just 10
      }
      if($stockq > $array['OL_QUANTITY'.$x] + 10){ // if the stockq is greater then how many being order +10
         $STOCKUPDATEq = "UPDATE STOCK SET S_QUANTITY = S_QUANTITY - ".$array['OL_QUANTITY'.$x]." WHERE ". $I_ROW['I_ID']. " = ".$S_ROW['S_I_ID']." AND S_W_ID = ".$array['OL_SUPPLY_W_ID'.$x];//REMOVE THAT MUCH FROM THAT STOCK HOPEFULLY  
         $UPDATERsq = mysqli_query($mysqli,$STOCKUPDATEq);
      }else{// if not subtract then add 91
         $STOCKUPDATEq = "UPDATE STOCK SET S_QUANTITY = (S_QUANTITY - ".$array['OL_QUANTITY'.$x].") + 91 WHERE ". $I_ROW['I_ID']. " = ".$S_ROW['S_I_ID']." AND S_W_ID = ".$array['OL_SUPPLY_W_ID'.$x];//REMOVE THAT MUCH FROM THAT STOCK and then add 91  
         $UPDATERsq = mysqli_query($mysqli,$STOCKUPDATEq);
      }
      $STOCKUPDATEytd = "UPDATE STOCK SET S_YTD = (S_YTD + ".$array['OL_QUANTITY'.$x].") WHERE ". $I_ROW['I_ID']. " = ".$S_ROW['S_I_ID']." AND S_W_ID = ".$array['OL_SUPPLY_W_ID'.$x];//ADD TO THE YTD  
      $UPDATERytd = mysqli_query($mysqli,$STOCKUPDATEytd);
      $STOCKUPDATEoc = "UPDATE STOCK SET S_ORDER_CNT = S_ORDER_CNT + 1 WHERE ". $I_ROW['I_ID']. " = ".$S_ROW['S_I_ID']." AND S_W_ID = ".$array['OL_SUPPLY_W_ID'.$x];//ADD TO THE YTD  
      $UPDATERoc = mysqli_query($mysqli,$STOCKUPDATEoc );
      if($array['OL_SUPPLY_W_ID'.$x] != $wID){//not from same warehouse
         $STOCKUPDATEoc = "UPDATE STOCK SET S_REMOTE_CNT = S_REMOTE_CNT + 1 WHERE ". $I_ROW['I_ID']. " = ".$S_ROW['S_I_ID']." AND S_W_ID = ".$array['OL_SUPPLY_W_ID'.$x];//ADD TO THE REMOTE COUNT
         $UPDATERoc = mysqli_query($mysqli,$STOCKUPDATEoc );
      }
      if(str_contains($data,"ORIGINAL") && str_contains($stockd,"ORIGINAL")){
         $ITEMDATA = "UPDATE ITEM SET I_DATA = 'B' WHERE I_ID =".$array['OL_I_ID'.$x] ;//change the brand generic data think it's the item data
         $UPDATEIDATA = mysqli_query($mysqli, $ITEMDATA );
      }else{
         $ITEMDATA = "UPDATE ITEM SET I_DATA = 'G'  WHERE I_ID =".$array['OL_I_ID'.$x]  ;//change the brand generic data think it's the item data
         $UPDATEIDATA = mysqli_query($mysqli, $ITEMDATA );
         
      }
      $OLAMOUNT = $array['OL_QUANTITY'.$x] * $price; //orderline total
      $total = $total + $OLAMOUNT; //increase total variable for later 
      $ORDERLINESQL = "INSERT INTO ORDER_LINE 
      (OL_O_ID,OL_D_ID,OL_W_ID,OL_NUMBER,OL_I_ID,OL_SUPPLY_W_ID,OL_DELIVERY_D,OL_QUANTITY,OL_AMOUNT,OL_DIST_INFO)	
      VALUES ($D_NEXT_O_ID,$dID,	$wID,$x,".$array['OL_I_ID'.$x].",".$array['OL_SUPPLY_W_ID'.$x].",NULL,".$array['OL_QUANTITY'.$x].",".$OLAMOUNT.","."'$stockdt'".")";
      $ORDDERLINE = mysqli_query($mysqli,$ORDERLINESQL ); //INSERT ORDERLINE INTO ORDER LINE TABLE
   }
}catch(Exception $e){
   echo("exception: ". $e->getMessage());
}


   $total = round($total *(1-$customerRow['C_DISCOUNT']) * (1+$warehouseRow['W_TAX'] +$districtRow['D_TAX']),2); //end total with all tax and discount

   if($iPassed && $ourw && $ourd && $ourc && $wPassed){//if passed commit
      $mysqli->commit();
      $mysqli -> autocommit(TRUE);
   }
   $endtime =floor(microtime(true) * 1000); //time it took after  everything to query and commit
   $totaltime = round($endtime - $milliseconds,2); // time it took total miliseconds
?>


<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="resultStyles.css">
      <link rel="stylesheet" href="normalize.css">
      <link rel="stylesheet" href="styles.css">
      <title>Results</title>
   </head>
   <body>
      <h1> New Order Results </h1>

      <table id="top_table">
         <tbody>
            <tr>
               <td> Time:<?php echo "{$totaltime}"."ms"; ?> </td>
               <td>   </td>
               <td colspan="2"> New Order </td>
            </tr>
            <tr>
               <td> Warehouse: 
                  <?php echo "{$warehouseRow['W_ID']}";  ?>  
               </td> 
               <td> District: <?php echo "{$districtRow['D_ID']}"; ?> </td>
               <td colspan="2"> Date: <?php echo date("m-d-Y H:i:s", $tm); ?> </td>
            </tr>
            <tr>
               <td> Customer: <?php echo "{$customerRow['C_ID']}"; ?> </td>
               <td> Name: <?php echo "{$customerRow['C_FIRST']}" . " " . "{$customerRow['C_LAST']}"; ?> </td>
               <td> Credit: <?php echo "{$customerRow['C_CREDIT']}" ?> </td>
               <td> Disc: <?php echo "{$customerRow['C_DISCOUNT']}" ?> </td>
            </tr>
            <tr>
               <td> Order Number:<?php echo "{$D_NEXT_O_ID}"; ?></td>
               <td> Number of lines: <?php echo $rowcount; ?></td>
               <td> W_tax: <?php echo "{$warehouseRow['W_TAX']}"; ?> </td>
               <td> D_tax: <?php echo "{$districtRow['D_TAX']}"; ?> </td>
            </tr>
         </tbody>
      </table>
<?php
end:
if($iPassed && $ourw && $ourd && $ourc && $wPassed){ //check fail conditions
echo"<table border='1'>";
//TEMP TABLE OF ALL COMBINED attributes needed
$temptable = "SELECT ORDER_LINE.OL_W_ID,ORDER_LINE.OL_I_ID,ITEM.I_NAME,ORDER_LINE.OL_QUANTITY,STOCK.S_QUANTITY,ITEM.I_DATA,ITEM.I_PRICE,ORDER_LINE.OL_AMOUNT 
FROM((ORDER_LINE INNER JOIN ITEM ON ORDER_LINE.OL_I_ID = ITEM.I_ID) 
INNER JOIN STOCK ON ORDER_LINE.OL_I_ID = STOCK.S_I_ID AND ORDER_LINE.OL_W_ID = STOCK.S_W_ID)
WHERE ORDER_LINE.OL_O_ID = $D_NEXT_O_ID AND ORDER_LINE.OL_D_ID = ". $dID." AND ORDER_LINE.OL_W_ID = $wID;";
$table = mysqli_query($mysqli,$temptable);
//display all order_lines of current transaction in html table
echo"<tr><td>Supp_W</td><td>Item_id</td><td>Item_Name</td><td>qty</td><td>Stock</td><td>B/G</td><td>Price</td><td>Amount</td></tr>";
 while($row = mysqli_fetch_assoc($table)){
   echo"<tr><td>{$row['OL_W_ID']}</td><td>{$row['OL_I_ID']}</td><td>{$row['I_NAME']}</td><td>{$row['OL_QUANTITY']}</td><td>{$row['S_QUANTITY']}</td><td>{$row['I_DATA']}<td>{$row['I_PRICE']}</td><td>{$row['OL_AMOUNT']}</td></tr>";
 }
 echo"<tr><td>Execution status succesfull!</td><td>Total: $total</tr>";
 echo"</table>";

}else{//if failed we still show top just not bottom
   
      echo"<table border='1'>";
      if(!$ourw){echo"<tr><td> Warehouse ID: Your warehouse isn't valid</td></tr>";}
      if(!$ourd){echo"<tr><td> District ID: Your district id isn't valid </td></tr>";}
      if(!$ourc){echo"<tr><td> Customer ID: Your customer id isn't valid </td></tr>";}
      if(!$iPassed){echo"<tr><td> Row Item ID: ID in row invalid </td></tr><tr>";}
      if(!$wPassed){echo"<td> Supply Warehouse ID:Supply warehouse isn't valid </td></tr>";}
echo"</table>";
}
?>
      <a href="index.php">Return to homepage</a>
         <p> <?php 
          
            ?> 
         </p>
   </body>
</html>
