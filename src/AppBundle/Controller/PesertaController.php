<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use AppBundle\Entity\Peserta;
use AppBundle\Form\PesertaType;
use AppBundle\Form\PresentType;
use ExcelAnt\Adapter\PhpExcel\Workbook\Workbook,
    ExcelAnt\Adapter\PhpExcel\Sheet\Sheet,
    ExcelAnt\Adapter\PhpExcel\Writer\Writer,
    ExcelAnt\Table\Table,
    ExcelAnt\Coordinate\Coordinate,
    ExcelAnt\Adapter\PhpExcel\Writer\WriterFactory,
    ExcelAnt\Adapter\PhpExcel\Writer\PhpExcelWriter\Excel5;

/**
 * Peserta controller.
 *
 * @Route("/")
 */
class PesertaController extends Controller
{

    /**
     * Lists all Peserta entities.
     *
     * @Route("/", name="peserta")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
		$query = $em->getRepository('AppBundle:Peserta')->dataAllQuery();
        $pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);

        return array(
            'entities' => $pagination,
        );
    }

    /**
     * Displays a form to edit an existing Peserta entity.
     *
     * @Route("/presensi", name="peserta_presensi")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
		$query = $em->getRepository('AppBundle:Peserta')->dataQuery();
        $pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);
		
		$present = new Peserta();
		$presentForm = $this->createForm(new PresentType(), $present, array(
			'method' => 'POST'
		));
		
		$presentForm->handleRequest($request);
		
		if ($presentForm->isValid() && $presentForm->isSubmitted()) {
			$pre = explode('-', $present->getName());
			$id = $pre[0];
			$pres = $em->getRepository('AppBundle:Peserta')->findOneById($id);
			($present->getPrint() == 1 ? $pres->setPrint(true) : $pres->setPrint(false));
			$pres->setPresent(true);
			$pres->setAddress($present->getAddress());
			$pres->setEmail($present->getEmail());
			$pres->setPhone($present->getPhone());
			$em->persist($pres);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Data presensi berhasil disimpan!');

            return $this->redirect($this->generateUrl('peserta_presensi'));
        }

        return array(
            'entities' => $pagination,
            'form' => $presentForm->createView(),
        );
    }
    
    /**
     *
     * @Route("/peserta/register", name="peserta_register")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $paginator = $this->get('knp_paginator');
		$query = $em->getRepository('AppBundle:Peserta')->dataQuery();
        $pagination = $paginator->paginate(
			$query,
			$this->get('request')->query->get('page', 1),
			25
		);
		
		$daftar = new Peserta();
		$daftarForm = $this->createForm(new PesertaType(), $daftar, array(
			'method' => 'POST'
		));
		
		$daftarForm->handleRequest($request);
		
		if ($daftarForm->isValid() && $daftarForm->isSubmitted()) {
			($daftar->getPrint() == 1 ? $daftar->setPrint(true) : $daftar->setPrint(false));
			$daftar->setPresent(true);
			$daftar->setTimestamp(new \DateTime());
			$em->persist($daftar);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Data peserta berhasil disimpan!');
            
            $daftar = new Peserta();
			$daftarF = $this->createForm(new PesertaType(), $daftar, array(
				'method' => 'POST'
			));

            return array(
				'entities' => $pagination,
				'form' => $daftarF->createView(),
			);
        }

        return array(
            'entities' => $pagination,
            'form' => $daftarForm->createView(),
        );
    }
    
    /**
     * @Route("/search", name="peserta_search")
     * @Method("GET")
     */
    public function autocompleteAction(Request $request)
    {
		$names = array();
		$term = trim(strip_tags($request->get('term')));
		
		$em = $this->getDoctrine()->getManager();
		$entities = $em->getRepository('AppBundle:Peserta')->getPeserta($term);
		
		foreach ($entities as $entity) {
			$names[] = $entity->getId().'-'.$entity->getName().'-'.$entity->getOrigin();
		}
		
		$response = new JsonResponse();
		$response->setData($names);
		
		return $response;
	}
	
	/**
	 * @Route("peserta/find/address", name="peserta_find_address")
	 * @Method("GET")
	 */
	public function getAddressAction(Request $request)
	{
		$id = $request->get('id');
		$em = $this->getDoctrine()->getManager();
		$entity = $em->getRepository('AppBundle:Peserta')->findOneById($id);
		$address = array(
			array('field' => 'address', 'value' => $entity->getAddress()),
			array('field' => 'email', 'value' => $entity->getEmail()),
			array('field' => 'phone', 'value' => $entity->getPhone())
		);
		$response = new JsonResponse();
		$response->setData($address);
		
		return $response;
	}
	
	/**
     * Lists all Peserta entities.
     *
     * @Route("/report", name="peserta_report")
     * @Method("GET")
     * @Template()
     */
    public function reportAction()
    {
        $peserta = $this->getDoctrine()->getManager()->getRepository('AppBundle:Peserta')->getReportData();
        $workbook = new Workbook();
        $sheet = new Sheet($workbook);
        $table = new Table();

        $i = 1;
        $table->setRow([
                    'NO',
                    'TANGGAL',
                    'NAMA',
                    'ALAMAT',
                    'EMAIL',
                    'PHONE',
                    'ASAL INSTITUSI',
                    'PRINT SERTIFIKAT',
            ]);
        foreach ($peserta as $p) {
            $table->setRow([
                    $i,
                    $p->getTimestamp()->format('d-m-Y'),
                    $p->getName(),
                    $p->getAddress(),
                    $p->getEmail(),
                    $p->getPhone(),
                    $p->getOrigin(),
                    $p->getCetak(),
            ]);
        $i++;
        }

        $sheet->addTable($table, new Coordinate(1,1));
        $workbook->addSheet($sheet);
        $d = date('Y-m-d');

        $writer = (new WriterFactory())->createWriter(new Excel5(__DIR__.'/../../../web/export/excel/'.$d.'-data-peserta.xls'));
        $phpExcel = $writer->convert($workbook);
        $writer->write($phpExcel);
        
        $filePath = __DIR__.'/../../../web/export/excel/'.$d.'-data-peserta.xls';

        $fs = new FileSystem();
        if (!$fs->exists($filePath)) {
            throw $this->createNotFoundException();
        }

        // prepare BinaryFileResponse
        $filename = $d.'-data-peserta.xls';
        $response = new BinaryFileResponse($filePath);
        $response->trustXSendfileTypeHeader();

        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $filename,
            iconv('UTF-8', 'ASCII//TRANSLIT', $filename)
        );

        return $response;
    }
}

