<!DOCTYPE html  PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<!--
Jamie Tahirkheli - 006547398
Zohaib Khan - 007673133
CS 174
-->
<html xmlns="http://www.w3.org/1999/xhtml" id="backgrnd">



<script type="text/javascript">
    document.writeln("<div>Hello good sir</div>");
    var states = new Array("CA", "AZ", "CO", "FL", "TX", "WA", "OR");

    for(var i = 0; i < states.length; i++)
    {
        document.writeln(states[i] + "<br/>");
    }

    a = [1,2,3];
    a.push(4,5,6);
    a.shift();
    a.unshift(3, 9);
    document.writeln("<br/>");

    for(var i = 0; i < a.length; i++)
    {
        document.writeln(a[i] + "<br/>");
    }

    document.writeln("<div>", doCheck(1, a ,2), "</div>")

    function doCheck()
    {
        for ( j = 0; j < arguments.length; j++)
        {
            if(arguments[j]==null || arguments[j]==undefined)
            return "contains null/empty variables";
        }
        return "all variables are valid";
    }

    function car(new_make, new_model, new_year)
    {
        this.make = new_make;
        this.model = new_model;
        this.year = new_year;
    }

    my_car = new car("toyota", "celica", "1991");

    document.writeln(my_car.make + " " + my_car.model)

    var str = "My name is Jamie and your name is NOT Jamie!"
    var pos = str.search(/Jamie/i)
    document.writeln("<br/>" + str);
    document.writeln("<br/>" + pos);
</script>
</html>


