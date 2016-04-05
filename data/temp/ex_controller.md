  	public function creerAction(Request $request) {
  		if ($this->getCurrentUser()->getArtisan() != null) {
  			$societe = new Societe();
  			$form = $this->get('form.factory')->create(new SocieteType, $societe);
  			if ($form->handleRequest($request)->isValid()) {
  				$em = $this->getDoctrine()->getManager();
  				
  				// Ajout du lien societe - artisan :
  				$artisanSociete = new ArtisanSociete();
  				$artisanSociete->setEstResponsable(true);
  				$artisanSociete->setArtisan($this->getCurrentUser()->getArtisan());
  				$artisanSociete->setSociete($societe);
  				$em->persist($societe);
  				$em->persist($artisanSociete);
  				$em->flush();
  				$societe->uploadLogoPicture();
  				$em->flush();
  				$request->getSession()->getFlashBag()->add('notice', 'Société bien enregistrée.');
  				return $this->redirect($this->generateUrl('societe_afficher', array('id' => $societe->getId())));
  			}
  			return $this->render('SearchBundle:Societe:creer_societe.html.twig', array('form' => $form->createView()));
  		} else {
  			// Redirection vers mon compte
  			return $this->redirect($this->generateUrl('mon_compte'));
  		}
  	}
