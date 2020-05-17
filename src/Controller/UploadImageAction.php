<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\Exception\ValidationException;
use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Img;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class UploadImageAction {

    private $formfactory;
    private $entityManager;
    private $validator;

    public function __construct(FormFactoryInterface $formfactory,
                                EntityManagerInterface $entityManager,
                                ValidatorInterface $validator)
    {
        $this->formfactory = $formfactory;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function __invoke(Request $request)
    {
        $image = new Img();

        $form = $this->formfactory->create(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($image);
            $this->entityManager->flush();

            return $image;
        }

        throw  new ValidationException(
            $this->validator->validate($image)
        );

    }

}