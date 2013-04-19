<?php

header('Access-Control-Allow-Origin: *');	
echo "<!doctype html>
<head>
    
	<meta charset='utf-8'>
    
	<meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    
	<title>LED Frames Matrix</title>";
    
    echo '<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>';
    echo '<style>
    input[type="color"]
    {
    	width: 44px;
    	height: 44px;
    	padding: 0px;
    	border: 0px;
    }	
    
    </style>';
	echo '</head>';
	echo '<body class="">';
	
	echo '<h2>Color Picker test</h2>';

if(isset($_REQUEST['colors']))
	debug_print($_REQUEST['colors']);

$colors = array(
'#FF0000',
'#00FF00',
'#0000FF',
'#FFFF00',
'#FF00FF',
'#00FFFF',
'#FFFFFF',
'#999999',
'#222222',
);
$counter = 0;
$count = count($colors);
echo <<<END
<script>
function copy_colors_down( counter)
{
	
	$('[name*="value[' + counter + ']"]').each(function() 
	{
		var myClass = $(this).attr("class");
		console.log(myClass);
		$('.'+myClass+'[name*="value[' + (counter+1) + ']"]').val($(this).val());
		//console.log($(this));
	});
}

</script>
END;
echo <<<END
<script>
$(document).ready(function() 
{

		$('input').mouseover(function(e) 
		{
			if(e.shiftKey) 
			{
				//color
				$(this).val(saved_color);
			}
			if(e.ctrlKey) 
			{
				//Ctrl+Click
			}
			if(e.altKey) 
			{
				//get color
				saved_color = $(this).val();
				console.log("saved color "+saved_color);
			}
		});
});
</script>
END;

echo '<hr/>';
echo '<form style="width:352px;" class="myform" id="color_frames" method="post" action="https://api.electricimp.com/v1/ade7a74c72996f6f/30af76801eae52f3">';

for($r=0; $r<16; $r++)
{
	$direction = 'left';
	echo '<div style="clear: both;">';
	for($i=0; $i < 64; $i++)
	{
		echo '<input style="float: '.$direction.'; " type="color" class="'.$i.'" name="value['.$counter.']['.$i.']" value="#000000" >';
		if(($i+1) % 8 == 0)
		{
			echo '</div>';
			if($direction == 'left')
				$direction = 'right';
			else
				$direction = 'left';
			
			echo '<div style="clear: both;" >';
		}
	}
	echo '</div>';
	echo '<hr/>';
	echo '<input type="button" value="▼" onclick="copy_colors_down('.$counter.')" />';
	echo '<hr/>';
	$counter++;
}

echo '<input id="submit_form_'.$counter.'" class="submit_button" type="submit" name="submit_colors" value="submit" onclick="';
	echo <<<END
	var url = 'https://api.electricimp.com/v1/ade7a74c72996f6f/30af76801eae52f3'; 

    $.ajax({
           type: 'POST',
           url: url,
           data: $('.myform').serialize(), // serializes the form's elements.
           success: function(data)
           {
               console.log(data); // show response from the php script.
           }
         });
	alert('Matrix Updated');
    return false; // avoid to execute the actual submit of the form.
    
END;
	echo  '" />';

echo '</form>';
echo '<hr class="space" />';

//end the html page
echo '</body>';
echo '</html>';
