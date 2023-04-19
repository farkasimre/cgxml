<?php include ('partials/connect.php'); ?>
<?php include ('partials/header.php'); ?>

<div class="section">
	<div class="container">
		<div class="units-row units-split wrap">
			<?php
				$param = $_GET['ID'];
	
				$sql1 = "SELECT * FROM cg_land WHERE cadgenno=".$param;
				$result1 = pg_query($sql1);
				if (pg_num_rows($result1) == 0) 
				{
				echo "ID ".$param."???";
				}
				else
				{
				$sql1_result_data = pg_fetch_array($result1);
				$landid = $sql1_result_data["landid"];
			
				$sql4 = "SELECT * FROM cg_address WHERE addressid in (select addressid from cg_land where cg_land.cadgenno=" . $param . ")";
				$result4 = pg_query($sql4);
				$sql4_result_data = pg_fetch_array($result4);
			?>
		
			<title>DATE <?= $param ?></title>

			<p style="text-align: right;">Comuna/Oraş/Municipiu: Cernat</p>
			<h2>DATE DESPRE IMOBILUL NR. <?= $sql1_result_data["cadgenno"] ?></h2>
			<h2>Sector cadastral: <?= $sql1_result_data["cadsector"] ?></h2>
			
			<h1 style="text-align: center;">A. Partea I. Descrierea imobilului</h1>

			<p style="text-align: right;">Identificator electronic: <?= $sql1_result_data["e2identifier"] ?><br>Nr. CF vechi: <?= $sql1_result_data["paperlbno"] ?> 
			<br>Nr. CAD vechi: <?= $sql1_result_data["papercadno"] ?><br>Nr. topografic: <?= $sql1_result_data["topono"] ?></p>
			
			
			<p><br></p>
			<h3>TEREN 
				<?php 
					$sql5 = "SELECT distinct landid, intravilan FROM cg_parcel WHERE landid =" . $landid;
					$result5 = pg_query($sql5);
					$sql5_result_data = pg_fetch_assoc($result5);
					if (pg_num_rows($result5) == 1) {
					echo $sql5_result_data["intravilan"] =='true' ? 'Intravilan' :  'Extravilan'; 
					}
				?>
			</h3>
			<h3>Adresa: Loc. Cernat, <?= strtolower($sql4_result_data["streettype"]); ?>
				<?= $sql4_result_data["streetname"] . ',' ?>
				<?= 'nr: '.$sql4_result_data["postalnumber"] . ',' ?>
				<?= $sql4_result_data["block"] == '' ? '' : ('bloc '.$sql4_result_data["block"]. ',') ?>
				<?= $sql4_result_data["entry"] == '' ? '' : ('scara '.$sql4_result_data["entry"]. ',') ?>
				<?= $sql4_result_data["floor"] == '0' ? '' : ('etaj '.$sql4_result_data["floor"]. ',') ?>
				<?= $sql4_result_data["apno"] == '0' ? '' : ('apartament '.$sql4_result_data["apno"]. ',') ?> Jud. Covasna
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
						$sql2 = "SELECT * FROM cg_parcel WHERE landid = " . $landid . " order by number";
						$result2 = pg_query($sql2);
						while($row2 = pg_fetch_row($result2)){ 
					?>
					<tr>
						<td style="width:17pt">
							<?= $row2[3] ?>
						</td>
						<td style="width:54pt">
							<?= $row2[5] ?>
						</td>
						<td style="width:23pt">
							<?= $row2[6]=='true' ? 'DA' :  'NU'; ?>
						</td>
						<td style="width:54pt">
							<?= $row2[4] ?>
						</td>
						<td style="width:67pt">
							<?= $row2[8] ?>
						</td>
						<td style="width:67pt">
							<?= $row2[9] ?>
						</td>
						<td style="width:62pt">
							<?= $row2[10] ?>
						</td>
						<td style="width:63pt">
							<?= $row2[12] ?>
						</td>
						<td style="width:160pt">
							<?= $row2[11] ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			
			<?php
				$sql3 = "SELECT * FROM cg_building WHERE landid =" . $landid . " ORDER BY buildno";
				$result3 = pg_query($sql3);
				if (pg_num_rows($result3) <> 0) {
			?>
			<p><br></p>
			<h3>Construcţii</h3>
			
			<table>
				<tbody>
					<tr>
						<td style="width:29pt">
							Crt
						</td>
						<td style="width:29pt">
							Nr cad/ Nr topo
						</td>
						<td style="width:65pt">
							Destinaţie construcţie
						</td>
						<td style="width:65pt">
							Supraf. (mp)
						</td>
						<td style="width:39pt">
							Situaţie juridică
						</td>
						<td style="width:77pt">
							Condominiu
						</td>
						<td style="width:77pt">
							Parti comune
						</td>
						<td style="width:196pt">
							Observaţii / Referinţe
						</td>
					</tr>

					<?php
						while($row3 = pg_fetch_row($result3)){ 
						$buildingid = $row3[0];
						$sql11 = "SELECT * FROM cg_buildingcommonparts WHERE buildingid =". $buildingid;
						$result11 = pg_query($sql11);
					?>
					<tr>
						<td style="width:29pt">
							A1.<?= $row3[3] ?>
						</td>
						<td style="width:29pt">
							<?= $row3[13] ?>
						</td>
						<td style="width:65pt">
							<?= $row3[6] ?>
						</td>
						<td style="width:65pt">
							<?= $row3[4] ?>
						</td>
						<td style="width:39pt">
							<?= $row3[11] ? 'Cu acte' :  'Fara acte'; ?>
						</td>
						<td style="width:77pt">
						<?php
						if (pg_num_rows($result11) >= 1) {
						echo "DA"; 
						}
						?>
						</td>
						<td style="width:77pt">
						<?php
						while($row11 = pg_fetch_row($result11)){
						echo(str_replace("_", " ", $row11[3]).", ");
						}
						?>
						</td>
						<td style="width:196pt">
							Nr. niveluri:<?= $row3[7] ?>, <?= $row3[10] ?>
						</td>
					</tr>
					<?php
				 	}
				 	?>
				</tbody>
			</table>

			<?php
			$sql12 = "SELECT * FROM cg_iu WHERE buildingid =".$buildingid." ORDER BY identifier";
			$result12 = pg_query($sql12);
			if (pg_num_rows($result12) <> 0) {
			?>
			<p><br></p>
			<h3>Unitati individuale</h3>
			
			<table>
				<tbody>
					<tr>
						<td style="width:29pt">
							Crt
						</td>
						<td style="width:29pt">
							Nr cad/ Nr topo
						</td>
						<td style="width:35pt">
							Scara
						</td>
						<td style="width:35pt">
							Etaj
						</td>
						<td style="width:35pt">
							Nr Apartament
						</td>
						<td style="width:39pt">
							Supraf. construita (mp)
						</td>
						<td style="width:39pt">
							Supraf. utila(mp)
						</td>
						<td style="width:30pt">
							Cote parti comune
						</td>
						<td style="width:30pt">
							Cote teren
						</td>
						<td style="width:196pt">
							Observaţii / Referinţe
						</td>
					</tr>

					<?php
						while($row12 = pg_fetch_row($result12)){ 
					?>
					<tr>
						<td style="width:29pt">
							A1.1.<?= $row12[3] ?>
						</td>
						<td style="width:29pt">
							<?= $row12[14] ?>
						</td>
						<td style="width:65pt">
							<?= $row12[6] ?>
						</td>
						<td style="width:65pt">
							<?= $row12[12] ?>
						</td>
						<td style="width:65pt">
							<?= $row12[5] ?>
						</td>
						<td style="width:39pt">
							<?= $row12[7] ?>
						</td>
						<td style="width:39pt">
							<?= $row12[8] ?>
						</td>
						<td style="width:30pt">
							<?= $row12[9] ?>
						</td>
						<td style="width:30pt">
							<?= $row12[10] ?>
						</td>
						<td style="width:196pt">
							<?= $row12[11] ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
			<?php
				}
			}
			
			?>
			
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
						(landid =".$landid.") or (buildingid in (SELECT buildingid from cg_building where landid = ".$landid.")))) ORDER BY position";
						$result6 = pg_query($sql6);
						while($row6 = pg_fetch_row($result6)){ 
						
						$sql8="SELECT * FROM cg_person WHERE registrationid=".$row6[0];
						$result8 = pg_query($sql8);
						
						$sql9="SELECT cg_building.buildno FROM cg_building, cg_registrationxentity WHERE (cg_building.buildingid=cg_registrationxentity.buildingid) and
						(cg_registrationxentity.registrationid=".$row6[0]  .") order by buildno";
						$result9 = pg_query($sql9);
						
						$sql10="SELECT landid FROM cg_registrationxentity WHERE (registrationid=".$row6[0].") and(landid > 0)";
						$result10 = pg_query($sql10);
						
						if (pg_num_rows($result10) > 0) { $a1="A1, "; } else { $a1=""; }
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[15] ?>/ <?= $row6[16] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= str_replace("_"," ",$row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
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
							<?= str_replace("INTAB", "Intabulare", str_replace("PROVISIONALENTRY", "Inscrierea provizorie", $row6[1])) ?>, drept de 
							<?= $row6[2] ?> <?= $row6[3] ?>, dobandit prin <?= $row6[6] ?>, cota actuala <b><?= $row6[9] ?></b> 
							<?PHP
							}
							?>
							<?= $row6[4] ?> <?= $row6[12] ?>
						</td>
						<td style="width:150pt">
							<?php
								echo $a1; 
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
			<?php
			$sql7 = "SELECT iuid, identifier FROM cg_iu where buildingid in (SELECT buildingid FROM cg_building WHERE landid = ".$landid.") order by identifier";
			$result7 = pg_query($sql7);
			while($row7 = pg_fetch_row($result7)){ 
			?>
			<h3>Unitati individuale - constructia C1 - U<?= $row7[1] ?></h3>
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
						iuid =".$row7[0].")) ORDER BY position";
						$result6 = pg_query($sql6);
						while($row6 = pg_fetch_row($result6)){ 

						$sql8="SELECT * FROM cg_person WHERE registrationid=".$row6[0];
						$result8 = pg_query($sql8);
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[15] ?>/ <?= $row6[16] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= str_replace("_"," ",$row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
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
							<?= str_replace("INTAB", "Intabulare", str_replace("PROVISIONALENTRY", "Inscrierea provizorie", $row6[1])) ?>, drept de 
							<?= $row6[2] ?> <?= $row6[3] ?>, dobandit prin <?= $row6[6] ?>, cota actuala <b><?= $row6[9] ?></b> 
							<?PHP
							}
							?>
							<?= $row6[4] ?> <?= $row6[12] ?>
						</td>
						<td style="width:150pt">
							<?php
								echo "A1.1.".$row7[1];
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
			<?php } ?>
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
						(landid =".$landid.") or (buildingid in (SELECT buildingid from cg_building where landid = ".$landid.")))) ORDER BY position";
						$result6 = pg_query($sql6);
						if (pg_num_rows($result6) == 0) 
						{
					?>
						<tr>
						<td style="width:500pt; text-align: left" colspan="3">
						<b>Nu sunt</b>
						</td>
						</tr>	
					<?php
						}
						while($row6 = pg_fetch_row($result6)){ 
						
							$sql8="SELECT * FROM cg_person WHERE registrationid=".$row6[0];
							$result8 = pg_query($sql8);
							
							$sql9="SELECT cg_building.buildno FROM cg_building, cg_registrationxentity WHERE (cg_building.buildingid=cg_registrationxentity.buildingid) and
							(cg_registrationxentity.registrationid=".$row6[0]  .") order by buildno";
							$result9 = pg_query($sql9);
							
							$sql10="SELECT landid FROM cg_registrationxentity WHERE (registrationid=".$row6[0].") and(landid > 0)";
							$result10 = pg_query($sql10);
							
							if (pg_num_rows($result10) > 0) { $a1="A1, "; } else { $a1=""; }
						?>
	
						<tr>
							<td style="width:500pt; text-align: left" colspan="3">
								<?= $row6[15] ?>/ <?= $row6[16] ?>
							</td>
						</tr>
						<tr>
							<td style="width:500pt; text-align: left" colspan="3">
								<?= str_replace("_"," ",$row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
							</td>
						</tr>
						<tr>
							<td style="width:25pt" rowspan="2">
								C<?= $row6[14] ?>
							</td>
							<td style="width:325pt">
								<?php
								if ($row6[1] <>"NOTATION") 
								{ 
								?>
								<?= str_replace("INTAB", "Intabulare", str_replace("PROVISIONALENTRY", "Inscrierea provizorie", $row6[1])) ?>, drept de 
							<?= $row6[2] ?> <?= $row6[3] ?>, dobandit prin <?= $row6[6] ?>, cota actuala <b><?= $row6[9] ?></b> 
								<?PHP
								}
								?>
								<?= $row6[4] ?> <?= $row6[12] ?>
							</td>
							<td style="width:150pt">
								<?php
									echo $a1; 
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
			<?php
			$sql7 = "SELECT iuid, identifier FROM cg_iu where buildingid in (SELECT buildingid FROM cg_building WHERE landid = ".$landid.") order by identifier";
			$result7 = pg_query($sql7);
			while($row7 = pg_fetch_row($result7)){ 
			?>
			<h3>Unitati individuale - constructia C1 - U<?= $row7[1] ?></h3>
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
						iuid =".$row7[0].")) ORDER BY position";
						$result6 = pg_query($sql6);
						if (pg_num_rows($result6) == 0) 
						{
					?>
						<tr>
						<td style="width:500pt; text-align: left" colspan="3">
						<b>Nu sunt</b>
						</td>
						</tr>	
					<?php
						}
						while($row6 = pg_fetch_row($result6)){ 

						$sql8="SELECT * FROM cg_person WHERE registrationid=".$row6[0];
						$result8 = pg_query($sql8);
					?>

					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= $row6[15] ?>/ <?= $row6[16] ?>
						</td>
					</tr>
					<tr>
						<td style="width:500pt; text-align: left" colspan="3">
							<?= str_replace("_"," ",$row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
						</td>
					</tr>
					<tr>
						<td style="width:25pt" rowspan="2">
							C<?= $row6[14] ?>
						</td>
						<td style="width:325pt">
							<?php
							if ($row6[1] <>"NOTATION") 
							{ 
							?>
							<?= str_replace("INTAB", "Intabulare", str_replace("PROVISIONALENTRY", "Inscrierea provizorie", $row6[1])) ?>, drept de 
							<?= $row6[2] ?> <?= $row6[3] ?>, dobandit prin <?= $row6[6] ?>, cota actuala <b><?= $row6[9] ?></b> 
							<?PHP
							}
							?>
							<?= $row6[4] ?> <?= $row6[12] ?>
						</td>
						<td style="width:150pt">
							<?php
								echo "A1.1.".$row7[1];
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
			<?php } ?>

			<?php 
			} 
			pg_close($conn);
			?>
		</div>
	</div>
</div>

<?php include ('partials/footer.php'); ?>
