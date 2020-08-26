<?php
require_once('config.inc.php');
session_start();

//Fonction pour afficher les événements de AAPIF
function FindEvents($pdo)
{
	$sql = 'SELECT IDEVENTS,NOMEVENTS,AUTEUR,DATEVENTS,HEUREDEBUT,DESCRIPTION from events
                        ORDER BY DATEVENTS desc
                        LIMIT 0,50';

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch (Exception $e) {
		die('Erreur evenement '.$e->getMessage());
	}
}

//Fonction pour afficher les événements des partenaires
function FindEventsPartenaire($pdo)
{
	$sql = 'SELECT IDEVENTS,NOMEVENTS,AUTEUR,DATEVENTS,HEUREDEBUT,DESCRIPTION from events_partenaires
                            ORDER BY DATEVENTS desc
                            LIMIT 0,50';

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch (Exception $e) {
		die('Erreur evenement partenaire '.$e->getMessage());
	}
}

//Fonction pour afficher les événements Récents
function FindRecentEvents($pdo)
{
	$sql = 'SELECT IDEVENTS,NOMEVENTS,AUTEUR,DATEVENTS,HEUREDEBUT,DESCRIPTION from events
                        ORDER BY DATEVENTS desc
                        LIMIT 0,6';

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch (Exception $e) {
		die('Erreur evenement '.$e->getMessage());
	}
}

//Fonction pour recupérer les images des événements
function FindImage($pdo, $IDEVENTS)
{
	$sql = 'SELECT * FROM images WHERE IDEVENTS='.$IDEVENTS.'
                    LIMIT 0,1';

	try{
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch(Exception $e) {
		die('Erreur images '.$e->getMessage());
	}
}

//Fonction pour recupérer les vidéos des evenements
function FindVideos($pdo, $IDEVENTS)
{
	$sql = 'SELECT * FROM videos WHERE IDEVENTS='.$IDEVENTS.'
                        LIMIT 0,1';

	try{
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch(Exception $e) {
		die('Erreur videos '.$e->getMessage());
	}
}

//Fonction pour afficher les détails des evenements de AAPIF
function GetDetail($pdo, $IDEVENTS)
{
	$sql = 'SELECT IDEVENTS,NOMEVENTS,AUTEUR,DATEVENTS,HEUREDEBUT,DESCRIPTION from events
                    WHERE IDEVENTS = '.$IDEVENTS.'
                    LIMIT 0,1
                    ';

	try{
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch(Exception $e) {
		die('Erreur details '.$e->getMessage());
	}
}

//Fonction pour afficher les détails des evenements des partenaires
function GetDetailPartenaires($pdo, $IDEVENTS)
{
	$sql = 'SELECT IDEVENTS,NOMEVENTS,AUTEUR,DATEVENTS,HEUREDEBUT,DESCRIPTION from events_partenaires
                        WHERE IDEVENTS = '.$IDEVENTS.'
                        LIMIT 0,1
                        ';

	try{
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetch();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch(Exception $e) {
		die('Erreur details evenements partenaire '.$e->getMessage());
	}
}

//Liste des images pour les détails des evenements
function Liste_photo_par_events($pdo, $IDEVENTS)
{
	$sql = 'SELECT * FROM images WHERE IDEVENTS= '.$IDEVENTS.'
           ';

	try
	{
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetch(PDO::FETCH_NUM);
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch(Exception $e) {
		die('Erreur images '.$e->getMessage());
	}
}

//Enregistrement des commentaires
function Save_comments($pdo,$message,$IDEVENTS,$IDUTIL)
{
	$sql = 'INSERT INTO comments(IDEVENTS,IDUTIL,DATECOMMENTS,MESSAGE) VALUES (:IDEVENTS,:IDUTIL,NOW(),:MESSAGE)';

	try{
		$prep = $pdo->prepare($sql);
		$prep->bindValue(':MESSAGE',$message,PDO::PARAM_INT);
		$prep->bindValue(':IDEVENTS',$IDEVENTS,PDO::PARAM_INT);
		$prep->bindValue(':IDUTIL',$IDUTIL,PDO::PARAM_INT);
		$prep->execute();
	} catch (Exception $e) {
		die('Erreur commentaire '.$e->getMessage());
	}
}

//Afficher les commentaires de chaque evenement
function Liste_comments($pdo,$IDEVENTS)
{
	$sql = 'SELECT IDCOMMENTS,IDEVENTS,PRENOM,NOM,DATECOMMENTS,MESSAGE
                FROM comments
                INNER JOIN utilisateur ON comments.IDCOMMENTS = utilisateur.IDUTIL
                WHERE IDEVENTS = '.$IDEVENTS.'
                ORDER BY DATECOMMENTS DESC
                ';

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch (Exception $e) {
		die('Erreur comments '.$e->getMessage());
	}
}

//Afficher les commentaires récents
function Recent_comments($pdo)
{
	$sql = 'SELECT IDCOMMENTS,IDEVENTS,PRENOM,NOM,DATECOMMENTS,MESSAGE
                FROM comments
                INNER JOIN utilisateur ON comments.IDCOMMENTS = utilisateur.IDUTIL
                ORDER BY DATECOMMENTS DESC
                LIMIT 0,5';

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetchAll();
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch (Exception $e) {
		die('Erreur comments '.$e->getMessage());
	}
}

//Afficher le nombre de commentaires pour chaque events
function Count_comment($pdo,$IDEVENTS)
{
	$sql = 'SELECT COUNT(IDCOMMENTS) FROM comments
               WHERE IDEVENTS = '.$IDEVENTS.'
               ';

	try {
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$arr = $stmt->fetch(PDO::FETCH_COLUMN);
		$stmt->closeCursor();
		$stmt = NULL;
		return $arr;
	} catch (Exception $e) {
		die('Erreur comments '.$e->getMessage());
	}
}

//Fonction pour inscrire un utilisateur
function Inscription($pdo,$prenom,$nom,$email,$password)
{
	$sql = 'INSERT INTO utilisateur(PRENOM,NOM,EMAIL,PASSWORD) VALUES (:PRENOM,:NOM,:EMAIL,:PASSWORD)';

	try{
		$prep = $pdo->prepare($sql);
		$prep->bindValue(':PRENOM',$prenom,PDO::PARAM_INT);
		$prep->bindValue(':NOM',$nom,PDO::PARAM_INT);
		$prep->bindValue(':EMAIL',$email,PDO::PARAM_INT);
		$prep->bindValue(':PASSWORD',$password,PDO::PARAM_INT);
		$prep->execute();
	} catch (Exception $e) {
		die('Erreur inscription '.$e->getMessage());
	}
}

//Fonction pour vérifier les identifiants de l'utilisateur
function Connection($pdo,$email,$password)
{
	$sql = 'SELECT IDUTIL,PASSWORD FROM utilisateur WHERE email ="'.$email.'" AND password="'.$password.'"';

	try
	{
		$prep = $pdo->prepare($sql);
		$prep->execute();
		$arrr = $prep->fetch();
		$prep->closeCursor();
		$prep = NULL;
		return $arrr;
	} catch (Exception $e) {
		die('Erreur Connection '.$e->getMessage());
	}
}

//Fonction qui gère l'envoi de mail
function SendMail($pdo,$nom,$email,$objet,$message)
{

	$sql = 'INSERT INTO contact(nom,email,objet,message) VALUES (:nom,:email,:objet,:message)';

	try{
		$prep = $pdo->prepare($sql);
		$prep->bindValue(':nom',$nom,PDO::PARAM_INT);
		$prep->bindValue(':email',$email,PDO::PARAM_INT);
		$prep->bindValue(':objet',$objet,PDO::PARAM_INT);
		$prep->bindValue(':message',$message,PDO::PARAM_INT);
		$prep->execute();
	} catch (Exception $e) {
		die('Erreur envoi mail '.$e->getMessage());
	}
}
?>