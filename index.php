<?php include('partials/connect.php'); ?>
<?php include('partials/header.php'); ?>

<div class="section">
	<div class="container">
		<div class="units-row units-split wrap">
			<?php
			$param = $_GET['ID'];

			$sql1 = "SELECT * FROM cg_land WHERE cadgenno=" . $param;
			$result1 = pg_query($conn, $sql1);
			if (pg_num_rows($result1) == 0) {
				echo "ID " . $param . "???";
			} else {
				$sql1_result_data = pg_fetch_array($result1);
				$landid = $sql1_result_data["landid"];

				$sql4 = "SELECT * FROM cg_address WHERE addressid in (select addressid from cg_land where cg_land.cadgenno=" . $param . ")";
				$result4 = pg_query($conn, $sql4);
				$sql4_result_data = pg_fetch_array($result4);
			?>

				<title>DATE <?= $param ?></title>

				<p style="text-align: right;">Comuna/Oraş/Municipiu: Cernat</p>
				<h3>DATE DESPRE IMOBILUL NR. <?= $sql1_result_data["cadgenno"] ?></h3>
				<h3>Sector cadastral: <?= $sql1_result_data["cadsector"] ?></h3>

				<h1 style="text-align: center;">A. Partea I. Descrierea imobilului</h1>

				<p style="text-align: right;">Identificator electronic: <?= $sql1_result_data["e2identifier"] ?><br>Nr. CF vechi: <?= $sql1_result_data["paperlbno"] ?>
					<br>Nr. CAD vechi: <?= $sql1_result_data["papercadno"] ?><br>Nr. topografic: <?= $sql1_result_data["topono"] ?>
				</p>

				<h3>TEREN
					<?php
					$sql5 = "SELECT distinct landid, intravilan FROM cg_parcel WHERE landid =" . $landid;
					$result5 = pg_query($conn, $sql5);
					$sql5_result_data = pg_fetch_assoc($result5);
					if (pg_num_rows($result5) == 1) {
						echo $sql5_result_data["intravilan"] == 'true' ? 'Intravilan' :  'Extravilan';
					}
					?>
				</h3>
				<h3>Adresa: Loc. Cernat, <?= strtolower($sql4_result_data["streettype"]); ?>
					<?= $sql4_result_data["streetname"] . ',' ?>
					<?= 'nr: ' . $sql4_result_data["postalnumber"] . ',' ?>
					<?= $sql4_result_data["block"] == '' ? '' : ('bloc ' . $sql4_result_data["block"] . ',') ?>
					<?= $sql4_result_data["entry"] == '' ? '' : ('scara ' . $sql4_result_data["entry"] . ',') ?>
					<?= $sql4_result_data["floor"] == '0' ? '' : ('etaj ' . $sql4_result_data["floor"] . ',') ?>
					<?= $sql4_result_data["apno"] == '0' ? '' : ('apartament ' . $sql4_result_data["apno"] . ',') ?> Jud. Covasna
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
							<td>
								A1
							</td>
							<td>
								<?= $sql1_result_data["e2identifier"] ?>
							</td>
							<td>
								<?= $sql1_result_data["measuredarea"] ?>
							</td>
							<td>
								<?= $sql1_result_data["enclosed_res"] == 'true' ? 'Teren imprejmuit,' :  'Teren neimprejmuit,'; ?> <?= $sql1_result_data["notes"] ?>
							</td>
						</tr>
					</tbody>
				</table>

				<h3>Parcele</h3>

				<table>
					<tbody>
						<tr>
							<th style="width:17pt">
								Crt
							</th>
							<th style="width:54pt">
								Categorie folosință
							</th>
							<th style="width:23pt">
								Intra vilan
							</th>
							<th style="width:54pt">
								Suprafaţa (mp)
							</th>
							<th style="width:67pt">
								Titlu
							</th>
							<th style="width:67pt">
								Tarla
							</th>
							<th style="width:62pt">
								Parcelă
							</th>
							<th style="width:63pt">
								Nr. topo
							</th>
							<th style="width:160pt">
								Observaţii / Referinţe
							</th>
						</tr>
						<?php
						$sql2 = "SELECT * FROM cg_parcel WHERE landid = " . $landid . " order by number";
						$result2 = pg_query($conn, $sql2);
						while ($row2 = pg_fetch_row($result2)) {
						?>
							<tr>
								<td>
									<?= $row2[3] ?>
								</td>
								<td>
									<?= $row2[5] ?>
								</td>
								<td>
									<?= $row2[6] == 'true' ? 'DA' :  'NU'; ?>
								</td>
								<td>
									<?= $row2[4] ?>
								</td>
								<td>
									<?= $row2[8] ?>
								</td>
								<td>
									<?= $row2[9] ?>
								</td>
								<td>
									<?= $row2[10] ?>
								</td>
								<td>
									<?= $row2[12] ?>
								</td>
								<td>
									<?= $row2[11] ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<?php
				$sql3 = "SELECT * FROM cg_building WHERE landid =" . $landid . " ORDER BY buildno";
				$result3 = pg_query($conn, $sql3);
				if (pg_num_rows($result3) <> 0) {
				?>

					<h3>Construcţii</h3>

					<table>
						<tbody>
							<tr>
								<th style="width:30pt">
									Crt
								</th>
								<th style="width:40pt">
									Nr.cad/ Nr.topo
								</th>
								<th style="width:40pt">
									Destinaţie construcţie
								</th>
								<th style="width:60pt">
									Supraf. (mp)
								</th>
								<th style="width:30pt">
									Situaţie juridică
								</th>
								<th style="width:50pt">
									Condominiu
								</th>
								<th style="width:80pt">
									Parti comune
								</th>
								<th style="width:200pt">
									Observaţii / Referinţe
								</th>
							</tr>

							<?php
							while ($row3 = pg_fetch_row($result3)) {
								$buildingid = $row3[0];
								$sql11 = "SELECT * FROM cg_buildingcommonparts WHERE buildingid =" . $buildingid;
								$result11 = pg_query($conn, $sql11);
							?>
								<tr>
									<td>
										A1.<?= $row3[3] ?>
									</td>
									<td>
										<?= $row3[13] ?>
									</td>
									<td>
										<?= $row3[6] ?>
									</td>
									<td>
										<?= $row3[4] ?>
									</td>
									<td>
										<?= $row3[11] ? 'Cu acte' :  'Fara acte'; ?>
									</td>
									<td>
										<?php
										if (pg_num_rows($result11) >= 1) {
											echo "DA";
										}
										?>
									</td>
									<td>
										<?php
										while ($row11 = pg_fetch_row($result11)) {
											echo (str_replace("_", " ", $row11[3]) . ", ");
										}
										?>
									</td>
									<td>
										Nr. niveluri:<?= $row3[7] ?>, <?= $row3[10] ?>
									</td>
								</tr>
							<?php
							}
							?>
						</tbody>
					</table>

					<?php
					$sql12 = "SELECT * FROM cg_iu WHERE buildingid =" . $buildingid . " ORDER BY identifier";
					$result12 = pg_query($conn, $sql12);
					if (pg_num_rows($result12) <> 0) {
					?>

						<h3>Unitati individuale</h3>

						<table>
							<tbody>
								<tr>
									<th style="width:29pt">
										Crt
									</th>
									<th style="width:29pt">
										Nr.cad/ Nr.topo
									</th>
									<th style="width:35pt">
										Scara
									</th>
									<th style="width:35pt">
										Etaj
									</th>
									<th style="width:29pt">
										Nr Apar tament
									</th>
									<th style="width:39pt">
										Supraf. construita (mp)
									</th>
									<th style="width:39pt">
										Supraf. utila(mp)
									</th>
									<th style="width:30pt">
										Cote parti comune
									</th>
									<th style="width:30pt">
										Cote teren
									</th>
									<th style="width:205pt">
										Observaţii / Referinţe
									</th>
								</tr>

								<?php
								while ($row12 = pg_fetch_row($result12)) {
								?>
									<tr>
										<td>
											A1.1.<?= $row12[3] ?>
										</td>
										<td>
											<?= $row12[14] ?>
										</td>
										<td>
											<?= $row12[6] ?>
										</td>
										<td>
											<?= $row12[12] ?>
										</td>
										<td>
											<?= $row12[5] ?>
										</td>
										<td>
											<?= $row12[7] ?>
										</td>
										<td>
											<?= $row12[8] ?>
										</td>
										<td>
											<?= $row12[9] ?>
										</td>
										<td>
											<?= $row12[10] ?>
										</td>
										<td>
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
				<h1 style="text-align: center;">B. Partea II. Proprietari şi acte</h1>

				<table>
					<tbody>
						<tr>
							<th style="width:350pt" colspan="2">
								Inscrieri privitoare la dreptul de proprietate şi alte drepturi reale
							</th>
							<th style="width:150pt">
								Referinţe
							</th>
						</tr>
						<?php
						$sql6 = "SELECT * FROM cg_registration left join cg_deed on cg_registration.deedid = cg_deed.deedid
						WHERE (lbpartno=2) and (registrationid in (select registrationid from cg_registrationxentity where 
						(landid =" . $landid . ") or (buildingid in (SELECT buildingid from cg_building where landid = " . $landid . ")))) ORDER BY position";
						$result6 = pg_query($conn, $sql6);
						while ($row6 = pg_fetch_row($result6)) {

							$sql8 = "SELECT * FROM cg_person WHERE registrationid=" . $row6[0];
							$result8 = pg_query($conn, $sql8);

							$sql9 = "SELECT cg_building.buildno FROM cg_building, cg_registrationxentity WHERE (cg_building.buildingid=cg_registrationxentity.buildingid) and
						(cg_registrationxentity.registrationid=" . $row6[0]  . ") order by buildno";
							$result9 = pg_query($conn, $sql9);

							$sql10 = "SELECT landid FROM cg_registrationxentity WHERE (registrationid=" . $row6[0] . ") and(landid > 0)";
							$result10 = pg_query($conn, $sql10);

							if (pg_num_rows($result10) > 0) {
								$a1 = "A1, ";
							} else {
								$a1 = "";
							}
						?>

							<tr>
								<td style="width:500pt; text-align: left" colspan="3">
									<?= $row6[15] ?>/ <?= $row6[16] ?>
								</td>
							</tr>
							<tr>
								<td style="width:500pt; text-align: left" colspan="3">
									<?= str_replace("_", " ", $row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
								</td>
							</tr>
							<tr>
								<td style="width:25pt" rowspan="2">
									B<?= $row6[14] ?>
								</td>
								<td style="width:325pt">
									<?php
									if ($row6[1] <> "NOTATION") {
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
									while ($row9 = pg_fetch_row($result9)) {
										echo "A1." . $row9[0] . ", ";
									}
									?>
								</td>
							</tr>
							<tr>
								<td style="width:475pt" colspan="2">
									<?php $i = 0;
									while ($row8 = pg_fetch_row($result8)) {
										$i++
									?>
										<?= $i ?>) <b><?= $row8[5] ?> <?= $row8[3] ?></b> (cnp:<?= $row8[20] ?>) <?= $row8[6] == 'true' ? 'Defunct' : '' ?>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<?php
				$sql7 = "SELECT iuid, identifier FROM cg_iu where buildingid in (SELECT buildingid FROM cg_building WHERE landid = " . $landid . ") order by identifier";
				$result7 = pg_query($conn, $sql7);
				while ($row7 = pg_fetch_row($result7)) {
				?>
					<h3>Unitati individuale - constructia C1 - U<?= $row7[1] ?></h3>
					<table>
						<tbody>
							<tr>
								<th style="width:350pt" colspan="2">
									Inscrieri privitoare la dreptul de proprietate şi alte drepturi reale
								</th>
								<th style="width:150pt">
									Referinţe
								</th>
							</tr>
							<?php
							$sql6 = "SELECT * FROM cg_registration left join cg_deed on cg_registration.deedid = cg_deed.deedid
						WHERE (lbpartno=2) and (registrationid in (select registrationid from cg_registrationxentity where 
						iuid =" . $row7[0] . ")) ORDER BY position";
							$result6 = pg_query($conn, $sql6);
							while ($row6 = pg_fetch_row($result6)) {

								$sql8 = "SELECT * FROM cg_person WHERE registrationid=" . $row6[0];
								$result8 = pg_query($conn, $sql8);
							?>

								<tr>
									<td style="width:500pt; text-align: left" colspan="3">
										<?= $row6[15] ?>/ <?= $row6[16] ?>
									</td>
								</tr>
								<tr>
									<td style="width:500pt; text-align: left" colspan="3">
										<?= str_replace("_", " ", $row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
									</td>
								</tr>
								<tr>
									<td style="width:25pt" rowspan="2">
										B<?= $row6[14] ?>
									</td>
									<td style="width:325pt">
										<?php
										if ($row6[1] <> "NOTATION") {
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
										echo "A1.1." . $row7[1];
										?>
									</td>
								</tr>
								<tr>
									<td style="width:475pt" colspan="2">
										<?php $i = 0;
										while ($row8 = pg_fetch_row($result8)) {
											$i++
										?>
											<?= $i ?>) <b><?= $row8[5] ?> <?= $row8[3] ?></b> (cnp:<?= $row8[20] ?>) <?= $row8[6] == 'true' ? 'Defunct' : '' ?><br>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

				<?php } ?>
				<p><br></p>
				<h1 style="text-align: center;">C. Partea III. SARCINI</h1>


				<table>
					<tbody>
						<tr>
							<th style="width:350pt" colspan="2">
								Inscrieri privind dezmembramintele dreptului de proprietate, drepturi reale de garanţie şi sarcini
							</th>
							<th style="width:150pt">
								Referinţe
							</th>
						</tr>
						<?php
						$sql6 = "SELECT * FROM cg_registration left join cg_deed on cg_registration.deedid = cg_deed.deedid
						WHERE (lbpartno=3) and (registrationid in (select registrationid from cg_registrationxentity where 
						(landid =" . $landid . ") or (buildingid in (SELECT buildingid from cg_building where landid = " . $landid . ")))) ORDER BY position";
						$result6 = pg_query($conn, $sql6);
						if (pg_num_rows($result6) == 0) {
						?>
							<tr>
								<td style="width:500pt; text-align: left" colspan="3">
									Nu sunt
								</td>
							</tr>
						<?php
						}
						while ($row6 = pg_fetch_row($result6)) {

							$sql8 = "SELECT * FROM cg_person WHERE registrationid=" . $row6[0];
							$result8 = pg_query($conn, $sql8);

							$sql9 = "SELECT cg_building.buildno FROM cg_building, cg_registrationxentity WHERE (cg_building.buildingid=cg_registrationxentity.buildingid) and
							(cg_registrationxentity.registrationid=" . $row6[0]  . ") order by buildno";
							$result9 = pg_query($conn, $sql9);

							$sql10 = "SELECT landid FROM cg_registrationxentity WHERE (registrationid=" . $row6[0] . ") and(landid > 0)";
							$result10 = pg_query($conn, $sql10);

							if (pg_num_rows($result10) > 0) {
								$a1 = "A1, ";
							} else {
								$a1 = "";
							}
						?>

							<tr>
								<td style="width:500pt; text-align: left" colspan="3">
									<?= $row6[15] ?>/ <?= $row6[16] ?>
								</td>
							</tr>
							<tr>
								<td style="width:500pt; text-align: left" colspan="3">
									<?= str_replace("_", " ", $row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
								</td>
							</tr>
							<tr>
								<td style="width:25pt" rowspan="2">
									C<?= $row6[14] ?>
								</td>
								<td style="width:325pt">
									<?php
									if ($row6[1] <> "NOTATION") {
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
									while ($row9 = pg_fetch_row($result9)) {
										echo "A1." . $row9[0] . ", ";
									}
									?>
								</td>
							</tr>
							<tr>
								<td style="width:475pt" colspan="2">
									<?php $i = 0;
									while ($row8 = pg_fetch_row($result8)) {
										$i++
									?>
										<?= $i ?>) <b><?= $row8[5] ?> <?= $row8[3] ?></b> (cnp:<?= $row8[20] ?>) <?= $row8[6] == 'true' ? 'Defunct' : '' ?><br>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>

				<?php
				$sql7 = "SELECT iuid, identifier FROM cg_iu where buildingid in (SELECT buildingid FROM cg_building WHERE landid = " . $landid . ") order by identifier";
				$result7 = pg_query($conn, $sql7);
				while ($row7 = pg_fetch_row($result7)) {
				?>
					<h3>Unitati individuale - constructia C1 - U<?= $row7[1] ?></h3>
					<table>
						<tbody>
							<tr>
								<th style="width:350pt" colspan="2">
									Inscrieri privind dezmembramintele dreptului de proprietate, drepturi reale de garanţie şi sarcini
								</th>
								<th style="width:150pt">
									Referinţe
								</th>
							</tr>
							<?php
							$sql6 = "SELECT * FROM cg_registration left join cg_deed on cg_registration.deedid = cg_deed.deedid
						WHERE (lbpartno=3) and (registrationid in (select registrationid from cg_registrationxentity where 
						iuid =" . $row7[0] . ")) ORDER BY position";
							$result6 = pg_query($conn, $sql6);
							if (pg_num_rows($result6) == 0) {
							?>
								<tr>
									<td style="width:500pt; text-align: left" colspan="3">
										Nu sunt
									</td>
								</tr>
							<?php
							}
							while ($row6 = pg_fetch_row($result6)) {

								$sql8 = "SELECT * FROM cg_person WHERE registrationid=" . $row6[0];
								$result8 = pg_query($conn, $sql8);
							?>

								<tr>
									<td style="width:500pt; text-align: left" colspan="3">
										<?= $row6[15] ?>/ <?= $row6[16] ?>
									</td>
								</tr>
								<tr>
									<td style="width:500pt; text-align: left" colspan="3">
										<?= str_replace("_", " ", $row6[20]) ?> <?= $row6[18] ?>, din <?= $row6[19] ?> emis de <?= $row6[21] ?>
									</td>
								</tr>
								<tr>
									<td style="width:25pt" rowspan="2">
										C<?= $row6[14] ?>
									</td>
									<td style="width:325pt">
										<?php
										if ($row6[1] <> "NOTATION") {
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
										echo "A1.1." . $row7[1];
										?>
									</td>
								</tr>
								<tr>
									<td style="width:475pt" colspan="2">
										<?php $i = 0;
										while ($row8 = pg_fetch_row($result8)) {
											$i++
										?>
											<?= $i ?>) <b><?= $row8[5] ?> <?= $row8[3] ?></b> (cnp:<?= $row8[20] ?>) <?= $row8[6] == 'true' ? 'Defunct' : '' ?><br>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

			<?php
				}
			}
			pg_close($conn);
			?>
		</div>
	</div>
</div>

<?php include('partials/footer.php'); ?>