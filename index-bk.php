<?php include ('partials/connect.php'); ?>
<?php include ('partials/header.php'); ?>


<!-- Introduction -->
<div class="section">
	<div class="container">
		
		<div class="units-row units-split wrap">
			

			<?php
			$sql1_result=select_from_land_CADGENNO('10019');
			if ($sql1_result->num_rows > 0) {
				$sql1_result_data=$sql1_result->fetch_assoc();
			} else {
				echo "0 results";
			}
			?>

			<?php
			$sql2_result=select_from_parcel_CADGENNO('10019');
			if ($sql2_result->num_rows > 0) {
				$sql2_result_data=$sql2_result->fetch_assoc();
			} else {
				echo "0 results";
			}

			//print_r($sql2_result_data);
			?>

			<?php
			$sql4_result=select_from_address_CADGENNO('10019');
			if ($sql4_result->num_rows > 0) {
				$sql4_result_data=$sql4_result->fetch_assoc();
			} else {
				echo "0 results";
			}
			?>

			<p>Date despre imobilul nr. <?= $sql1_result_data["CADGENNO"] ?> Comuna/Oraş/Municipiu: <strong>Cernat</strong> <br>
			  DATE DESPRE IMOBILUL NR. <strong><?= $sql1_result_data["CADGENNO"] ?></strong></p>
			<h2>A. Partea I. Descrierea imobilului</h2>
			<table>
				<tr>
					<td align="left">
						<strong>Intravilan</strong>
					</td>
					<td align="right">
						<strong>Identificator electronic:</strong>
						<?= $sql1_result_data["E2IDENTIFIER"]; ?>
						<br>
						<strong>Nr. CAD vechi:</strong>
						<?= $sql1_result_data["PAPERLBNO"]; ?>
						<br>

						<strong>Nr. CF vechi:</strong><?= $sql1_result_data["PAPERLBNO"] ?>

					</td>
					
				</tr>
				<tr>
					<td align="left"><strong>Adresa:</strong> 
						<?= strtolower($sql4_result_data["STREETTYPE"]); ?>
						<?= $sql4_result_data["STREETNAME"] . ',' ?>
						<?= 'nr:'.$sql4_result_data["POSTALNUMBER"] . ',' ?>
						<?= $sql4_result_data["BLOCK"] == '0' ? '' : $sql4_result_data["BLOCK"]. ',' ?>
						<?= $sql4_result_data["ENTRY"] == '0' ? '' : $sql4_result_data["ENTRY"]. ',' ?>
						<?= $sql4_result_data["FLOOR"] == '0' ? '' : $sql4_result_data["FLOOR"]. ',' ?>
						<?= $sql4_result_data["APNO"] == '0' ? '' : $sql4_result_data["APNO"]?>
						<?= 'Cod postal:' . $sql4_result_data["ZIPCODE"]. ',' ?>
						<?= $sql4_result_data["DESCRIPTION"] ?>
					</td> 
					<td align="right"><strong>Nr. topografic:</strong><?= $sql1_result_data["TOPONO"] ?></td>
				</tr>
			</table>
			<table>
				<tr>
					<td><strong>Nr. Crt</strong>
					</td>
					<td>
						<strong>Nr cadastral <br> Nr. topografic</strong>
					</td>
					<td>
						<strong>Suprafaţa* (mp)</strong>
					</td>
					<td><strong>Observaţii / Referinţe
										</strong></td>
				</tr>
				<tr>
					<td>
						A1
					</td>
					<td><?= $sql1_result_data["E2IDENTIFIER"] ?>
					</td>
					<td><?= $sql1_result_data["MEASUREDAREA"] ?>
					</td>
					<td><?= $sql1_result_data["ENCLOSED_RES"]===true ? 'Teren imprejmuit' :  'Teren neimprejmuit'; ?>
						 <?= $sql1_result_data["NOTES"] ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="container">
		
		<div class="units-row units-split wrap">
			<h2>B. Partea II. Proprietari şi acte</h2>

			<h3>Date referitoare la teren</h3>
			<table>
				<tr>
					<td><strong>Crt</strong>
					</td>
					<td>
						<strong>Categorie
						folosință</strong>
					</td>
					<td>
						<strong>Categorie
						folosință</strong>
					</td>
					<td><strong>Suprafaţa
						(mp) 
					</strong></td>
					<td><strong>Parcele
						(mp) 
					</strong></td>
					<td><strong>Parcelă 
						(mp) 
					</strong></td>
					<td><strong>Nr. topo
						(mp) 
					</strong></td>
					<td><strong>Observaţii / Referinţe
						(mp) 
					</strong></td>
				</tr>
				<tr>
					<td><?= $sql2_result_data["NUMBER"] ?>
					</td>
					<td><?= $sql2_result_data["USECATEGORY"] ?>
					</td>
					<td><?= $sql2_result_data["INTRAVILAN"]===true ? 'DA' :  'NU'; ?>
					</td>
					<td><?= $sql2_result_data["MEASUREDAREA"] ?>
					</td>
					<td><?= $sql2_result_data["LANDPLOTNO"] ?>
					</td>
					<td><?= $sql2_result_data["PARCELNO"] ?>
					</td>
					<td><?= $sql2_result_data["PARCELNO"] ?>
					</td>
					<td><?= $sql2_result_data["NOTES"] ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<!-- Work Experience -->
<div class="work section second" id="experiences">
	<div class="container">
		<h1>Work<br>Experiences</h1>
		<ul class="work-list">
			<li>2014-2015</li>
			<li><a href="#">PT Traveloka Indonesia</a></li>
			<li>Web Designer</li>
		</ul>
		<ul class="work-list">
			<li>2014-2015</li>
			<li><a href="#">Wego</a></li>
			<li>UI/UX Designer</li>
		</ul>
		<ul class="work-list">
			<li>2014-2015</li>
			<li><a href="#">Garuda Indonesia</a></li>
			<li>System Designer</li>
		</ul>
	</div>
</div>
<!-- Award & Achievements -->
<div class="award section second" id="achievements">
	<div class="container">
		<h1>Award &amp;<br>Achievements</h1>
		<ul class="award-list list-flat">
			<li>January 2014</li>
			<li>Attained PHP5 certification</li>
			<li>Hold world/Olympic record</li>
		</ul>
		<ul class="award-list list-flat">
			<li>December 2014</li>
			<li>Audited X number of clients in only Y amount of time</li>
			<li>Held a perfect attendance record</li>
			<li>Were promoted after only X months in the role</li>
		</ul>
		<ul class="award-list list-flat">
			<li>March 2014</li>
			<li>Placed employees at X companies</li>
			<li>United multiple teams post-merger</li>
		</ul>
	</div>
</div>
<!-- Technical Skills -->
<div class="skills section second" id="skills">
	<div class="container">
		<h1>Technical<br>Skills</h1>
		<ul class="skill-list list-flat">
			<li>Web Technology</li>
			<li>HTML / CSS / SASS / PHP / Javascript</li>
		</ul>
		<ul class="skill-list list-flat">
			<li>Database</li>
			<li>MySQL / MongoDB / Oracle / Access</li>
		</ul>
		<ul class="skill-list list-flat">
			<li>Framework</li>
			<li>Laravel / CodeIgniter / Zend / Ruby On Rails</li>
		</ul>
	</div>
</div>
<!-- Quote -->
<div class="quote">
	<div class="container text-centered">
		<h1>fight against the ugliness.</h1>
	</div>
</div>


<?php include ('partials/footer.php'); ?>
