<?php return function()
	{
		try
		{
			if(isset($_GET['page']) && is_numeric($_GET['page']))
			{
				$page = $_GET['page'];
			}
			else
			{
				$page = 1;
			}
			
			
			return json_decode(http::open("https://littleskin.cn/skinlib/list?filter=skin&sort=time&page={$page}",null,array('cookie: XSRF-TOKEN=eyJpdiI6IlhmQ3hWdkdWQmVrT29GQWsxakVJblE9PSIsInZhbHVlIjoib1owWGhKaHRLTUpaZEpjb3BsRW5GTkswdkRGWHUvVzRxLzdqTUVZQzVIT0xMS3A3alVrVDRBREREY0Q1U0lsMDczTTNUQ3NmV2JsRE5uNHhYU1FMQ3hxd0xBbHpqci9WanRzTGE0S3RkblpCeW5rZVZIQzdzZ0sxTUFmaytISk8iLCJtYWMiOiJjYTFlYWQ4ZjFhZTI4YjVlYTY4NjE2NzlmMDliODUyZGFlMDMxMzQxZDBlZmRiNzBjOThmZGQ4NTI5YjE1NThkIiwidGFnIjoiIn0%3D; BS_SESSION=eyJpdiI6ImwzcFFqdGQ2Z3l2dWdOalhrY3hjaVE9PSIsInZhbHVlIjoic3VKTlhSOFNKQlhkeFJ2YTBNaFUvMTBianJIcjQwS2tURzg3V2wwS3lmYmVIMnF2TERQR1gzcG45T0laZlBIYjdtK2VPMkpKdDhoOU5WSkV1SEcrMEVia2U5UnpsQnVIUjNscytSaUE0NWhRdnFCS3pGbURpcEZTT0owSnYrRE4iLCJtYWMiOiJkZmZiMDM1ODNlMDY2YmI5ZjJhYzI4OTdlM2QxNTUyOTE5M2M0ZWEyMDRlMjViZGYzMTQ2YTBlMGM2OWYwZTVkIiwidGFnIjoiIn0%3D')),true);
		}
		catch(Exception $Exception)
		{
			return Array('error' => $Exception->getMessage());
		}
	};