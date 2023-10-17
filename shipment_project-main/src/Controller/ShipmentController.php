<?php

namespace App\Controller;

use App\Entity\Shipment;
use App\Form\ShipmentFormType;
use App\Repository\ShipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ShipmentController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/shipments', name: 'shipments')]
    public function index(EntityManagerInterface  $entityManager): Response
    {
        $shipmentRepository = $entityManager->getRepository(Shipment::class);
        $shipments = $shipmentRepository->findAll();

        return $this->render('shipment/index.html.twig', [
            'shipments' => $shipments,
        ]);
    }

    #[Route('/shipments/create', name: 'create_shipment')]
    public function create(Request $request): Response
    {
        $shipment = new Shipment();

        $form = $this->createForm(ShipmentFormType::class, $shipment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newShipment = $form->getData();

            // Benzersiz bir shipment_code oluşturun
            $shipmentCode = $this->generateUniqueShipmentCode();
            $shipment->setCargoCode($shipmentCode);

            $this->entityManager->persist($newShipment);
            $this->entityManager->flush();
            $this->addFlash('success', 'Gönderi başarıyla oluşturuldu.');

            return $this->redirectToRoute('create_shipment');
        }
        return $this->render('shipment/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/shipment_toggle_status/{id}/{action}', name: 'toggle_status')]
    public function toggleStatus(int $id, string $action, EntityManagerInterface $entityManager): Response
    {
        $shipment = $entityManager->getRepository(Shipment::class)->find($id);

        if (!$shipment) {
            throw $this->createNotFoundException('Kargo bulunamadı: ' . $id);
        }
    
        if ($action === 'activate') {
            $shipment->setStatus('active');
        } elseif ($action === 'deactivate') {
            $shipment->setStatus('inactive');
        }
    
        $entityManager->persist($shipment);
        $entityManager->flush();
    
        return $this->redirectToRoute('list_shipment');
    }


    public function generateUniqueShipmentCode()
    {
        // Benzersiz bir shipment_code oluştur
        $shipmentCode = uniqid('FFE'); //FFE

        while ($this->isShipmentCodeExists($shipmentCode)) {
            $shipmentCode = uniqid('SHIP');
        }

        return $shipmentCode;
    }

    private function isShipmentCodeExists($shipmentCode)
    {
        $repository = $this->entityManager->getRepository(Shipment::class);

        $existingShipment = $repository->findOneBy(['cargo_code' => $shipmentCode]);

        if ($existingShipment) {
            return true;
        }

        return false;
    }
}
