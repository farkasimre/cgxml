<?php include ('partials/connect.php'); ?>
<?php include ('partials/header.php'); ?>


<!-- Introduction -->
<div class="section">
	<div class="container">
		
		<div class="units-row units-split wrap">
			<?php
			$param = $_GET['ID'];
	
			$sql1_result=select_from_land_CADGENNO($param);
			//if ($sql1_result->num_rows > 0) {
			//$sql1_result_data=$sql1_result->fetch_assoc();
			$sql1_result_data = pg_fetch_array($sql1_result);
			//print_r($sql1_result);
			//} else {
			//echo "0 results";
			//}
				
		
			$sql4_result=select_from_address_CADGENNO($param);
			//if ($sql4_result->num_rows > 0) {
			//$sql4_result_data=$sql4_result->fetch_assoc();
			$sql4_result_data = pg_fetch_array($sql4_result);
			//} else {
			//echo "0 results";
			//}
		?>
		
		<title>DATE <?= $sql1_result_data["cadgenno"] ?></title>

			<p style="text-align: right;">Comuna/Oraş/Municipiu: Cernat</p>
			<h2>DATE DESPRE IMOBILUL NR. <?= $sql1_result_data["cadgenno"] ?></h2>
			<h2>Sector cadastral: <?= $sql1_result_data["cadsector"] ?></h2>
			
			<h1>A. Partea I. Descrierea imobilului</h1>

			<p style="text-align: right;">Identificator electronic: <?= $sql1_result_data["e2identifier"] ?><br>Nr. CF vechi: <?= $sql1_result_data["paperlbno"] ?> 
			<br>Nr. CAD vechi: <?= $sql1_result_data["papercadno"] ?><br>Nr. topografic: <?= $sql1_result_data["topono"] ?></p>
			
			
			<p><br></p>
			<h3>TEREN 
				<?php 
					$sql5 = "SELECT distinct landid, intravilan FROM cg_parcel WHERE landid in (select landid from cg_land WHERE cadgenno=" . $param . ")";
					$result5 = pg_query($conn2, $sql5);
					$sql5_result_data = pg_fetch_assoc($result5);
					if (pg_num_rows($result5) == 1) {
					echo $sql5_result_data["intravilan"] =='true' ? 'Intravilan' :  'Extravilan'; 
					}
				?>
			</h3>
			<h3>Adresa: Loc. Cernat, <?= strtolower($sql4_result_data["streettype"]); ?>
				<?= $sql4_result_data["streetname"] . ',' ?>
				<?= 'nr: '.$sql4_result_data["postalnumber"] . ',' ?>
				<?= $sql4_result_data["block"] == '' ? '' : ($sql4_result_data["block"]. ',') ?>
				<?= $sql4_result_data["entry"] == '' ? '' : ($sql4_result_data["entry"]. ',') ?>
				<?= $sql4_result_data["floor"] == '0' ? '' : ($sql4_result_data["floor"]. ',') ?>
				<?= $sql4_result_data["apno"] == '0' ? '' : ($sql4_result_data["apno"]. ',') ?> Jud. Covasna
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
							<?= $sql1_result_data["e2identifier"] ?>
						</td>
						<td style="width:90pt">
							<?= $sql1_result_data["measuredarea"] ?>
						</td>
						<td style="width:324pt">
							<?= $sql1_result_data["enclosed_res"]=='true' ? 'Teren imprejmuit,' :  'Teren neimprejmuit,'; ?> <?= $sql1_result_data["notes"] ?>
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
						$sql = "SELECT * FROM cg_parcel WHERE landid in (select landid from cg_land where cg_land.cadgenno=" . $param . ") order by number";
						$result = pg_query($conn2, $sql);
						while($row = pg_fetch_row($result)){ 
						//	print_r($row);
					?>
					<tr>
						<td style="width:17pt">
							<?= $row[3] ?>
						</td>
						<td style="width:54pt">
							<?= $row[5] ?>
						</td>
						<td style="width:23pt">
							<?= $row[6]=='true' ? 'DA' :  'NU'; ?>
						</td>
						<td style="width:54pt">
							<?= $row[4] ?>
						</td>
						<td style="width:67pt">
							<?= $row[8] ?>
						</td>
						<td style="width:67pt">
							<?= $row[9] ?>
						</td>
						<td style="width:62pt">
							<?= $row[10] ?>
						</td>
						<td style="width:63pt">
							<?= $row[12] ?>
						</td>
						<td style="width:160pt">
							<?= $row[11] ?>
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
						$sql = "SELECT * FROM cg_building WHERE landid in (select landid from cg_land where cg_land.cadgenno=" . $param . ") ORDER BY buildno";
						$result = pg_query($conn2, $sql);
						while($row = pg_fetch_row($result)){ 
					?>
					<tr>
						<td style="width:29pt">
							A1.<?= $row[3] ?>
						</td>
						<td style="width:77pt">
							<br>
						</td>
						<td style="width:95pt">
							<?= $row[6] ?>
						</td>
						<td style="width:65pt">
							<?= $row[4] ?>
						</td>
						<td style="width:39pt">
							<?= $row[11]=='true' ? 'Cu acte' :  'Fara acte'; ?>
						</td>
						<td style="width:196pt">
							Nr. niveluri:<?= $row[7] ?>, <?= $row[10] ?>
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
						$sql6="SELECT * FROM cg_registration left join cg_deed on cg_registration.deedid = cg_deed.deedid
						WHERE (lbpartno=2) and (registrationid in (select registrationid from cg_registrationxentity where 
						(landid in (select landid from cg_land where cg_land.cadgenno=".$param.")) or (buildingid in (SELECT buildingid from cg_building 
						where landid in (select landid from cg_land where cg_land.cadgenno=".$param."))))) ORDER BY position";
						$result = pg_query($conn2, $sql6);
						while($row6 = pg_fetch_row($result)){ 

						$sql8="SELECT * FROM cg_person WHERE registrationid=".$row6[0];
						$result8 = pg_query($conn2, $sql8);
						
						$sql9="SELECT cg_building.buildno FROM cg_building, cg_registrationxentity WHERE (cg_building.buildingid=cg_registrationxentity.buildingid) and (cg_registrationxentity.registrationid=".$row6[0]  .") order by buildno";
						$result9 = pg_query($conn2, $sql9);
						
						$sql10="SELECT landid FROM cg_registrationxentity WHERE (registrationid=".$row6[0].") and(landid > 0)";
						$result10 = pg_query($conn2, $sql10);
						
						if (pg_num_rows($result10) > 0) { $a1=1; } else { $a1=0; }
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[15] ?>/ <?= $row6[16] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[20] ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							B<?= $row6[14] ?>
						</td>
						<td style="width:325pt">
							<?php
							if ($row6[1] <>"NOTATION") 
							{ 
							?>
							<?= $row6[1] ?>, drept de <?= $row6[2] ?> <?= $row6[3] ?>, dobandit prin 
							<?= $row6[6] ?>, cota actuala <?= $row6[9] ?> 
							<?PHP
							}
							?>
							<?= $row6[4] ?> <?= $row6[12] ?>
						</td>
						<td style="width:150pt">
							<?= $a1===1 ? 'A1, ' :  ''; ?> 
							<?php
								while($row9 = pg_fetch_row($result9)){ 
								echo "A1.".$row9[0].", ";
								}
							?>
							</td>
					</tr>
					<tr>
						<td style="width:475pt" colspan="2">
							<?php $i=0;
								while($row8 = pg_fetch_row($result8)){  $i++
							?>	
							<?= $i?>) <b><?= $row8[5] ?> <?= $row8[3] ?></b>   (cnp:<?= $row8[20] ?>) <?= $row8[6]=='true' ? 'Defunct' : '' ?><br>
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
						$sql6="SELECT * FROM cg_registration left join cg_deed on cg_registration.deedid = cg_deed.deedid
						WHERE (lbpartno=3) and (registrationid in (select registrationid from cg_registrationxentity where 
						(landid in (select landid from cg_land where cg_land.cadgenno=".$param.")) or (buildingid in (SELECT buildingid from cg_building 
						where landid in (select landid from cg_land where cg_land.cadgenno=".$param."))))) ORDER BY position";
						$result = pg_query($conn2, $sql6);
						while($row6 = pg_fetch_row($result)){ 

						$sql8="SELECT * FROM cg_person WHERE registrationid=".$row6[0];
						$result8 = pg_query($conn2, $sql8);
						
						$sql9="SELECT cg_building.buildno FROM cg_building, cg_registrationxentity WHERE (cg_building.buildingid=cg_registrationxentity.buildingid) and (cg_registrationxentity.registrationid=".$row6[0]  .") order by buildno";
						$result9 = pg_query($conn2, $sql9);
						
						$sql10="SELECT landid FROM cg_registrationxentity WHERE (registrationid=".$row6[0].") and(landid > 0)";
						$result10 = pg_query($conn2, $sql10);
						
						if (pg_num_rows($result10) > 0) { $a1=1; } else { $a1=0; }
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[15] ?>/ <?= $row6[16] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[20] ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							C<?= $row6[14] ?>
						</td>
						<td style="width:325pt">
							<?= $row6[1] ?>, drept de <?= $row6[2] ?> <?= $row6[3] ?>, dobandit prin 
							<?= $row6[6] ?>, cota actuala <?= $row6[9] ?> <?= $row6[4] ?> <?= $row6[12] ?>
						</td>
						<td style="width:150pt">
							<?= $a1===1 ? 'A1, ' :  ''; ?> 
							<?php
								while($row9 = pg_fetch_row($result9)){ 
								echo "A1.".$row9[0].", ";
								}
							?>
							</td>
					</tr>
					<tr>
						<td style="width:475pt" colspan="2">
							<?php $i=0;
								while($row8 = pg_fetch_row($result8)){  $i++
							?>	
							<?= $i?>) <b><?= $row8[5] ?> <?= $row8[3] ?></b>   (cnp:<?= $row8[20] ?>) <?= $row8[6]=='true' ? 'Defunct' : '' ?><br>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

</div></div></div>

<?php include ('partials/footer.php'); ?>
