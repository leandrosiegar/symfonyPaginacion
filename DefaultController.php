<?php
namespace edcBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use edcBundle\Entity\cineastas;
use edcBundle\Form\cineastasType;
use edcBundle\Entity\peliculas;
use edcBundle\Form\peliculasType;
use edcBundle\Form\peliculasEditType;

use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	return $this->render('edcBundle:Default:index.html.twig');
    }
    
 
    // **************************************************
    public function addCineastaAction(Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	$cineastaAux = new cineastas();
    	$form = $this->createForm(new cineastasType(),$cineastaAux);
    	$form->handleRequest($request);
    
    	if($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($cineastaAux);
    		$em->flush();
    		$this->get('session')->getFlashBag()->add(
    				'mensaje','Se ha añadido el cineasta correctamente'
    		);
    		return $this->redirect($this->generateUrl('listarCineastas'));
    	}
    
    	return $this->render('edcBundle:Default:addCineasta.html.twig',
    			array("form"=>$form->createView()));
    }
    
    
    
    // **************************************************
    public function addPeliculaAction(Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
     	$peliculaAux = new peliculas();
    	$form = $this->createForm(new peliculasType(),$peliculaAux);
    	$form->handleRequest($request);
    	
    	if($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($peliculaAux);
      		$em->flush();
    		$this->get('session')->getFlashBag()->add(
    				'mensaje','Se ha añadido la película correctamente'
    		);
    		return $this->redirect($this->generateUrl('listarPeliculas'));
    	}
   		return $this->render('edcBundle:Default:addPelicula.html.twig',
    			array("form"=>$form->createView()));
    }
    
		
			
    // *****************************************
    public function delCineastaAction($id, Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$cineastaAux = $em->getRepository('edcBundle:cineastas')->find($id);
    
    	if (!$cineastaAux) {
    		throw $this->createNotFoundException(
    				'No existe el cineasta con el valor:'.$id
    		);
    	}
    
    	$em->remove($cineastaAux);
    	$em->flush();
    	$this->get('session')->getFlashBag()->add(
    			'mensaje',
    			'Se ha eliminado el cineasta correctamente'
    	);
    	return $this->redirect($this->generateUrl('listarCineastas'));
    }
    
    // *****************************************
    public function delPeliculaAction($id)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	$em = $this->getDoctrine()->getManager();
    	$peliculaAux = $em->getRepository('edcBundle:peliculas')->find($id);
    
    	if (!$peliculaAux) {
    		throw $this->createNotFoundException(
    				'No existe la película con el valor:'.$id
    		);
    	}
    
    	$em->remove($peliculaAux);
    	$em->flush();
    	$this->get('session')->getFlashBag()->add(
    			'mensaje',
    			'Se ha eliminado la película correctamente'
    	);
    	return $this->redirect($this->generateUrl('listarPeliculas'));
    }
    
    // *******************************************
    public function editCineastaAction($id,Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	$cineastaAux = new cineastas();
     	$datos = $this->getDoctrine()
    	->getRepository('edcBundle:cineastas')
    	->find($id);
    	if (!$datos) {
    		throw $this->createNotFoundException(
    				'No existe el cineasta con el valor:'.$id
    		);
    	}
    	
     	$form = $this->createForm(new CineastasType(), $datos);
    	$form->handleRequest($request);
    	 
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		//$em->persist($p);
    		$em->flush();
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Se ha modificado el cineasta correctamente'
    		);
    		return $this->redirect($this->generateUrl('listarCineastas'));
    	}
    	return $this->render('edcBundle:Default:editCineasta.html.twig',array("form"=>$form->createView()));
    }
    
    // *******************************************
    public function editPeliculaAction($id,Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	$peliculaAux = new peliculas();
    	$datos = $this->getDoctrine()
	    	->getRepository('edcBundle:peliculas')
	    	->find($id);
    	if (!$datos) {
    		throw $this->createNotFoundException(
    				'No existe la película con el id:'.$id
    		);
    	}
    	
    	$peliculasType = new peliculasEditType($this->getDoctrine()->getManager());
    	// Forzar a que en los combos queden seleccionada el item correspondiente
       	$peliculasType->setSelected('idDirector', $datos->getIdDirector());
       	$peliculasType->setSelected('idActor1', $datos->getIdActor1());
       	$peliculasType->setSelected('idActor2', $datos->getIdActor2());
       	       	
    	$form = $this->createForm($peliculasType, $datos);
    	$form->handleRequest($request);
    
    	if ($form->isValid()) {
    		$em = $this->getDoctrine()->getManager();
     		//$em->persist($p);
    		$em->flush();
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Se ha modificado la película correctamente'
    		);
    		return $this->redirect($this->generateUrl('listarPeliculas'));
    	}
    	return $this->render('edcBundle:Default:editPelicula.html.twig',array("form"=>$form->createView()));
    }
    
    // *******************************************
    public function getNombreCineasta($id) {
    	$em = $this->getDoctrine()->getManager();
    	$cineastaAux = $em->getRepository('edcBundle:cineastas')->find($id);
    	return $cineastaAux->getNombre();
    }
    
    // *********************************************
 	public function getTotalTabla($tabla)
    {
          $datos = $this->getDoctrine()
                ->getManager()
                ->createQueryBuilder('edcBundle:'.$tabla)
                ->select('Count(c)')
                ->from('edcBundle:'.$tabla,'c')
                ->getQuery()
                ->getSingleScalarResult();
            return $datos;
    }
    
    // **************************************
    public function listarCineastasOLDAction(Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
 
    	$datos = $this->getDoctrine()
    	/*
    	 ->getRepository('edcBundle:cineastas')
    	->findAll();
    	*/
    	// Si queremos una SQL más especifica entonces en vez de findAll:
    	->getRepository('edcBundle:cineastas')
    	->createQueryBuilder('c')
    	->where('c.nombre LIKE :nombre1')
    	->orWhere('c.nombre LIKE :nombre2')
    	->andWhere('c.id >0')
    	->setParameter('nombre1', '%a%')
    	->setParameter('nombre2', '%b%')
    	->orderBy('c.nombre', 'ASC')
    	->getQuery()
    	->getResult();
    	return $this->render('edcBundle:Default:listarCineastas.html.twig',compact("datos"));
    }
    
    // **************************************
    public function listarCineastasAction(Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	// Crear la paginación
    	$total_count = $this->getTotalTabla('cineastas');
    	$page = $request->get('page');
    	$porpagina = 4;
    	$totalPaginas = ceil($total_count/$porpagina);
    	// echo "TOTALPAGINAS:".$totalPaginas;exit;
    	
    	if(!is_numeric($page))	{
    		$page=1;
    	}else
    	{
    		$page = floor($page);
    	}
    	if($total_count <= $porpagina)
    	{
    		$page=1;
    	}
    	if(($page*$porpagina) > $total_count)
    	{
    		$page = $totalPaginas;
    	}
    	$offset = 0;
    	if($page > 1)
    	{
    		$offset = $porpagina*($page-1);
    	}
    	$em = $this->getDoctrine()
    		->getManager()
	    	->createQueryBuilder('edcBundle:cineastas')
	    	->select('c')
	    	->from('edcBundle:cineastas','c')
	    	->orderBy("c.nombre","asc")
	    	->setFirstResult($offset)
	    	->setMaxResults($porpagina)
	    	->getQuery();
    	
	    $datos=$em->getArrayResult();
     	return $this->render('edcBundle:Default:listarCineastas.html.twig',
    			compact("datos", "porpagina", "totalPaginas", "total_count", "page"));
    }
    
    // **************************************
    public function listarPeliculasAction(Request $request)
    {
    	// check si está logado
    	$session = $request->getSession();
    	if(!$session->has("id")) {
    		$this->get('session')->getFlashBag()->add(
    				'mensaje',
    				'Debe estar logueado para ver este contenido'
    		);
    		return $this->redirect($this->generateUrl('login'));
    	}
    	
    	$datos = $this->getDoctrine()
    	 	->getRepository('edcBundle:peliculas')
    		/*->findAll();*/
    		->createQueryBuilder('p')
    		->orderBy('p.titulo', 'ASC')
    		->getQuery()
    		->getResult();
    	
    	// Crear array auxiliar para que en los listados muestre los nombres y no los id
    	$arrCineastas = array();
    	foreach ($datos as $clave => $valor) {
    		$idCineasta = $valor->getIdDirector();
    		$nomDirector = $this->getNombreCineasta($idCineasta);
    		$idCineasta = $valor->getIdActor1();
    		$nomActor1 = $this->getNombreCineasta($idCineasta);
    		$idCineasta = $valor->getIdActor2();
    		$nomActor2 = $this->getNombreCineasta($idCineasta);
    		
    		$arrAux = array("nomDirector"=>$nomDirector, "nomActor1"=>$nomActor1,"nomActor2"=>$nomActor2);
    		$arrCineastas[$valor->getId()] = $arrAux;
    	}
    
    	return $this->render('edcBundle:Default:listarPeliculas.html.twig',
    			array("arrDatos"=>$datos, "arrCineastas"=>$arrCineastas));
    }
 }
