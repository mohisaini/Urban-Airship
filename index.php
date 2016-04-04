<?php

	switch($_GET['action']){
		case project:
			/* getch urban airship single project info */
			$singleProjectData = get_curl_data('https://wallet-api.urbanairship.com/v1/project/'.$_GET['id']);
			$singleProjectDataArr = json_decode($singleProjectData);
			echo <<<PROJECTINFO
				<table border="1">
				<tr><td>Id</td><td>$singleProjectDataArr->id</td></tr>
				<tr><td>Name</td><td>$singleProjectDataArr->name</td></tr>
				<tr><td>Type</td><td>$singleProjectDataArr->projectType</td></tr>
				<tr><td>Description</td> <td>$singleProjectDataArr->description</td></tr></table>
PROJECTINFO;
			echo <<<TEMPLATESLIST
	<table border="1">
		<tr>
			<td>Template Id</td>
			<td>Name</td>
			<td>Description</td>
			<td>type</td>
			<td>vendor</td>
			<td>Created</td>
			<td>Action</td>
TEMPLATESLIST;
	foreach($singleProjectDataArr->templates as $templateKey => $templateVal){
		echo <<<TEMPLATES
			<tr><td>$templateVal->id</td>
			<td>$templateVal->name</td>
			<td>$templateVal->description</td>
			<td>$templateVal->type</td>
			<td>$templateVal->vendor</td>
			<td>$templateVal->createdAt</td>
			<td><a href="index.php?action=template&id=$templateVal->id">Template Info</a>
			<a href="index.php?action=listpass&id=$templateVal->id">Get Passes</a></td></tr>
TEMPLATES;
		//print_r($projectVal);
	}
			/* echo '<pre>';
			print_r($singleProjectDataArr);
			echo '</pre>'; */
			
		break;
		
		case template:
			/* fetch template information */
			$singleTemplateData = get_curl_data('https://wallet-api.urbanairship.com/v1/template/'.$_GET['id']);
			$singleTemplateDataArr = json_decode($singleTemplateData);
			echo '<pre>';
			print_r($singleTemplateDataArr);
			echo '</pre>';
			
		break;
		
		case listpass:
			/* fetch template information */
			$passData = get_curl_data('https://wallet-api.urbanairship.com/v1/pass?templateId='.$_GET['id']);
			$singlePassDataArr = json_decode($passData);
			/* echo '<pre>';
			print_r($singlePassDataArr);
			echo '</pre>'; */

	echo <<<PASSLIST
	<table border="1">
		<tr>
			<td>Pass Id</td>
			<td>Serial Number</td>
			<td>Template Id</td>
			<td>Created</td>
			<td>Action</td>
PASSLIST;
	foreach($singlePassDataArr->passes as $passKey => $passVal){
		echo <<<SINGLEPASS
			<tr><td>$passVal->id</td>
			<td>$passVal->serialNumber</td>
			<td>$passVal->templateId</td>
			<td>$passVal->createdAt</td>
			<td><a href="index.php?action=pass&id=$passVal->id">Detail</a></td></tr>
SINGLEPASS;
	}
		echo '</table>';
			
		break;
		
		case pass:
			$singlepassData = get_curl_data('https://wallet-api.urbanairship.com/v1/pass/'.$_GET['id']);
			$singlePassArr = json_decode($singlepassData);
			echo '<a href="'.$singlePassArr->publicUrl->path.'">Download</a>';
			echo '<pre>';
			print_r($singlePassArr);
			echo '</pre>';exit;

	echo <<<PASSLIST
	<table border="1">
		<tr>
			<td>Pass Id</td>
			<td>Serial Number</td>
			<td>Template Id</td>
			<td>Created</td>
			<td>Action</td>
PASSLIST;
	foreach($singlePassDataArr->passes as $passKey => $passVal){
		echo <<<SINGLEPASS
			<tr><td>$passVal->id</td>
			<td>$passVal->serialNumber</td>
			<td>$passVal->templateId</td>
			<td>$passVal->createdAt</td>
			<td><a href="index.php?action=pass&id=$passVal->id">Detail</a></td></tr>
SINGLEPASS;
	}
		echo '</table>';
			
		break;
		
		default:
		/* getch urban airship projects */
	$projectList = get_curl_data('https://wallet-api.urbanairship.com/v1/project/');
	$projectListArr = json_decode($projectList);
	
	echo <<<PROJECTS
	<table border="1">
		<tr>
			<td>Project Id</td>
			<td>Name</td>
			<td>Description</td>
			<td>Type</td>
			<td>Created</td>
			<td>Action</td>
PROJECTS;
	foreach($projectListArr->projects as $projectKey => $projectVal){
		echo <<<SINGLEPROJECT
			<tr><td>$projectVal->id</td>
			<td>$projectVal->name</td>
			<td>$projectVal->description</td>
			<td>$projectVal->projectType</td>
			<td>$projectVal->createdAt</td>
			<td><a href="index.php?action=project&id=$projectVal->id">Detail</a></td></tr>
SINGLEPROJECT;
		//print_r($projectVal);
	}
		echo '</table>';
		break;
	}

	function get_curl_data($url){
		//open connection
		$ch = curl_init();
		//set the url, number of POST vars, POST data
		curl_setopt($ch, CURLOPT_USERPWD, 'loginemail:apikey');
		curl_setopt($ch,CURLOPT_URL, $url);
		//curl_setopt($ch,CURLOPT_POST, count($fields));
		//curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded', 'Api-Revision:1.2'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);
		//var_dump($ch);
		//execute post
		$result = curl_exec($ch);
		//close connection
		curl_close($ch);
		return $result;
	}
