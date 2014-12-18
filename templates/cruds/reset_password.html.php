<?php
global $util ;
$util->set_home( 1 ) ;
$session = "crud" ;
header( "Content-type: application/json" );
if (  $_POST['email'] != "" ) { 
	$email = "'".$_POST['email']."'";
}
else{
	$email="null";
}
if ($_POST['user'] != "" ) { 
	$user = "'".$_POST['user']."'";
}
else{
	$user="null";
}	
$code = "CALL `spAppRecuperaSenha` (".$email.", ".$user.", '".$_POST["chaveContratante"]."',@pStatusProc);";
if (mysqli_multi_query($util->configs, $code)) {
	do {
		if ($r = mysqli_store_result($util->configs)) {
			while ($row = mysqli_fetch_assoc($r)) {
				$senha = $util->urlsafe_b64decode($row['Senha']);
				$email = $row['Email'];
				$nome = $row['Nome'];
				$user = $row['Usuario'];
			}
			mysqli_free_result($r);

		}
	} while (mysqli_next_result($util->configs) && (mysqli_more_results($util->configs)));
}
$code =" SELECT @pStatusProc AS  'pStatusProc'";



// subject
$subject = 'Dados de Acesso Appolo';

// message
$message = '<html>
	<head>
		<title>Dados de Acesso Appolo</title>
			  <style type="text/css">
				body {
					font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
					font-size: 14px;
					padding-bottom: 3.50em;
					background: #FFF;
					margin-right: auto;
				}
				h1{
					color: #D9913D;
					text-align: center;
				}
	

				.second{
					border-radius: 40px;
					width: 100%;
					max-width: 400px;
					min-width: 230px;
					margin: auto;
					margin-bottom: 2%;
					border: 1px solid #ccc;
					box-shadow: 7px 7px 9px #333;
					padding: 0 20px 20px 20px;
				}
			  </style>
	</head>
	<body>
		<div >
			<h1>Dados de acesso Appolo</h1>
			<div class="second">
				<p>
					Olá '.$nome.', conforme foi solicitado* em nosso sistema Appolo segue seus dados para que acesse ao sistema. Recomendamos que após o acesso efetue a troca da senha.
				</p>
				<p>
					<h8><b>E-mail: </b>'.$email.'</h8>
				</p>
				<p>
					<h8><b>Senha: </b>'.$senha.'</h8>
				</p>
				<p>
					<h8><b>Usuário: </b>'.$user.'</h8>
				</p>
					<h8><b>*PS:</b>Caso não tenha feito esta solicitação favor desconsiderar o e-mail e se possível troque a senha para uma maior segurança</h8>
			</div>	
		</div>
		<div>
			<h12><b>© Copyright Guia Tech. Todos os direitos reservados.</b></h12>
		</div>
	</body>
</html>';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$nome.'' . "\r\n";
$headers .= 'From: Appolo ' . "\r\n";
// Mail it

$enviaremail = mail($email, $subject, $message, $headers);

    if($enviaremail){
    	$util->set_session( "warn",  "23");
    } else {
    	$util->set_session( "warn",  "1");
    }
header('Location: '.APPOLO_LOGIN.'');

?>





