function addRow() {

    var table = document.getElementById('tbl_id'); // targets the table we are working on

    var rowCount = table.rows.length; //length of the table


    if(rowCount > 15){ //if the row count is greater than 15 we can't add anymore rows because that is the max number of rows
        return; //exits the function
     }

    var row = table.insertRow(rowCount); //the row of the table we are working on

    var cell0 = row.insertCell(0); //creates a cell in a table to be filled by an element
    var cell1 = row.insertCell(1); //creates a cell in a table to be filled by an element
    var cell2 = row.insertCell(2); //creates a cell in a table to be filled by an element

    var element0 = document.createElement("input"); //creates an HTML element to be put into the cell for the ID
    element0.type = "number"; //defines type of input
    element0.name = "OL_I_ID" + rowCount; // sets the name to OL_I_ID used for database variables
    cell0.appendChild(element0); //adds it to the cell of the table 

    var element1 = document.createElement("input"); //creates an HTML element to be put into the cell for the Warehouse Number
    element1.type = "number"; //defines type of input
    element1.name = "OL_SUPPLY_W_ID" + rowCount; // sets the name to OL_SUPPLY_W_ID used for database variables
    cell1.appendChild(element1); //adds it to the cell of the table 

    var element2 = document.createElement("input"); //creates an HTML element to be put into the cell for the Quantity
    element2.type = "number"; //defines type of input
    element2.name = "OL_QUANTITY" + rowCount; // sets the name to OL_QUANTITY used for database variables
    cell2.appendChild(element2); //adds it to the cell of the table 

    if(rowCount == 15){ //if the row count is equal to 15 we can't add anymore rows because that is the max number of rows
        document.getElementById('add').style.visibility='hidden'; //hides the button so we can't add any more rows to the table
     }

}

function deleteRow(tableID) {

    try {
        var table = document.getElementById(tableID); //targets the table we are working on

        var rowCount = table.rows.length; //length of the table

        if (rowCount > 6) { //only deletes bottom row if the table has more than 5 entries.
            document.getElementById('add').style.visibility='visible'; //sets add button to visible because we can add more rows
            table.deleteRow(rowCount - 1); //deletes the bottom most row
        } else {
            alert("Must have a min of 5 rows.")  //can't delete over 5 because 5 is the minimum
        }
    } 
    catch (e) {
        alert(e);
    }
}

function getFocus(e) {
    if (e.type == "focus") { //if there is no text 
        e.target.classList.add('highlight'); //add highlight 
    }
    else if (e.type == "blur") { //if there is text 
        e.target.classList.remove('highlight'); //remove highlight
    }
}


window.addEventListener("load", function () { // on load

    var fields = document.querySelectorAll('.hilightable'); //select all elements with hilightable

    for (i = 0; i < fields.length; i++) { // for fields in the table
        fields[i].addEventListener("focus", getFocus); //get focus
        fields[i].addEventListener("blur", getFocus); //get blur
    }

    document.getElementById("mainForm").addEventListener('submit', function(e){ //when form is submitted

        var requiredThings = document.querySelectorAll('.required'); //get all required fields
        
        for(thing of requiredThings){ // for every element in the list of required things
            const text = thing.value; //get the text of the current element

            if (text == ""){ // if there is no text in the element
                e.preventDefault(); //prevents the form from being submitted
                thing.classList.add('error'); //adds error outline
            }
            else{ // if all elements have text in them
                thing.classList.remove('error'); //remove the error outline and submit the form
            }
        }
    })

})

