<?php
require_once('mysql_fonctions_membre.php');

//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
							//[form admin membre]//
//------------------------------------------------------------------------------------//
//------------------------------------------------------------------------------------//
function createMembreGestionForm(){

	$toReturn = '';
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?membre=gestion&page=1&order=membre_date_modif">Membres</a></span>gérer</h3>';
	
	$toReturn .='<hr/>';
	$toReturn .='<form action="admin_traitement_membre.php" method="post" enctype="multipart/form-data">';


	//-----------filtre de tri-----------//
	$toReturn .= '<p><select id="order" name="order">';
  	$toReturn .= '<option value="membre_date_modif"';
 	if($_GET['order']=="membre_date_modif"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par derniers modifiés</option>';
  	$toReturn .= '<option value="membre_date_inscription"';
  	if($_GET['order']=="membre_date_inscription"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>trier par derniers inscrits</option>'; 
 	$toReturn .= '<option value="pseudo"';
 	if($_GET['order']=="pseudo"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>trier par pseudo</option>';
 	
	$toReturn .= '</select></p>';
	////-----------filtre de tri-----------//
	$nb_element_par_page=50;
	// ------les dev les uns aux dessus des autres------- //
	$result = mysqlSelectAllMembresWithPageNumber($_GET['page'], $_GET['order'], $nb_element_par_page);
	$toReturn .='<fieldset>';
	$toReturn .='<table>';
	$toReturn .='<tr>
				<th class="center" ><input id="select_all" type="checkbox"/></th>
				<th></th>
				<th></th>
    			<th>pseudo</th>
    			<th>email</th>
    			<th>inscription</th>
    			<th>dernière connexion</th>
    			<th>groupe</th>
  				</tr>';
	while($data=mysql_fetch_array($result)) {
   		$toReturn .='<tr>';
		$toReturn .= '<td class="center"><input type="checkbox" name="membres[]" value="'.htmlspecialchars(trim($data["id_membre"])).'"/></td>';
		$toReturn .= '<td class="center delete_item_table"><a href="admin_traitement_membre.php?submit_membre=delete&id_membre='.htmlspecialchars(trim($data["id_membre"])).'&order='.$_GET['order'].'"><span>supprimer</span></a></td>';
		$toReturn .= '<td class="center edit_item_table"><a href="admin_traitement_membre.php?submit_membre=edit&id_membre='.htmlspecialchars(trim($data["id_membre"])).'&order='.$_GET['order'].'"><span>modifier</span></a></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["pseudo"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["email"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["membre_date_inscription"])).'</span></td>';
		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["membre_date_derniere_connexion"])).'</span></td>';

		$toReturn .= '<td><span>'.htmlspecialchars(trim($data["groupe"])).'</span></td>';
		$toReturn .='</tr>';
	}
	$toReturn .='</table>';
	$toReturn .='</fieldset>';
	
	$toReturn .='<p><input id="submit" type="submit" value="supprimer la selection" name="submit_membre"/></p>';

	// ------page------- //
	$resultDev = mysqlSelectAllMembres();
	$nbElements = mysql_num_rows($resultDev);	
	if(	ceil($nbElements/$nb_element_par_page) > 1){
	$toReturn .= '<div class="numeros_pages">';
	if($_GET['page']!=1){
		$toReturn .= '<a href="administration.php?membre=gestion&page='.($_GET['page']-1).'&order='.($_GET['order']).'"> << </a>';
	}
	$toReturn .='<select name="page" class="page_selector">';
	for($i = 1; $i <= ceil($nbElements/$nb_element_par_page); $i++){
		$toReturn .= '<option value="'.$i.'"';
		if($i == $_GET['page']){
			$toReturn .= 'selected="selected"';
		}
		$toReturn .= '>'.$i.'</option>';
	}
	$toReturn .='</select>';
	if($_GET['page']!=ceil($nbElements/$nb_element_par_page)){
		$toReturn .= '<a href="administration.php?membre=gestion&page='.($_GET['page']+1).'&order='.($_GET['order']).'"> >> </a>';
	}
	$toReturn .= '</div>';
	}
	// ------page------- //

	// ------les dev les uns aux dessus des autres------- //
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="membre"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
	
	
}

function createMembreEditForm(){
	$toReturn = '';
	$result = mysqlSelectMembreByID($_GET['id_membre']);
	$data=mysql_fetch_array($result);
	
	$toReturn .='<h3><span class="to_edit"><a href="administration.php?membre=gestion&page=1&order=membre_date_modif">Membres</a></span><span class="to_edit"><a href="administration.php?membre=edit&id_membre='.$_GET['id_membre'].'">'.$data['pseudo'].'</a></span>modifier</h3>';
	
	if($_GET['record']=="nok"){
			$toReturn .='<p class="message_alerte important_rouge">vérifier les champs obligatoires</p>';
		}
		else if($_GET['record']=="ok"){
			$toReturn .='<p class="message_alerte important_vert">enregistrement effectué</p>';
	}
		
	$toReturn .= '<form action="admin_traitement_membre.php?&id_membre='.htmlspecialchars(trim($data["id_membre"])).'" method="post" enctype="multipart/form-data">';

	$toReturn .='<fieldset>';
	
	$toReturn .='<p><label for="pseudo">pseudo: </label>';
	$toReturn .='<input id="pseudo" type="text" name="pseudo" value="'.htmlspecialchars(trim($data["pseudo"])).'" readonly/><span class="obligatoire"><span>oligatoire</span></span></p>';
		
	$toReturn .='<p><label for="email">email: </label>';
	$toReturn .='<input id="email" type="text" name="email" value="'.htmlspecialchars(trim($data["email"])).'" readonly/><span class="obligatoire"><span>oligatoire</span></span></p>';		

		
	//-----------groupe-----------//
	$toReturn .= '<p><label for="groupe">groupe: </label><select id="groupe" name="groupe">';
  	$toReturn .= '<option value="en attente"';
 	if($data['groupe']=="en attente"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>en attente</option>';
  	
  	$toReturn .= '<option value="membre"';
 	if($data['groupe']=="membre"){
  		$toReturn .= ' selected';
  	}
 	$toReturn .= '>membre</option>';
  	$toReturn .= '<option value="admin"';
  	if($data['groupe']=="admin"){
  		$toReturn .= ' selected';
  	}
  	$toReturn .= '>admin</option>'; 
 	
 	
	$toReturn .= '</select><span class="obligatoire"><span>oligatoire</span></span></p>';
	//-----------groupe-----------//
		
	$toReturn .='</fieldset>';
	$toReturn .='<p><input id="submit" type="submit" value="sauvegarder" name="submit_membre"/></p>';
		
	$toReturn .='<input type="hidden" id="admin" value="advance"/>';
	$toReturn .='<input type="hidden" id="admin_rubrique" value="membre"/>';
	$toReturn .='<input type="hidden" id="admin_operation" value="gestion"/>';
	$toReturn .='</form>';
	return $toReturn;
}



?>