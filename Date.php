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
			h1 {
			color: black;
			font-family: "Trebuchet MS", sans-serif;
			font-style: normal;
			font-weight: bold;
			text-decoration: none;
			text-align: center;
			font-size: 20pt;
			}
			h2 {
			color: black;
			font-family: "Trebuchet MS", sans-serif;
			font-style: normal;
			font-weight: bold;
			text-decoration: none;
			text-align: center;
			font-size: 14pt;
			}
			h3 {
			color: black;
			font-family: "Trebuchet MS", sans-serif;
			font-style: normal;
			font-weight: bold;
			text-decoration: none;
			text-align: left;
			font-size: 12pt;
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
			table, tbody, th, td {
			width: 100%;	
			vertical-align: middle;
			text-align: center;
			overflow: visible;
			border: 2px solid black;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<p><br></p>
			<p style="text-align: right;">Comuna/Oraş/Municipiu: Cernat</p>
			<p><br></p>
			<h2>DATE DESPRE IMOBILUL NR. <?= $sql1_result_data["CADGENNO"] ?></h2>
			<h2>Sector cadastral: <?= $sql1_result_data["CADSECTOR"] ?></h2>
			<p><br></p>
			<p><br></p>
			<h1>A. Partea I. Descrierea imobilului</h1>

			<p style="text-align: right;">Identificator electronic: <?= $sql1_result_data["E2IDENTIFIER"] ?></p>
			<p style="text-align: right;">Nr. CF vechi: <?= $sql1_result_data["PAPERLBNO"] ?></p>
			<p style="text-align: right;">Nr. CAD vechi: <?= $sql1_result_data["PAPERCADNO"] ?></p>
			<p style="text-align: right;">Nr. topografic: <?= $sql1_result_data["TOPONO"] ?></p>
			
			<p><br></p>
			<h3>TEREN 
				<?php 
					$sql5 = "SELECT distinct LANDID, INTRAVILAN FROM parcel WHERE LANDID in (select LANDID from land WHERE CADGENNO=" . $param . ")";
					$result5 = $conn->query($sql5);
					$sql5_result_data=$result5->fetch_assoc();
					if ($result5->num_rows == 1) {
					echo $sql5_result_data["INTRAVILAN"] =='true' ? 'Intravilan' :  'Extravilan'; 
					}
				?>
			</h3>
			<h3>Adresa: Loc. Cernat, <?= strtolower($sql4_result_data["STREETTYPE"]); ?>
				<?= $sql4_result_data["STREETNAME"] . ',' ?>
				<?= 'nr: '.$sql4_result_data["POSTALNUMBER"] . ',' ?>
				<?= $sql4_result_data["BLOCK"] == '' ? '' : ($sql4_result_data["BLOCK"]. ',') ?>
				<?= $sql4_result_data["ENTRY"] == '' ? '' : ($sql4_result_data["ENTRY"]. ',') ?>
				<?= $sql4_result_data["FLOOR"] == '0' ? '' : ($sql4_result_data["FLOOR"]. ',') ?>
				<?= $sql4_result_data["APNO"] == '0' ? '' : ($sql4_result_data["APNO"]. ',') ?> Jud. Covasna
			</h3>

			<table>
				<tbody>
					<tr>
						<th style="width:16pt">
							<p>Nr. Crt</p>
						</th>
						<th style="width:70pt">
							<p>Nr cadastral Nr. topografic</p>
						</th>
						<th style="width:90pt">
							<p>Suprafaţa* (mp)</p>
						</th>
						<th style="width:324pt">
							<p>Observaţii / Referinţe</p>
						</th>
					</tr>
					<tr>
						<td style="width:16pt">
							<p>A1</p>
						</td>
						<td style="width:70pt">
							<p><?= $sql1_result_data["E2IDENTIFIER"] ?></p>
						</td>
						<td style="width:90pt">
							<p><?= $sql1_result_data["MEASUREDAREA"] ?></p>
						</td>
						<td style="width:324pt">
							<p><?= $sql1_result_data["ENCLOSED_RES"]=='true' ? 'Teren imprejmuit,' :  'Teren neimprejmuit,'; ?> <?= $sql1_result_data["NOTES"] ?></p>
						</td>
					</tr>
				</tbody>
			</table>

			<p><br></p>
			<h3>Parcele</h3>

			<table>
				<tbody>
					<tr>
						<td style="width:17pt">
							<p>Crt</p>
						</td>
						<td style="width:54pt">
							<p>Categorie folosință</p>
						</td>
						<td style="width:23pt">
							<p>Intra vilan</p>
						</td>
						<td style="width:54pt">
							<p>Suprafaţa (mp)</p>
						</td>
						<td style="width:67pt">
							<p>Titlu</p>
						</td>
						<td style="width:67pt">
							<p>Tarla</p>
						</td>
						<td style="width:62pt">
							<p>Parcelă</p>
						</td>
						<td style="width:63pt">
							<p>Nr. topo</p>
						</td>
						<td style="width:160pt">
							<p>Observaţii / Referinţe</p>
						</td>
					</tr>
					<?php 
						$sql = "SELECT * FROM parcel WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ") order by NUMBER";
						$result = $conn->query($sql);
						while($row=mysqli_fetch_assoc($result)){ 
					?>
					<tr>
						<td style="width:17pt">
							<p><?= $row["NUMBER"] ?></p>
						</td>
						<td style="width:54pt">
							<p><?= $row["USECATEGORY"] ?></p>
						</td>
						<td style="width:23pt">
							<p><?= $row["INTRAVILAN"]=='true' ? 'DA' :  'NU'; ?></p>
						</td>
						<td style="width:54pt">
							<p><?= $row["MEASUREDAREA"] ?></p>
						</td>
						<td style="width:67pt">
							<p><?= $row["TITLENO"] ?></p>
						</td>
						<td style="width:67pt">
							<p><?= $row["LANDPLOTNO"] ?></p>
						</td>
						<td style="width:62pt">
							<p><?= $row["PARCELNO"] ?></p>
						</td>
						<td style="width:63pt">
							<p><?= $row["TOPONO"] ?></p>
						</td>
						<td style="width:160pt">
							<p><?= $row["NOTES"] ?></p>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			
			<p><br></p>
			<h3>Construcţii</h3>
			
			<table>
				<tbody>
					<tr>
						<td style="width:29pt">
							<p>Crt</p>
						</td>
						<td style="width:77pt">
							<p>Număr</p>
						</td>
						<td style="width:95pt">
							<p>Destinaţie construcţie</p>
						</td>
						<td style="width:65pt">
							<p>Supraf. (mp)</p>
						</td>
						<td style="width:39pt">
							<p>Situaţie juridică</p>
						</td>
						<td style="width:196pt">
							<p>Observaţii / Referinţe</p>
						</td>
					</tr>

					<?php
						$sql = "SELECT * FROM building WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ") ORDER BY BUILDNO";
						$result = $conn->query($sql);
						while($row=mysqli_fetch_assoc($result)){ 
					?>
					<tr>
						<td style="width:29pt">
							<p>A1.<?= $row["BUILDNO"] ?></p>
						</td>
						<td style="width:77pt">
							<p><br></p>
						</td>
						<td style="width:95pt">
							<p><?= $row["BUILDINGDESTINATION"] ?></p>
						</td>
						<td style="width:65pt">
							<p><?= $row["MEASUREDAREA"] ?></p>
						</td>
						<td style="width:39pt">
							<p><?= $row["ISLEGAL"]=='true' ? 'Cu acte' :  'Fara acte'; ?></p>
						</td>
						<td style="width:196pt">
							<p>Nr. niveluri:<?= $row["LEVELSNO"] ?>, <?= $row["NOTES"] ?></p>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<p><br></p>
			<p><br></p>
			<h1>B. Partea II. Proprietari şi acte</h1>

			<table>
				<tbody>
					<tr>
						<td style="width:350pt" colspan="2">
							<p>Inscrieri privitoare la dreptul de proprietate şi alte drepturi reale</p>
						</td>
						<td style="width:150pt">
							<p>Referinţe</p>
						</td>
					</tr>
					<?php
						$sql6="SELECT * FROM registration left join deed on registration.DEEDID = deed.DEEDID
						WHERE (LBPARTNO=2) and (REGISTRATIONID in (select REGISTRATIONID from registrationxentity where 
						(landid in (select LANDID from land where land.CADGENNO=".$param.")) or (buildingid in (SELECT buildingid from building 
						where landid in (select LANDID from land where land.CADGENNO=".$param."))))) ORDER BY POSITION";
						$result = $conn->query($sql6);
						while($row6=mysqli_fetch_assoc($result)){ 
						$sql8="SELECT * FROM `person` WHERE REGISTRATIONID=".$row6["REGISTRATIONID"];
						$result8 = $conn->query($sql8);	
						$sql9="SELECT building.BUILDNO FROM building, registrationxentity WHERE (building.BUILDINGID=registrationxentity.BUILDINGID) and (registrationxentity.REGISTRATIONID=".$row6["REGISTRATIONID"]  .") order by BUILDNO";
						$sql10="SELECT LANDID FROM registrationxentity WHERE (REGISTRATIONID=".$row6["REGISTRATIONID"].") and(LANDID > 0)";
						$result9 = $conn->query($sql9);
						$result10 = $conn->query($sql10);
						if ($result10->num_rows > 0) { $a1=1; } else { $a1=0; }
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<p><?= $row6["APPNO"] ?>/ <?= $row6["APPDATE"] ?></p>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<p><?= $row6["DEEDTYPE"] ?> <?= $row6["DEEDNUMBER"] ?>, din <?= $row6["DEEDDATE"] ?> emis de <?= $row6["AUTHORITY"] ?></p>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							<p>B<?= $row6["POSITION"] ?></p>
						</td>
						<td style="width:325pt">
							<p style="text-align: left;"><?= $row6["REGISTRATIONTYPE"] ?>, drept de <?= $row6["RIGHTTYPE"] ?> <?= $row6["RIGHTCOMMENT"] ?>, dobandit prin 
							<?= $row6["TITLE"] ?>, cota actuala <?= $row6["ACTUALQUOTA"] ?> <?= $row6["NOTES"] ?> <?= $row6["COMMENTS"] ?></p>
						</td>
						<td style="width:150pt">
							<p><?= $a1===1 ? 'A1, ' :  ''; ?> 
							<?php
								while($row9=mysqli_fetch_assoc($result9)){
								echo "A1.".$row9["BUILDNO"].", ";
								}
							?>
							</p>
						</td>
					</tr>
					<tr>
						<td style="width:475pt" colspan="2">
							<?php $i=0;
								while($row8=mysqli_fetch_assoc($result8)){ $i++
							?>	
							<p style="text-align: left;"><?= $i?>) <b><?= $row8["LASTNAME"] ?> <?= $row8["FIRSTNAME"] ?></b>   (cnp:<?= $row8["IDCODE"] ?>) <?= $row8["DEFUNCT"]=='true' ? 'Defunct' : '' ?></p>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<p><br></p>
			<p><br></p>
			<h1>C. Partea III. SARCINI</h1>
			

			<table>
				<tbody>
					<tr>
						<td style="width:350pt" colspan="2">
							<p>Inscrieri privind dezmembramintele dreptului de proprietate, drepturi reale de garanţie şi sarcini</p>
						</td>
						<td style="width:150pt">
							<p>Referinţe</p>
						</td>
					</tr>
					<?php
						$sql6="SELECT * FROM registration left join deed on registration.DEEDID = deed.DEEDID
						WHERE (LBPARTNO=3) and (REGISTRATIONID in (select REGISTRATIONID from registrationxentity where 
						(landid in (select LANDID from land where land.CADGENNO=".$param.")) or (buildingid in (SELECT buildingid from building 
						where landid in (select LANDID from land where land.CADGENNO=".$param."))))) ORDER BY POSITION";
						$result = $conn->query($sql6);
						while($row6=mysqli_fetch_assoc($result)){ 
						$sql8="SELECT * FROM `person` WHERE REGISTRATIONID=".$row6["REGISTRATIONID"];
						$result8 = $conn->query($sql8);	
						$sql9="SELECT building.BUILDNO FROM building, registrationxentity WHERE (building.BUILDINGID=registrationxentity.BUILDINGID) and (registrationxentity.REGISTRATIONID=".$row6["REGISTRATIONID"]  .") order by BUILDNO";
						$sql10="SELECT LANDID FROM registrationxentity WHERE (REGISTRATIONID=".$row6["REGISTRATIONID"].") and(LANDID > 0)";
						$result9 = $conn->query($sql9);
						$result10 = $conn->query($sql10);
						if ($result10->num_rows > 0) { $a1=1; } else { $a1=0; }
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<p><?= $row6["APPNO"] ?>/ <?= $row6["APPDATE"] ?></p>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<p><?= $row6["DEEDTYPE"] ?> <?= $row6["DEEDNUMBER"] ?>, din <?= $row6["DEEDDATE"] ?> emis de <?= $row6["AUTHORITY"] ?></p>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							<p>C<?= $row6["POSITION"] ?></p>
						</td>
						<td style="width:325pt">
							<p style="text-align: left;"><?= $row6["REGISTRATIONTYPE"] ?>, drept de <?= $row6["RIGHTTYPE"] ?> <?= $row6["RIGHTCOMMENT"] ?>, dobandit prin 
							<?= $row6["TITLE"] ?>, cota actuala <?= $row6["ACTUALQUOTA"] ?> <?= $row6["NOTES"] ?> <?= $row6["COMMENTS"] ?></p>
						</td>
						<td style="width:150pt">
							<p><?= $a1===1 ? 'A1, ' :  ''; ?> 
							<?php
								while($row9=mysqli_fetch_assoc($result9)){
								echo "A1.".$row9["BUILDNO"].", ";
								}
							?>
							</p>
						</td>
					</tr>
					<tr style="height:12pt">
						<td style="width:475pt" colspan="2">
							<?php $i=0;
								while($row8=mysqli_fetch_assoc($result8)){ $i++
							?>	
							<p style="text-align: left;"><?= $i?>) <b><?= $row8["LASTNAME"] ?> <?= $row8["FIRSTNAME"] ?></b>   (cnp:<?= $row8["IDCODE"] ?>) <?= $row8["DEFUNCT"]=='true' ? 'Defunct' : '' ?></p>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<p><br></p>
		</div>
	</body>
</html>