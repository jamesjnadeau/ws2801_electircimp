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
i = 0;
$(document).ready(function()
{
	$('#cycle').click(function()
	{
		$(".submit_button").each(function ()
		{
			$(this).click();
		});
	});
	
	
});
</script>
END;
echo '<input id="cycle" type="button" name="submit_colors" value="Cycle" />';
echo '<hr/>';
echo '<form class="myform" id="form_'.$counter.'" method="post" action="https://api.electricimp.com/v1/ade7a74c72996f6f/30af76801eae52f3">';
$step = 100;
for($r=255; $r>0; $r-=$step)
{
	for($g=255; $g>0; $g-=$step)
	{
		for($b=255; $b>0; $b-=$step)
		{
			for($i=0; $i < 64; $i++)
			{
				echo '<input type="color" name="value['.$counter.']['.$i.']" value="#'.dechex( $r ).dechex($g).dechex($b).'" >';
				if(($i+1) % 8 == 0)
					echo '<br/>';
			}
			echo '<hr/>';
			$counter++;
		}
	}
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
               alert(data); // show response from the php script.
           }
         });

    return false; // avoid to execute the actual submit of the form.
    
END;
	echo  '" />';

echo '</form>';
echo '<hr class="space" />';

//end the html page
echo '</body>';
echo '</html>';