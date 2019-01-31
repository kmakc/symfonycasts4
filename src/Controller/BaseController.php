<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    // : User для уточнения того что возвращается именно User App\Entity\User
    public function getUser(): User
    {
        return parent::getUser();
        // or in annotation:
        /**
         * @method User getUser()
         */
    }
}
