<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<head>
	
	<?php 
	include ('partials/connect.php'); 
	include ('partials/header.php'); 
	$param = $_GET['ID'];
	
	$sql1_result=select_from_land_CADGENNO($param);
	if ($sql1_result->num_rows > 0) {
		$sql1_result_data=$sql1_result->fetch_assoc();
		} else {
		echo "0 results";
		}
			
	$sql2_result=select_from_parcel_CADGENNO($param);
	if ($sql2_result->num_rows > 0) {
		$sql2_result_data=$sql2_result->fetch_assoc();
		} else {
		echo "0 results";
		}
	//print_r($sql2_result_data);
			
	$sql3_result=select_from_building_CADGENNO($param);
	if ($sql3_result->num_rows > 0) {
		$sql3_result_data=$sql3_result->fetch_assoc();
		} else {
		//echo "0 results";
		}

	$sql4_result=select_from_address_CADGENNO($param);
	if ($sql4_result->num_rows > 0) {
		$sql4_result_data=$sql4_result->fetch_assoc();
		} else {
		echo "0 results";
		}

	?>

	<title>DATE <?= $sql1_result_data["CADGENNO"] ?></title>
	
	<style type="text/css">
	h2 {
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		font-size: 12pt;
	}
	h1 {
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		font-size: 16pt;
	}
	p {
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		font-size: 12pt;
		margin: 0pt;
	}
	li {
		display: block;
	}
	#l1 {
		padding-left: 0pt;
		counter-reset: c1 1;
	}
	#l1>li>*:first-child:before {
		counter-increment: c1;
		content: counter(c1, upper-latin)". ";
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		font-size: 11pt;
	}
	#l1>li:first-child>*:first-child:before {
		counter-increment: c1 0;
	}
	#l2 {
		padding-left: 0pt;
		counter-reset: d1 1;
	}
	#l2>li>*:first-child:before {
		counter-increment: d1;
		content: counter(d1, decimal)") ";
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: normal;
		text-decoration: none;
		font-size: 9pt;
	}
	#l2>li:first-child>*:first-child:before {
		counter-increment: d1 0;
	}
	#l3 {
		padding-left: 0pt;
		counter-reset: e1 1;
	}
	#l3>li>*:first-child:before {
		counter-increment: e1;
		content: counter(e1, decimal)") ";
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: normal;
		text-decoration: none;
		font-size: 9pt;
	}
	#l3>li:first-child>*:first-child:before {
		counter-increment: e1 0;
	}
	#l4 {
		padding-left: 0pt;
		counter-reset: f1 1;
	}
	#l4>li>*:first-child:before {
		counter-increment: f1;
		content: counter(f1, decimal)") ";
		color: black;
		font-family: "Trebuchet MS", sans-serif;
		font-style: normal;
		font-weight: normal;
		text-decoration: none;
		font-size: 9pt;
	}
	#l4>li:first-child>*:first-child:before {
		counter-increment: f1 0;
	}
	table,
	tbody {
		vertical-align: top;
		overflow: visible;
	}
	</style>
	</head>

	<body>
	<div class="container">
	<p><br></p>
	<p style="text-align: right;">Comuna/Oraş/Municipiu: Cernat</p>
	<p><br></p>
	<p style="text-align: center;">DATE DESPRE IMOBILUL NR. <?= $sql1_result_data["CADGENNO"] ?></p>
	<p><br></p>
	<p style="text-align: center;">Sector cadastral: <?= $sql1_result_data["CADSECTOR"] ?></p>
	<p><br></p>
	<p><br></p>
	<h1 style="text-align: center;">A. Partea I. Descrierea imobilului</h1>
	<p style="text-align: right;">Identificator electronic: <?= $sql1_result_data["E2IDENTIFIER"] ?></p>
	<p style="text-align: right;">Nr. CF vechi: <?= $sql1_result_data["PAPERLBNO"] ?></p>
	<p style="text-align: right;">Nr. CAD vechi: <?= $sql1_result_data["PAPERCADNO"] ?></p>
	<p style="text-align: right;">Nr. topografic: <?= $sql1_result_data["TOPONO"] ?></p>
	<h2 style="text-align: left;">TEREN <span>
	<?php 
	$sql5 = "SELECT distinct LANDID, INTRAVILAN FROM parcel WHERE LANDID in (select LANDID from land WHERE CADGENNO=" . $param . ")";
	$result5 = $conn->query($sql5);
	$sql5_result_data=$result5->fetch_assoc();
	if ($result5->num_rows == 1) {
	echo $sql5_result_data["INTRAVILAN"] =='true' ? 'Intravilan' :  'Extravilan'; 
	}
	?>
	</span></h2>
	<h2 style="text-align: left;">Adresa: Loc. Cernat, <?= strtolower($sql4_result_data["STREETTYPE"]); ?>
						<?= $sql4_result_data["STREETNAME"] . ',' ?>
						<?= 'nr:'.$sql4_result_data["POSTALNUMBER"] . ',' ?>
						<?= $sql4_result_data["BLOCK"] == '0' ? '' : $sql4_result_data["BLOCK"]. ',' ?>
						<?= $sql4_result_data["ENTRY"] == '0' ? '' : $sql4_result_data["ENTRY"]. ',' ?>
						<?= $sql4_result_data["FLOOR"] == '0' ? '' : $sql4_result_data["FLOOR"]. ',' ?>
						<?= $sql4_result_data["APNO"] == '0' ? '' : $sql4_result_data["APNO"]?>, Jud. Covasna</span></h2>
	<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
		<tbody><tr style="height:22pt">
			<td style="width:16pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s4" style="padding-left: 1pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Nr. Crt</p>
					</td>
					<td style="width:70pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s4" style="padding-left: 4pt;text-indent: 3pt;line-height: 11pt;text-align: left;">Nr cadastral Nr. topografic</p>
					</td>
					<td style="width:90pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s4" style="padding-top: 5pt;padding-left: 7pt;padding-right: 6pt;text-indent: 0pt;text-align: center;">Suprafaţa* (mp)</p>
					</td>
					<td style="width:324pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s4" style="padding-top: 5pt;padding-left: 115pt;padding-right: 114pt;text-indent: 0pt;text-align: center;">Observaţii / Referinţe</p>
					</td>
				</tr>
				<tr style="height:16pt">
					<td style="width:16pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">A1</p>
					</td>
					<td style="width:70pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-top: 2pt;padding-left: 22pt;text-indent: 0pt;text-align: left;"><?= $sql1_result_data["E2IDENTIFIER"] ?></p>
					</td>
					<td style="width:90pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-top: 2pt;padding-left: 33pt;padding-right: 32pt;text-indent: 0pt;text-align: center;"><?= $sql1_result_data["MEASUREDAREA"] ?></p>
					</td>
					<td style="width:324pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;text-align: left;"><?= $sql1_result_data["ENCLOSED_RES"]=='true' ? 'Teren imprejmuit,' :  'Teren neimprejmuit,'; ?> <?= $sql1_result_data["NOTES"] ?></p>
					</td>
				</tr>
	</tbody></table>
	<p><br></p>
	<p><br></p>	

	<h1 style="padding-top: 4pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">Parcele</h1>
	<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
		<tbody><tr style="height:23pt">
			<td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 5pt;padding-right: 1pt;text-indent: 0pt;text-align: right;">Crt</p>
			</td>
			<td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-left: 7pt;text-indent: -2pt;text-align: left;">Categorie folosință</p>
			</td>
			<td style="width:23pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="text-indent: 0pt;text-align: left;">Intra vilan</p>
			</td>
			<td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-left: 16pt;text-indent: -11pt;text-align: left;">Suprafaţa (mp)</p>
			</td>
			<td style="width:67pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 5pt;padding-left: 20pt;padding-right: 21pt;text-indent: 0pt;text-align: center;">Titlu</p>
			</td>
			<td style="width:67pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 5pt;padding-left: 20pt;padding-right: 21pt;text-indent: 0pt;text-align: center;">Tarla</p>
			</td>
			<td style="width:62pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 5pt;padding-left: 13pt;padding-right: 13pt;text-indent: 0pt;text-align: center;">Parcelă</p>
			</td>
			<td style="width:63pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 5pt;padding-left: 12pt;padding-right: 11pt;text-indent: 0pt;text-align: center;">Nr. topo</p>
			</td>
			<td style="width:160pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 5pt;padding-left: 31pt;text-indent: 0pt;text-align: left;">Observaţii / Referinţe</p>
			</td>
		</tr>
		<?php 
		$sql = "SELECT * FROM parcel WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ") order by NUMBER";
		$result = $conn->query($sql);
		while($row=mysqli_fetch_assoc($result)){ 
		?>
		<tr style="height:20pt">
			<td style="width:17pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;padding-right: 4pt;text-indent: 0pt;text-align: right;"><?= $row["NUMBER"] ?></p>
			</td>
			<td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-left: 3pt;padding-right: 2pt;text-indent: 0pt;line-height: 9pt;text-align: center;"><?= $row["USECATEGORY"] ?></p>
			</td>
			<td style="width:23pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;padding-left: 4pt;text-indent: 0pt;text-align: left;"><?= $row["INTRAVILAN"]=='true' ? 'DA' :  'NU'; ?></p>
			</td>
			<td style="width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;padding-left: 3pt;padding-right: 2pt;text-indent: 0pt;text-align: center;"><?= $row["MEASUREDAREA"] ?></p>
			</td>
			<td style="width:67pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><?= $row["TITLENO"] ?></p>
			</td>
			<td style="width:67pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><?= $row["LANDPLOTNO"] ?></p>
			</td>
			<td style="width:62pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;text-indent: 0pt;text-align: center;"><?= $row["PARCELNO"] ?></p>
			</td>
			<td style="width:63pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 1pt;padding-left: 1pt;text-indent: 0pt;text-align: center;"><?= $row["TOPONO"] ?></p>
			</td>
			<td style="width:160pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p style="text-indent: 0pt;text-align: left;"><?= $row["NOTES"] ?></p>
			</td>
		</tr><?php } ?>
		</tbody></table>
	<p><br></p>
	<p><br></p>

	<h1 style="padding-top: 5pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">Construcţii</h1>
	<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
		<tbody><tr style="height:23pt">
			<td style="width:29pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 6pt;padding-left: 4pt;padding-right: 3pt;text-indent: 0pt;text-align: center;">Crt</p>
			</td>
			<td style="width:77pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 6pt;padding-left: 23pt;text-indent: 0pt;text-align: left;">Număr</p>
			</td>
			<td style="width:95pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-left: 22pt;text-indent: 2pt;text-align: left;">Destinaţie construcţie</p>
			</td>
			<td style="width:65pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 6pt;padding-left: 3pt;padding-right: 2pt;text-indent: 0pt;text-align: center;">Supraf. (mp)</p>
			</td>
			<td style="width:39pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-left: 2pt;text-indent: 0pt;text-align: left;">Situaţie juridică</p>
			</td>
			<td style="width:196pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 6pt;text-indent: 0pt;text-align: center;">Observaţii / Referinţe</p>
			</td>
		</tr>

		<?php
		$sql = "SELECT * FROM building WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ") ORDER BY BUILDNO";
		$result = $conn->query($sql);
		while($row=mysqli_fetch_assoc($result)){ 
		?>
		<tr style="height:19pt">
			<td style="width:29pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s5" style="padding-top: 4pt;padding-left: 4pt;padding-right: 3pt;text-indent: 0pt;text-align: center;">A1.<?= $row["BUILDNO"] ?></p>
			</td>
			<td style="width:77pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p style="text-indent: 0pt;text-align: left;"><br></p>
			</td>
			<td style="width:95pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-left: 15pt;padding-right: 14pt;text-indent: 0pt;line-height: 9pt;text-align: center;"><?= $row["BUILDINGDESTINATION"] ?></p>
			</td>
			<td style="width:65pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 4pt;padding-left: 3pt;padding-right: 2pt;text-indent: 0pt;text-align: center;"><?= $row["MEASUREDAREA"] ?></p>
			</td>
			<td style="width:39pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s7" style="padding-top: 4pt;padding-left: 2pt;text-indent: 0pt;text-align: left;"><?= $row["ISLEGAL"]=='true' ? 'Cu acte' :  'Fara acte'; ?></p>
			</td>
			<td style="width:196pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s5" style="padding-top: 2pt;padding-right: 6pt;text-indent: 0pt;text-align: center;">Nr. niveluri:<?= $row["LEVELSNO"] ?>, <?= $row["NOTES"] ?></p>
			</td>
		</tr>
		<?php } ?>
	</tbody></table>
	<p><br></p>
	<p><br></p>
		
	<h1 style="padding-top: 2pt;text-indent: -14pt;text-align: center;">B. Partea II. Proprietari şi acte</h1>
			<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
				<tbody><tr style="height:25pt">
					<td style="width:350pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
						<p class="s4" style="padding-top: 7pt;padding-left: 29pt;text-indent: 0pt;text-align: left;">Inscrieri privitoare la dreptul de proprietate şi alte drepturi reale</p>
					</td>
					<td style="width:150pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s4" style="padding-top: 7pt;padding-left: 53pt;padding-right: 52pt;text-indent: 0pt;text-align: center;">Referinţe</p>
					</td>
				</tr>
		<?php
		$sql6="SELECT * FROM registration left join deed on registration.DEEDID = deed.DEEDID
		WHERE (LBPARTNO=2) and (REGISTRATIONID in (select REGISTRATIONID from registrationxentity where 
		(landid in (select LANDID from land where land.CADGENNO=".$param.")) or (buildingid in (SELECT buildingid from building 
		where landid in (select LANDID from land where land.CADGENNO=".$param."))))) ORDER BY POSITION";
		$result = $conn->query($sql6);
		while($row6=mysqli_fetch_assoc($result)){ 
			//print_r($row6["REGISTRATIONID"]);
			$sql8="SELECT * FROM `person` WHERE REGISTRATIONID=".$row6["REGISTRATIONID"];
			$result8 = $conn->query($sql8);	
			$sql9="SELECT building.BUILDNO FROM building, registrationxentity WHERE (building.BUILDINGID=registrationxentity.BUILDINGID) and (registrationxentity.REGISTRATIONID=".$row6["REGISTRATIONID"]  .") order by BUILDNO";
			$sql10="SELECT LANDID FROM registrationxentity WHERE (REGISTRATIONID=".$row6["REGISTRATIONID"].") and(LANDID > 0)";
			$result9 = $conn->query($sql9);
			$result10 = $conn->query($sql10);
			if ($result10->num_rows > 0) { $a1=1; } else { $a1=0; }
		?>

				<tr style="height:13pt">
					<td style="width:500pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3">
						<p class="s6" style="padding-left: 2pt;text-indent: 0pt;line-height: 11pt;text-align: left;"><?= $row6["APPNO"] ?>/ <?= $row6["APPDATE"] ?></p>
					</td>
				</tr>
				<tr style="height:14pt">
					<td style="width:500pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3">
						<p class="s7" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;"><?= $row6["DEEDTYPE"] ?> <?= $row6["DEEDNUMBER"] ?>, din <?= $row6["DEEDDATE"] ?> emis de <?= $row6["AUTHORITY"] ?></p>
					</td>
				</tr>
				<tr style="height:20pt">
					<td style="width:25pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" rowspan="2">
						<p class="s7" style="padding-top: 4pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">B<?= $row6["POSITION"] ?></p>
					</td>
					<td style="width:325pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s7" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;"><?= $row6["REGISTRATIONTYPE"] ?>, drept de <?= $row6["RIGHTTYPE"] ?> <?= $row6["RIGHTCOMMENT"] ?>, dobandit prin 
						<?= $row6["TITLE"] ?>, cota actuala <?= $row6["ACTUALQUOTA"] ?> <?= $row6["NOTES"] ?> <?= $row6["COMMENTS"] ?></p>
					</td>
					<td style="width:150pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 45pt;padding-right: 44pt;text-indent: 0pt;line-height: 9pt;text-align: center;"><?= $a1===1 ? 'A1, ' :  ''; ?> 
						<?php
						while($row9=mysqli_fetch_assoc($result9)){
						echo "A1.".$row9["BUILDNO"].", ";
						}
						?>
						</p>
					</td>
				</tr>
				<tr style="height:12pt">
					
					<td style="width:475pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
					<?php $i=0;
					while($row8=mysqli_fetch_assoc($result8)){ $i++?>	
					<p class="s7" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;"><?= $i?>) <b><?= $row8["LASTNAME"] ?> <?= $row8["FIRSTNAME"] ?></b>   (cnp:<?= $row8["IDCODE"] ?>) <?= $row8["DEFUNCT"]=='true' ? 'Defunct' : '' ?></p>
					<?php } ?>

					</td>
				</tr>
				<?php } ?>

			</tbody></table>


	<p><br></p>
	<p><br></p>


	<h1 style="text-indent: -14pt;text-align: center;">C. Partea III. SARCINI</h1>
	

	<table style="border-collapse:collapse;margin-left:6pt" cellspacing="0">
		<tbody><tr style="height:23pt">
			<td style="width:350pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s4" style="padding-left: 127pt;text-indent: -122pt;text-align: left;">Inscrieri privind dezmembramintele dreptului de proprietate, drepturi reale de garanţie şi sarcini</p>
			</td>
			<td style="width:150pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
				<p class="s4" style="padding-top: 6pt;padding-left: 53pt;padding-right: 52pt;text-indent: 0pt;text-align: center;">Referinţe</p>
			</td>
		</tr>
		<?php
		$sql6="SELECT * FROM registration left join deed on registration.DEEDID = deed.DEEDID
		WHERE (LBPARTNO=3) and (REGISTRATIONID in (select REGISTRATIONID from registrationxentity where 
		(landid in (select LANDID from land where land.CADGENNO=".$param.")) or (buildingid in (SELECT buildingid from building 
		where landid in (select LANDID from land where land.CADGENNO=".$param."))))) ORDER BY POSITION";
		$result = $conn->query($sql6);
		while($row6=mysqli_fetch_assoc($result)){ 
			//print_r($row6["REGISTRATIONID"]);
			$sql8="SELECT * FROM `person` WHERE REGISTRATIONID=".$row6["REGISTRATIONID"];
			$result8 = $conn->query($sql8);	
			$sql9="SELECT building.BUILDNO FROM building, registrationxentity WHERE (building.BUILDINGID=registrationxentity.BUILDINGID) and (registrationxentity.REGISTRATIONID=".$row6["REGISTRATIONID"]  .") order by BUILDNO";
			$sql10="SELECT LANDID FROM registrationxentity WHERE (REGISTRATIONID=".$row6["REGISTRATIONID"].") and(LANDID > 0)";
			$result9 = $conn->query($sql9);
			$result10 = $conn->query($sql10);
			if ($result10->num_rows > 0) { $a1=1; } else { $a1=0; }
		?>

				<tr style="height:13pt">
					<td style="width:500pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3">
						<p class="s6" style="padding-left: 2pt;text-indent: 0pt;line-height: 11pt;text-align: left;"><?= $row6["APPNO"] ?>/ <?= $row6["APPDATE"] ?></p>
					</td>
				</tr>
				<tr style="height:14pt">
					<td style="width:500pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="3">
						<p class="s7" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;"><?= $row6["DEEDTYPE"] ?> <?= $row6["DEEDNUMBER"] ?>, din <?= $row6["DEEDDATE"] ?> emis de <?= $row6["AUTHORITY"] ?></p>
					</td>
				</tr>
				<tr style="height:20pt">
					<td style="width:25pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" rowspan="2">
						<p class="s7" style="padding-top: 4pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">C<?= $row6["POSITION"] ?></p>
					</td>
					<td style="width:325pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s7" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;"><?= $row6["REGISTRATIONTYPE"] ?>, drept de <?= $row6["RIGHTTYPE"] ?> <?= $row6["RIGHTCOMMENT"] ?>, dobandit prin 
						<?= $row6["TITLE"] ?>, cota actuala <?= $row6["ACTUALQUOTA"] ?> <?= $row6["NOTES"] ?> <?= $row6["COMMENTS"] ?></p>
					</td>
					<td style="width:150pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
						<p class="s5" style="padding-left: 45pt;padding-right: 44pt;text-indent: 0pt;line-height: 9pt;text-align: center;"><?= $a1===1 ? 'A1, ' :  ''; ?> 
						<?php
						while($row9=mysqli_fetch_assoc($result9)){
						echo "A1.".$row9["BUILDNO"].", ";
						}
						?>
						</p>
					</td>
				</tr>
				<tr style="height:12pt">
					
					<td style="width:475pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt" colspan="2">
					<?php $i=0;
					while($row8=mysqli_fetch_assoc($result8)){ $i++?>	
					<p class="s7" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;"><?= $i?>) <b><?= $row8["LASTNAME"] ?> <?= $row8["FIRSTNAME"] ?></b>   (cnp:<?= $row8["IDCODE"] ?>) <?= $row8["DEFUNCT"]=='true' ? 'Defunct' : '' ?></p>
					<?php } ?>

					</td>
				</tr>
				<?php } ?>
	</tbody></table>

	<p><br></p>
	</div>
	</div>
	</div>
	</body>
</html>