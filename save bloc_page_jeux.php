<?php

/*---------------------------------------------------------------------*/
/*--------------------------[PAGE JEUX]-----------------------------*/
//création des blocs html sur la page jeux
/*---------------------------------------------------------------------*/
function createDivFicheJeu(){
return ('<div id="fichejeu" class="bloc_left_bar">	

		<div class="bloc_left_bar_left_div">
		<div><img src="ressources/games_covers/alien.jpg"/></div>
		<div><img src="dummypictures/amazon_ad.png"/></div>
		</div>
		
		
		
		<div class="bloc_left_bar_right_div">
			<div>
			<p><em>Alien: Isolation</em> est un jeu d\'action développé par <em>The Creative Assembly</em> et édité par <em>Sega</em>.</p>
			<p>Disponible sur PS3, PS4, PC, XBox 360, XBox One.</p>
			<ul>
			<li>Genre: <a href=#">Action</a></li>
			<li>Développeur: <a href=#">Sega</a></li>
			<li>Editeur: <a href=#">The Creative Assembly</a></li>
			<li>Sortie: 26 novembre 2014</li>
			<li>Nombre de joueurs: 1</li>
			</ul>
			</div>	
		</div><!-- fin right -->
		
		
		<br/>
		</div><!-- fin bloc_left_bar -->'

		);
}

function createDivTestJeu(){
return ('<div id="testjeu" class="bloc_left_bar">	
		<h3>Test</h3>
		<hr/>
		<div class="bloc_left_bar_left_div">
		<div class="note"><span>10</span></div>
		</div>
		
		<div class="bloc_left_bar_right_div">
			<div>
			<p>Après un épisode Colonial Marines totalement chaotique et peu réussi, la franchise Alien ne peut que nous surprendre ! C\'est bien parti pour, puisque ce sont les petits gars de Creative Assembly (réputés pour leurs STR tactiques et la longue lignée des Total War) qui sont sur le projet Alien Isolation et ils comptent bien redorer le blason de la licence du Xénomorphe. Ici, point de scripts [...] >lire le test complet</p>
			</div>
		</div>
		
			
		
		</div>'
		);
}

function createDivVideoJeu(){
return ('<div id="videojeu" class="bloc_left_bar">	
		<h3>Videos</h3>
		<hr/>
		<div class="video-container">
		<iframe width="560" height="315" src="//www.youtube.com/embed/JVNN1v3JxGY" frameborder="0" allowfullscreen></iframe>
		</div>
		</div>'
		);
}

function createDivImagesJeu(){
return ('
		<div class="bloc_left_bar">
		<h3>Images</h3>
		<hr/>
		
			<div class="images_slider_container">
			<div class="image_slider_content">
			<div id="rg-gallery" class="rg-gallery">
			<div class="rg-image-wrapper">
				<div class="rg-image-nav">
					<a href="#" class="rg-image-nav-prev">Previous Image</a>
					<a href="#" class="rg-image-nav-next">Next Image</a>
				</div>
					
			<div class="rg-image"></div>
			<div class="rg-loading"></div>
			<!--<div class="rg-caption-wrapper">
				<div class="rg-caption" style="display:none;">
				<p></p>
				</div>
			</div>-->
			</div>

					<div class="rg-thumbs">
						<!-- Elastislide Carousel Thumbnail Viewer -->
						<div class="es-carousel-wrapper">
							<div class="es-nav">
								<span class="es-nav-prev">Previous</span>
								<span class="es-nav-next">Next</span>
							</div>
							<div class="es-carousel">
								<ul>
									<li><a href="#"><img src="images/thumbs/4.jpg" data-large="images/4.jpg" alt="image04" data-description="My spirits to attend this double voice accorded" /></a></li>
									<li><a href="#"><img src="images/thumbs/5.jpg" data-large="images/5.jpg" alt="image05" data-description="And down I laid to list the sad-tuned tale" /></a></li>
									<li><a href="#"><img src="images/thumbs/6.jpg" data-large="images/6.jpg" alt="image06" data-description="Ere long espied a fickle maid full pale" /></a></li>
									<li><a href="#"><img src="images/thumbs/7.jpg" data-large="images/7.jpg" alt="image07" data-description="Tearing of papers, breaking rings a-twain" /></a></li>
									<li><a href="#"><img src="images/thumbs/8.jpg" data-large="images/8.jpg" alt="image08" data-description="Storming her world with sorrow" /></a></li>
									<li><a href="#"><img src="images/thumbs/9.jpg" data-large="images/9.jpg" alt="image09" data-description="Upon her head a platted hive of straw" /></a></li>
									<li><a href="#"><img src="images/thumbs/10.jpg" data-large="images/10.jpg" alt="image10" data-description="Which fortified her visage from the sun" /></a></li>
									<li><a href="#"><img src="images/thumbs/11.jpg" data-large="images/11.jpg" alt="image11" data-description="Whereon the thought might think sometime it saw" /></a></li>
									<li><a href="#"><img src="images/thumbs/12.jpg" data-large="images/12.jpg" alt="image12" data-description="The carcass of beauty spent and done" /></a></li>
									<li><a href="#"><img src="images/thumbs/13.jpg" data-large="images/13.jpg" alt="image13" data-description="Time had not scythed all that youth begun" /></a></li>
									<li><a href="#"><img src="images/thumbs/14.jpg" data-large="images/14.jpg" alt="image14" data-description="Nor youth all quit; but, spite of heaven" /></a></li>
									<li><a href="#"><img src="images/thumbs/15.jpg" data-large="images/15.jpg" alt="image15" data-description="Some beauty peep" /></a></li>
									<li><a href="#"><img src="images/thumbs/16.jpg" data-large="images/16.jpg" alt="image16" data-description="Oft did she heave her napkin to her eyne" /></a></li>
									<li><a href="#"><img src="images/thumbs/17.jpg" data-large="images/17.jpg" alt="image17" data-description="Which on it had conceited characters" /></a></li>
									<li><a href="#"><img src="images/thumbs/18.jpg" data-large="images/18.jpg" alt="image18" data-description="Laundering the silken figures in the brine" /></a></li>
									<li><a href="#"><img src="images/thumbs/19.jpg" data-large="images/19.jpg" alt="image19" data-description="That season" /></a></li>
									<li><a href="#"><img src="images/thumbs/20.jpg" data-large="images/20.jpg" alt="image20" data-description="And often reading what contents it bears" /></a></li>
									<li><a href="#"><img src="images/thumbs/21.jpg" data-large="images/21.jpg" alt="image21" data-description="As often shrieking undistinguish" /></a></li>
									<li><a href="#"><img src="images/thumbs/22.jpg" data-large="images/22.jpg" alt="image22" data-description="In clamours of all size, both high and low" /></a></li>
									<li><a href="#"><img src="images/thumbs/23.jpg" data-large="images/23.jpg" alt="image23" data-description="Sometimes her levell" /></a></li>
									<li><a href="#"><img src="images/thumbs/24.jpg" data-large="images/24.jpg" alt="image24" data-description="As they did battery to the spheres intend" /></a></li>
								</ul>
							</div>
						</div>
						<!-- End Elastislide Carousel Thumbnail Viewer -->
					</div><!-- rg-thumbs -->
				</div><!-- rg-gallery -->
				
			</div><!-- image_slider_content -->
		</div><!-- images_slider_container -->

		</div>
		'
		);
}
function createDivResumeJeu(){
return ('<div id="resumepagejeu" class="bloc_left_bar">
		<h3>Résumé</h3>	
		<hr/>
		<div class="bloc_left_bar_div_complet">
		<p>
		Le jeu se passe en 2137, soit quinze ans après les événements de Alien et quarante-deux ans avant les événements de Aliens, le retour. Le jeu se concentre sur Amanda, la fille de Ellen Ripley, qui, après avoir mené des recherches sur la disparition de sa mère, est envoyée sur la station spatiale Sevastopol pour retrouver des données qui pourraient l’aider à localiser sa mère, ignorant que le xénomorphe a déjà infesté la station.
		</p>
		</div>
		</div>');
}
function createDivAstucesJeu(){
return ('<div id="astucespagejeu" class="bloc_left_bar">
		<h3>Astuces</h3>	
		<hr/>
		<div class="bloc_left_bar_div_complet">
		<ul>
		<li class="astuce"><a href="#">Accéder directement au dernier niveau. </a><span>Mr X, 20/12/2007</span></li>
		<li class="astuce"><a href="#">Invulnérabilité. </a><span>Mr X, 20/12/2007</span></li>
		</ul>
		</div>
		</div>');
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