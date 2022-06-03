<!DOCTYPE html>
<html lang="en" >
<head>
	<header class="header">
<link rel="stylesheet" href="./styles/style2.css">
  <a href="#" class="logo">Planning</a>
  <button class="header__btn_open-topnav header__btn"><span class="icon-menu-open"></span></button>
  <ul class="topnav topnav_mobile_show">
    <button class="header__btn_close-topnav header__btn"><span class="icon-menu-close"></span></button>
    <li class="topnav__item">
      <a href="index---.php" class="topnav__link">Gestion Employés</a>
    </li>
    <li class="topnav__item">
      <a href="Pointage.php" class="topnav__link">Planning Pointage</a>
    </li>
  </ul>
</link>
</header>
  <meta charset="UTF-8">
  <title>CodePen - Bootstrap Crud Data Table For Database with Modal Form.</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" defer></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" defer></script><link rel="stylesheet" href="./styles/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<!DOCTYPE html>
<html lang="en">
<head>
<style>
	@media print {
		body * {
			visibility: hidden;
		}
		.modal-content * {
			visibility: visible;
			overflow: visible;
		}
		.main-page * {
			display: none;
		}
		.modal {
			position: absolute;
			left: 0;
			top: 0;
			margin: 0;
			padding: 0;
			min-height: 550px;
			visibility: visible;
			overflow: visible !important; /* Remove scrollbar for printing. */
		}
		.modal-dialog {
			visibility: visible !important;
			overflow: visible !important; /* Remove scrollbar for printing. */
		}
		#mailgroup {
			display: none;
		}
		#adressegroup{
			display : none;
		}
		#numerogroup {
			display : none;
		}
		#boutonimprimer {
			display : none;
		}
		#entete_show {
			display : none;
		}
		#bas_show {
			display : none;
		}
	}
</style>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bootstrap CRUD Data Table for Database with Modal Form</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js" ></script>
  
<body>

<!-- Vérification si l'utilisateur est bien connecté -->
<?php
	session_start();
	if (!isset($_SESSION['username']) || $_SESSION['username']!='admin' ) {
		header("location: Login.php");
		exit;
	}
	session_write_close();
?>


			<div class="container">
			<az id="nonPrintable">
				<div class="table-wrapper">
					<div class="table-title">
						<div class="row">
							<div class="col-sm-6">
								<h2>Gestion <b>Employés</b></h2>
							</div>
							<div class="col-sm-6">
								<a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">&#xE147;</i> <span>Ajoute un nouvel employé</span></a>
								<a href="deconnexion.php" class="btn btn-danger"><i class="material-icons">&#xE15C;</i> <span>Déconnexion</span></a>				
							</div>
						</div>
					</div>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>
									<span class="custom-checkbox">
										<input type="checkbox" id="selectAll">
										<label for="selectAll"></label>
									</span>
								</th>
								<th>Nom</th>
								<th>Email</th>
								<th>Adresse</th>
								<th>Numéro de téléphone</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<h3>
							<?php

							// On détermine sur quelle page on se trouve
							if(isset($_GET['page']) && !empty($_GET['page'])){
								$currentPage = (int) strip_tags($_GET['page']);
							}else{
								$currentPage = 1;
							}

							// On se connecte à là base de données
							require_once("Connexion.php");

							// On détermine le nombre total d'utilisateurs
							$recuppersonne = 'SELECT COUNT(*) as nb_user  FROM user;';

							// On prépare la requête
							$query = $connexion->prepare($recuppersonne);

							// On exécute
							$query->execute();

							// On récupère le nombre d'utilisateurs
							$result = $query->fetch();

							$nbuser = (int) $result['nb_user'];

							// On détermine le nombre d'utilisateurs par page
							$parPage = 10;

							// On calcule le nombre de pages total
							$pages = ceil($nbuser / $parPage);

							// Calcul du 1er utilisateur de la page
							$premier = ($currentPage * $parPage) - $parPage;

							$sql = 'SELECT * FROM user ORDER BY ID ASC LIMIT :premier, :parpage;';

							// On prépare la requête
							$query = $connexion->prepare($sql);

							$query->bindValue(':premier', $premier, PDO::PARAM_INT);
							$query->bindValue(':parpage', $parPage, PDO::PARAM_INT);

							// On exécute
							$query->execute();

							// On récupère les valeurs dans un tableau associatif
							$usernb = $query->fetchAll(PDO::FETCH_ASSOC);

							?>
							<?php

							foreach ($usernb as $users) 
							{
								// Affichage des champs
								echo '</h3>
								<tr>
									<td>
										<span class="custom-checkbox">
											<input type="checkbox" id="checkbox1" name="',$users['ID'],'" value="">
											<label for="checkbox1"></label>
										</span>
									</td>
									<td style="cursor:pointer;" href="#showEmployeeModal" data-toggle="modal" class="voiremploye" name="voiremploye" id="',$users['ID'],'">';
									echo $users['Nom']; 
									echo '</td>
									<td style="cursor:pointer;" href="#showEmployeeModal" data-toggle="modal" class="voiremploye" name="voiremploye" id="',$users['ID'],'">';
									echo $users['Email'];
									echo '</td>
									<td style="cursor:pointer;" href="#showEmployeeModal" data-toggle="modal" class="voiremploye" name="voiremploye" id="',$users['ID'],'">'; 
									echo $users['Adresse'];
									echo '</td>
									<td style="cursor:pointer;" href="#showEmployeeModal" data-toggle="modal" class="voiremploye" name="voiremploye" id="',$users['ID'],'">';
									echo $users['Telephone'];
									echo '
									<td>
										<a href="#editEmployeeModal"  data-toggle="modal"><i class="material-icons edit" data-toggle="tooltip" name="editbutton" title="Modifier"  id="',$users['ID'],'">&#xE254;</i></a>
										<a href="#deleteEmployeeModal" data-toggle="modal"><i class="material-icons delete" data-toggle="tooltip" name="deletebutton" title="Supprimer" id=',$users['ID'],'">&#xE872;</i></a>
									</td>
								</tr> </h3>';
								
							}
							?>
						</tbody>
					</table>
					<div class="clearfix">
						<div class="hint-text">Total de <b>

						<?php 
						echo $nbuser;
						?>

						</b> éléments
							<main class="container">
								<div class="row">
									<section class="col-12">
									<nav>
									<ul class="pagination">
										<!-- Lien vers la page précédente (désactivé si on se trouve sur la 1ère page) -->
										<li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
											<a href="?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
										</li>
										<?php for($page = 1; $page <= $pages; $page++): ?>
										<!-- Lien vers chacune des pages (activé si on se trouve sur la page correspondante) -->
										<li class="page-item <?= ($currentPage == $page) ? "active" : "" ?>">
												<a href="?page=<?= $page ?>" class="page-link"><?= $page ?></a>
											</li>
										<?php endfor ?>
										<!-- Lien vers la page suivante (désactivé si on se trouve sur la dernière page) -->
										<li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
											<a href="?page=<?= $currentPage + 1 ?>" class="page-link">Suivante</a>
										</li>
									</ul>
									</nav>
									</section>
								</div>
							</main>
					</div>
				</div>
			</div>
			</az>
			<!-- Show Modal HTML -->
			<div id="showEmployeeModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" action="" >
							<div class="modal-header" id="entete_show">						
								<h4 class="modal-title">Information de l'employé</h4>
								<button type="button" name="close" id="close" class="close" onClick="window.location.reload();" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">					
								<div class="form-group" id="nomgroup">
									<label>Nom</label>
									<input type="text" class="form-control" name="nomvoir" id="nomvoir" readonly required>
								</div>
								<div class="form-group" id="mailgroup">
									<label>Email</label>
									<input type="email" class="form-control" name="mailvoir" id="mailvoir" readonly required>
								</div>
								<div class="form-group" id="adressegroup">
									<label>Adresse</label>
									<textarea class="form-control" name="adressevoir" id="adressevoir" readonly required></textarea>
								</div>
								<div class="form-group" id="numerogroup">
									<label>Numéro de téléphone</label>
									<input type="text" class="form-control" name="numerovoir" id="numerovoir" readonly required>
								</div>
								<div id="qrcode-container" name="qrcode-container" style="text-align:center;">
									<h4>QRcode</h4>
									<img id="qrcode">
								</div>					
							</div>
							<div class="modal-footer" id="bas_show">
							<a href="javascript:window.print()" id ="boutonimprimer" class="btn btn-primary pull-right">Imprimer</a>
							<button type="submit" name="envoyer_mail" id="envoyer_mail" value="envoyer_mail" class="btn btn-primary pull-right" style="margin-right:120px;" >Envoyer Mail</button>
							<input type="hidden" name="qr64" id="qr64" class ="qr64"></div>
							<az id="nonPrintable">
							<?php													 
							use PHPMailer\PHPMailer\PHPMailer;
							use PHPMailer\PHPMailer\Exception;
							require 'PHPMailer/PHPMailer/src/Exception.php';
							require 'PHPMailer/PHPMailer/src/PHPMailer.php';
							require 'PHPMailer/PHPMailer/src/SMTP.php';


							if(isset($_POST['envoyer_mail'])){
							$qrcode64 = $_POST['qr64'];
							$mail_cookie = $_COOKIE['Mail'];
							$nom_cookie = $_COOKIE['Nom'];
							$mail = new PHPMailer();
							$mail->IsSMTP();
							
							
							$mail->SMTPDebug  = 0;  
							$mail->SMTPAuth   = TRUE;
							$mail->SMTPSecure = "tls";
							$mail->Port       = 587;
							$mail->Host       = "smtp.gmail.com";
							$mail->Username   = "anisdev6@gmail.com";
							$mail->Password   = "Developpeur13!";

							$mail->IsHTML(true);
							$mail->AddAddress($mail_cookie, $nom_cookie);
							$mail->SetFrom("anisdev6@gmail.com", "Anis BotDev");
							$mail->Subject = "QRCode $nom_cookie";
							$mail->Body= "<h2> Bonjour $nom_cookie,</h1> 
										<h3>Voici Votre QrCode : </h3><br> <br>
										<img alt='QrCode' src='$qrcode64'>";

							$mail->MsgHTML($mail->Body); 
							
							if(!$mail->Send()) {
								echo "Error while sending Email.";
								var_dump($mail);
							} else {
								echo " ";
							}
							
						 } 
							?>
							</div>
						</form>
						
					</div>
				</div>
			</div>
			
			<!-- Add Modal HTML -->
			<div id="addEmployeeModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" action="" >
							<div class="modal-header">						
								<h4 class="modal-title">Ajouter un employé</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">					
								<div class="form-group">
									<label>Nom</label>
									<input type="text" class="form-control" name="nomajouter" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="mailajouter" required>
								</div>
								<div class="form-group">
									<label>Adresse</label>
									<textarea class="form-control" name="adresseajouter" required></textarea>
								</div>
								<div class="form-group">
									<label>Numéro de téléphone</label>
									<input type="text" class="form-control" name="numeroajouter" required>
								</div>					
							</div>
							<div class="modal-footer">
								<input type="reset" class="btn btn-default" data-dismiss="modal" value="Annuler">
								<input type="Submit" class="btn btn-success" name="Ajouter" value="Ajouter">

							<?php
							// Ici si l'utilisateur clique sur le bouton ajouter alors les valeurs sont directement ajouter dans la bdd dans la table user //
								if (isset($_POST['Ajouter'])) {
									$ajouterpersonne = $connexion->query("INSERT INTO user VALUES (null, '{$_POST['nomajouter']}', '{$_POST['mailajouter']}', '{$_POST['adresseajouter']}', '{$_POST['numeroajouter']}')");
									echo "<meta http-equiv='refresh' content='0'>";
								}
							?>

							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Edit Modal HTML -->
			<div id="editEmployeeModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" action ="" >
							<div class="modal-header">						
								<h4 class="modal-title">Modifier un employé</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">					
								<div class="form-group">
									<label>Nom</label>
									<input id="identifiant" name="identifiant" type="hidden" >
									<input type="text" class="form-control" name="nommodifier" id="nommodifier" required>
								</div>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="mailmodifier" id="mailmodifier" required>
								</div>
								<div class="form-group">
									<label>Adresse</label>
									<textarea class="form-control" name="adressemodifier" id="adressemodifier" required></textarea>
								</div>
								<div class="form-group">
									<label>Numéro de téléphone</label>
									<input type="text" class="form-control" name="numeromodifier" id="numeromodifier" required>
								</div>					
							</div>
							<div class="modal-footer">
								<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
								<input type="submit" class="btn btn-info" name="Sauvegarder" value="Save">

								<?php
									if (isset($_POST['Sauvegarder'])) {
										$modifierpersonne = $connexion->query("UPDATE user Set Nom ='{$_POST['nommodifier']}', Email = '{$_POST['mailmodifier']}', Adresse = '{$_POST['adressemodifier']}', Telephone ='{$_POST['numeromodifier']}' WHERE ID = '{$_POST['identifiant']}'");
										echo "<meta http-equiv='refresh' content='0'>";
									}
								?>

							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Delete Modal HTML -->
			<div id="deleteEmployeeModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<form method="POST" action="" >
							<div class="modal-header">						
								<h4 class="modal-title">Supprimer un employé</h4>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<div class="modal-body">
								<input id="identifiant2" name="identifiant2" type="hidden" >					
								<p>Êtes-vous sur de vouloir supprimer l'employé ?</p>
								<input type="hidden" class="form-control" name="nomsupprimer" id="nomsupprimer" required>
								<p class="text-warning"><small>Cette action ne pourra pas être anulée.</small></p>
							</div>
							<div class="modal-footer">
								<input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
								<input type="submit" class="btn btn-danger" name="validation_supprimer" value="Supprimer l'Employe">

								<?php
									if (isset($_POST['validation_supprimer'])) {
										$supprimerpersonne = $connexion->query("DELETE FROM user WHERE ID = '{$_POST['identifiant2']}'");
										echo "<meta http-equiv='refresh' content='0'>";
									}
									//$i =0;
									//for (i=0;i<$recuppersonne;i++) {
									//	if (isset($_POST[$i]))
									//}

								?>

							</div>
						</form>
					</div>
				</div>
			</div>
			</az>
</body>
</html>
<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

  <script  src="./script.js"></script>

  <script>

	$(".edit").click(function(){
		var id_row = $(this).attr("id");
 
		$.ajax({
			type: "POST",
			url: 'get_employe_by_id.php',
			data: { id_row : id_row },
			success: function(data)
			{
				data = JSON.parse(data);
				document.getElementById("nommodifier").value = data.Nom;
				document.getElementById("mailmodifier").value = data.Email;
				document.getElementById("adressemodifier").value = data.Adresse;
				document.getElementById("numeromodifier").value = data.Telephone;
				document.getElementById("identifiant").value = data.ID;
			}
		});
	});
	
</script>


<script>
	$(".delete").click(function(){
		var id_row = $(this).attr("id");
 
		$.ajax({
			type: "POST",
			url: 'get_employe_by_id.php',
			data: { id_row : id_row },
			success: function(data)
			{
				data = JSON.parse(data);
				document.getElementById("identifiant2").value = data.ID;
				document.getElementById("nomsupprimer").value = data.Nom;
			}
		});
	});
</script> 


<script>
	$(".voiremploye").click(function(){
		var id_row = $(this).attr("id");
		$.ajax({
			type: "POST",
			url: 'get_employe_by_id.php',
			data: { id_row : id_row },
			success: function(data)
			{
				data = JSON.parse(data);
				document.getElementById("nomvoir").value = data.Nom;
				document.getElementById("mailvoir").value = data.Email;
				document.getElementById("adressevoir").value = data.Adresse;
				document.getElementById("numerovoir").value = data.Telephone;
				var Nom = data.Nom;
				var Mail = data.Email;
				var Adresse = data.Adresse;
				var Telephone = data.Telephone;
				var QrCode = creerQRC(Mail);
				var src_qrcode = document.getElementById('qrcode').src;
				document.getElementById("qr64").value = src_qrcode;
				createCookie("Mail",Mail,"1");
				createCookie("Nom",Nom,"1");			}
		});
	});
</script> 


<script>
	function createCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  let expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
</script>

<script>
			function creerQRC(a) {
			var url = a;
			var qrcode = 'https://chart.googleapis.com/chart?cht=qr&chl=' + encodeURIComponent(url) + '&chs=200x200&choe=UTF-8&chld=L|0';
			document.getElementById("qrcode").src = qrcode;
			}
</script>


<!-- <script type="text/javascript" >
	function generateQRCode(a){
	$("#qrcode").html("");
	new QRCode(document.getElementById("qrcode"), a);}
</script> -->

<script>
      function functionPrint() {
        document.getElementById("nonPrintable").className += "noPrint";
        window.print();
    }
</script>


<!-- Script qui permet de refresh la page sans que les données ne soient envoyées 2 fois -->
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>