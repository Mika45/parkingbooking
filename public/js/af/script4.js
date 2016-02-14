$( document ).ready(function() {
	jQuery('#datetimepickerFrom').datetimepicker({
		step:10,
		defaultTime:'12:00'
	});
	jQuery('#datetimepickerTo').datetimepicker({
		step:10,
		defaultTime:'12:00'
	});
	var currentDate = new Date();

	currentDate.setDate(currentDate.getDate() + 1);
	var setFrom = currentDate;
	
	currentDate.setDate(currentDate.getDate() + 2);
	var setTo = currentDate;
	$("#datetimepickerFrom").datetimepicker("setDate", setFrom);
	$("#datetimepickerTo").datetimepicker("setDate", setTo);
});

function changeAction( action_name )
{
	checkForm = validateForm();

	if (checkForm == true) {
		var choise = document.getElementById("pl_location");
		var location = choise.options[choise.selectedIndex].value;
		
		var d = document.getElementById("datetimepickerFrom").value;
		var from = new Date(d);
		var dfy = from.getFullYear();
		
		var dfm1 = from.getMonth() + 1;
		var dfm = ('0' + dfm1).slice(-2);
		
		var dfd = ('0' + from.getDate()).slice(-2);
		var dfh = ('0' + from.getHours()).slice(-2);
		var dfmi = ('0' + from.getMinutes()).slice(-2);

		var d = document.getElementById("datetimepickerTo").value;
		var to = new Date(d);
		var dty = to.getFullYear();

		var dtm1 = to.getMonth() + 1
		var dtm = ('0' + dtm1).slice(-2);

		var dtd = ('0' + to.getDate()).slice(-2);
		var dth = ('0' + to.getHours()).slice(-2);
		var dtmi = ('0' + to.getMinutes()).slice(-2);
		
		var urlFromD = dfy.toString().concat(dfm.toString(), dfd.toString());
		var urlFromT = dfh.toString().concat(dfmi.toString());

		var urlToD = dty.toString().concat(dtm.toString(), dtd.toString());
		var urlToT = dth.toString().concat(dtmi.toString());

	   document.pl_search.action = "https://www.parkinglegend.com/en/results/" + location + "/" + urlFromD + "/" + urlFromT + "/" + urlToD + "/" + urlToT + "/4/www.terzistravel.gr";
	} else{
		return false;
	}
   
}

function validateForm() {

    var x = document.forms["pl_form"]["datetimepickerFrom"].value;
    var y = document.forms["pl_form"]["datetimepickerTo"].value;

    if (x == null || x == "") {
        alert("Drop-Off date and time must be filled out");
        return false;
    } else if (y == null || y == "") {
        alert("Pick-Up date and time must be filled out");
        return false;
    } else {
    	return true;
    }
}