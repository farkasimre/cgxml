<?php include ('partials/connect.php'); ?>
<?php include ('partials/header.php'); ?>


<!-- Introduction -->
<div class="section">
	<div class="container">
		
		<div class="units-row units-split wrap">
			<?php
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

			<p style="text-align: right;">Comuna/Oraş/Municipiu: Cernat</p>
			<h2>DATE DESPRE IMOBILUL NR. <?= $sql1_result_data["CADGENNO"] ?></h2>
			<h2>Sector cadastral: <?= $sql1_result_data["CADSECTOR"] ?></h2>
			
			<h1>A. Partea I. Descrierea imobilului</h1>

			<p style="text-align: right;">Identificator electronic: <?= $sql1_result_data["E2IDENTIFIER"] ?><br>Nr. CF vechi: <?= $sql1_result_data["PAPERLBNO"] ?> <br>Nr. CAD vechi: <?= $sql1_result_data["PAPERCADNO"] ?></p>
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
							Nr. Crt
						</th>
						<th style="width:70pt">
							Nr cadastral Nr. topografic
						</th>
						<th style="width:90pt">
							Suprafaţa* (mp)
						</th>
						<th style="width:324pt">
							Observaţii / Referinţe
						</th>
					</tr>
					<tr>
						<td style="width:16pt">
							A1
						</td>
						<td style="width:70pt">
							<?= $sql1_result_data["E2IDENTIFIER"] ?>
						</td>
						<td style="width:90pt">
							<?= $sql1_result_data["MEASUREDAREA"] ?>
						</td>
						<td style="width:324pt">
							<?= $sql1_result_data["ENCLOSED_RES"]=='true' ? 'Teren imprejmuit,' :  'Teren neimprejmuit,'; ?> <?= $sql1_result_data["NOTES"] ?>
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
							Crt
						</td>
						<td style="width:54pt">
							Categorie folosință
						</td>
						<td style="width:23pt">
							Intra vilan
						</td>
						<td style="width:54pt">
							Suprafaţa (mp)
						</td>
						<td style="width:67pt">
							Titlu
						</td>
						<td style="width:67pt">
							Tarla
						</td>
						<td style="width:62pt">
							Parcelă
						</td>
						<td style="width:63pt">
							Nr. topo
						</td>
						<td style="width:160pt">
							Observaţii / Referinţe
						</td>
					</tr>
					<?php 
						$sql = "SELECT * FROM parcel WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ") order by NUMBER";
						$result = $conn->query($sql);
						while($row=mysqli_fetch_assoc($result)){ 
					?>
					<tr>
						<td style="width:17pt">
							<?= $row["NUMBER"] ?>
						</td>
						<td style="width:54pt">
							<?= $row["USECATEGORY"] ?>
						</td>
						<td style="width:23pt">
							<?= $row["INTRAVILAN"]=='true' ? 'DA' :  'NU'; ?>
						</td>
						<td style="width:54pt">
							<?= $row["MEASUREDAREA"] ?>
						</td>
						<td style="width:67pt">
							<?= $row["TITLENO"] ?>
						</td>
						<td style="width:67pt">
							<?= $row["LANDPLOTNO"] ?>
						</td>
						<td style="width:62pt">
							<?= $row["PARCELNO"] ?>
						</td>
						<td style="width:63pt">
							<?= $row["TOPONO"] ?>
						</td>
						<td style="width:160pt">
							<?= $row["NOTES"] ?>
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
							Crt
						</td>
						<td style="width:77pt">
							Număr
						</td>
						<td style="width:95pt">
							Destinaţie construcţie
						</td>
						<td style="width:65pt">
							Supraf. (mp)
						</td>
						<td style="width:39pt">
							Situaţie juridică
						</td>
						<td style="width:196pt">
							Observaţii / Referinţe
						</td>
					</tr>

					<?php
						$sql = "SELECT * FROM building WHERE LANDID in (select LANDID from land where land.CADGENNO=" . $param . ") ORDER BY BUILDNO";
						$result = $conn->query($sql);
						while($row=mysqli_fetch_assoc($result)){ 
					?>
					<tr>
						<td style="width:29pt">
							A1.<?= $row["BUILDNO"] ?>
						</td>
						<td style="width:77pt">
							<br>
						</td>
						<td style="width:95pt">
							<?= $row["BUILDINGDESTINATION"] ?>
						</td>
						<td style="width:65pt">
							<?= $row["MEASUREDAREA"] ?>
						</td>
						<td style="width:39pt">
							<?= $row["ISLEGAL"]=='true' ? 'Cu acte' :  'Fara acte'; ?>
						</td>
						<td style="width:196pt">
							Nr. niveluri:<?= $row["LEVELSNO"] ?>, <?= $row["NOTES"] ?>
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
							Inscrieri privitoare la dreptul de proprietate şi alte drepturi reale
						</td>
						<td style="width:150pt">
							Referinţe
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
							<?= $row6["APPNO"] ?>/ <?= $row6["APPDATE"] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6["DEEDTYPE"] ?> <?= $row6["DEEDNUMBER"] ?>, din <?= $row6["DEEDDATE"] ?> emis de <?= $row6["AUTHORITY"] ?>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							B<?= $row6["POSITION"] ?>
						</td>
						<td style="width:325pt">
							<?= $row6["REGISTRATIONTYPE"] ?>, drept de <?= $row6["RIGHTTYPE"] ?> <?= $row6["RIGHTCOMMENT"] ?>, dobandit prin 
							<?= $row6["TITLE"] ?>, cota actuala <?= $row6["ACTUALQUOTA"] ?> <?= $row6["NOTES"] ?> <?= $row6["COMMENTS"] ?>
						</td>
						<td style="width:150pt">
							<?= $a1===1 ? 'A1, ' :  ''; ?> 
							<?php
								while($row9=mysqli_fetch_assoc($result9)){
								echo "A1.".$row9["BUILDNO"].", ";
								}
							?>
							</td>
					</tr>
					<tr>
						<td style="width:475pt" colspan="2">
							<?php $i=0;
								while($row8=mysqli_fetch_assoc($result8)){ $i++
							?>	
							<?= $i?>) <b><?= $row8["LASTNAME"] ?> <?= $row8["FIRSTNAME"] ?></b>   (cnp:<?= $row8["IDCODE"] ?>) <?= $row8["DEFUNCT"]=='true' ? 'Defunct' : '' ?>
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
							Inscrieri privind dezmembramintele dreptului de proprietate, drepturi reale de garanţie şi sarcini
						</td>
						<td style="width:150pt">
							Referinţe
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
							<?= $row6["APPNO"] ?>/ <?= $row6["APPDATE"] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6["DEEDTYPE"] ?> <?= $row6["DEEDNUMBER"] ?>, din <?= $row6["DEEDDATE"] ?> emis de <?= $row6["AUTHORITY"] ?>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							C<?= $row6["POSITION"] ?>
						</td>
						<td style="width:325pt">
							<?= $row6["REGISTRATIONTYPE"] ?>, drept de <?= $row6["RIGHTTYPE"] ?> <?= $row6["RIGHTCOMMENT"] ?>, dobandit prin 
							<?= $row6["TITLE"] ?>, cota actuala <?= $row6["ACTUALQUOTA"] ?> <?= $row6["NOTES"] ?> <?= $row6["COMMENTS"] ?>
						</td>
						<td style="width:150pt">
							<?= $a1===1 ? 'A1, ' :  ''; ?> 
							<?php
								while($row9=mysqli_fetch_assoc($result9)){
								echo "A1.".$row9["BUILDNO"].", ";
								}
							?>
							
						</td>
					</tr>
					<tr style="height:12pt">
						<td style="width:475pt" colspan="2">
							<?php $i=0;
								while($row8=mysqli_fetch_assoc($result8)){ $i++
							?>	
							<?= $i?>) <b><?= $row8["LASTNAME"] ?> <?= $row8["FIRSTNAME"] ?></b>   (cnp:<?= $row8["IDCODE"] ?>) <?= $row8["DEFUNCT"]=='true' ? 'Defunct' : '' ?>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

</div></div></div>

<?php include ('partials/footer.php'); ?>
