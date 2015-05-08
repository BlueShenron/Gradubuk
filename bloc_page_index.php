<?php
require_once('mysql_files/mysql_fonctions_index.php');
require_once('paginate.php');
/*---------------------------------------------------------------------*/
/*--------------------------[PAGE ACCUEIL]-----------------------------*/
//création des blocs html sur la page d'accueil
/*---------------------------------------------------------------------*/
function createDivNews(){	
return ('<div id="newspagehome" class="bloc_left_bar">
		<h3>News</h3>
		<hr/>
		<ul >
		<li><a href="#" title="titre info" ><span>date info</span> info cliquable</a><span> nb commentaires</span></li>
		<li><a href="#" title="titre info" ><span>date info</span> info cliquable</a><span> nb commentaires</span></li>
		<li><a href="#" title="titre info" ><span>date info</span> info cliquable</a><span> nb commentaires</span></li>
		<li><a href="#" title="titre info" ><span>date info</span> info cliquable</a><span> nb commentaires</span></li>
		</ul>
		</div>'
		);
}

function createDivDerniersTests(){
return ('<div id="testspagehome" class="bloc_left_bar">
		<h3>Test</h3>
		<hr/>
		<div class="testpagehome"><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		<div class="testpagehome"><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		<div class="testpagehome"><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		<div class="testpagehome"><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		</div>');
}


function createDivAvis(){
return ('<div id="avispagehome" class="bloc_left_bar">
		<h3>Avis</h3>
		<hr/>
		<div><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">un titre cliquable</a></h4><p>un texte explicatif [&#133;]</p><a href="#">lire la suite</a></div>
		</div>');
}


function createDivAstuces(){
return ('<div id="astucespagehome" class="bloc_left_bar">
		<h3>Astuces</h3>
		<hr/>	
		<div><a href="#">une image cliquable</a><h4><a href="#">nom du jeu cliquable</a></h4><p>type de l&#39;astuce</p></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">nom du jeu cliquable</a></h4><p>type de l&#39;astuce</p></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">nom du jeu cliquable</a></h4><p>type de l&#39;astuce</p></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">nom du jeu cliquable</a></h4><p>type de l&#39;astuce</p></div>
		</div>');
}

function createDivVideos(){
return ('<div id="videospagehome" class="bloc_left_bar">
		<h3>Videos</h3>
		<hr/>
		<div><a href="#">une image cliquable</a><h4><a href="#">titre de la video</a></h4><p>un texte explicatif [&#133;]</p></div>
		<div><a href="#">une image cliquable</a><h4><a href="#">titre de la video</a></h4><p>un texte explicatif [&#133;]</p></div>
		</div>');
}


function createDivArticles(){	
return ('<div id="articlespagehome" class="bloc_left_bar">
		<h3>Articles</h3>
		<hr/>
		<div> <a href="#">une image</a> <h4><a href="#">titre de l&#39;article</a></h4> <p>descriptif [&#133;]</p> <a href="#">lire la suite</a> </div>
		<div> <a href="#">une image</a> <h4><a href="#">titre de l&#39;article</a></h4> <p>descriptif [&#133;]</p> <a href="#">lire la suite</a> </div>
		</div>');
}

function createDivSlideShow(){
$toReturn =		'<div id="slideshowhomepage" class="bloc_left_bar">
				<div class="flexslider">
				<ul class="slides">';
				
$resultFrontpage = mysqlSelectFrontpage();

while($dataFrontpage = mysql_fetch_array($resultFrontpage)){

 
$toReturn .=	'<li>
				<a href="'.$dataFrontpage['URL'].'"><img src="'.$dataFrontpage['ILLUSTRATION'].'" alt="" /></a>
				<p class="flex-caption"><span>'.$dataFrontpage['TITRE'].'</span>'.$dataFrontpage['SOUS_TITRE'].'</p>
				</li>
				';
}
					      
$toReturn .= 	'</ul>
				</div>
				</div>';
return $toReturn;
}


function createDivPub(){
return ('<div id="pub" class="bloc_right_bar">
		<p>PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB PUB </p>
		</div>');
}


function createDivSocialNetwork(){
return ('<div id="socialnetworks" class="bloc_right_bar">
		<ul id="socialnetworks-list">
		<li><a href="#" id="facebook"><span>facebook</span></a></li>
		<li><a href="#" id="twitter"><span>twitter</span></a></li>
		<li><a href="#" id="instagram"><span>instagram</span></a></li>
		<li><a href="#" id="youtube"><span>youtube</span></a></li>
		<li><a href="#" id="rss"><span>rss</span></a></li>
		</ul>
		</div>');
}


function createDivForums(){
return ('<div id="forums" class="bloc_right_bar">
		<h3>Forums</h3>
		<hr/>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		</div>');
}

function createDivCollections(){
return ('<div id="collections" class="bloc_right_bar">
		<h3>Collections</h3>
		<hr/>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		<div><h4><a href="#">sujet</a></h4><p>membre</p><p>date</p></div>
		</div>');
}

function createDivPlanning(){
return ('<div id="planning" class="bloc_right_bar">
		<h3>Planning</h3>
		<hr/>
		<div>
		<a href="#">une image</a>
		<h4><a href="#">titre du jeux</a></h4>
		<p>machine</p> 
		<p>date</p> 
		<ul>
		<li>US</li>
		<li>UE</li>
		<li>JP</li>
		</ul>
		</div>
		
		<div>
		<a href="#">une image</a>
		<h4><a href="#">titre du jeux</a></h4>
		<p>machine</p> 
		<p>date</p> 
		<ul>
		<li>US</li>
		<li>UE</li>
		<li>JP</li>
		</ul>
		</div>
		
		<div>
		<a href="#">une image</a>
		<h4><a href="#">titre du jeux</a></h4>
		<p>machine</p> 
		<p>date</p> 
		<ul>
		<li>US</li>
		<li>UE</li>
		<li>JP</li>
		</ul>
		</div>
		
		</div>');


}

function createDivPartenaires(){
return ('<div id="partenaires" class="bloc_right_bar">
		<h3>Partenaires</h3>
		<hr/>
		<div>
		<ul>
		<li><a href="#">Grospixels</a></li>
		<li><a href="#">Neo-Arcadia</a></li>
		<li><a href="#">Xbox 360</a></li>
		<li><a href="#">Raton Laveur</a></li>
		<li><a href="#">Jeux Mangas</a></li>
		<li><a href="#">Cote Japon</a></li>
		</ul>
		</div>
		</div>');
}




?>