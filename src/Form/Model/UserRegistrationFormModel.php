<?php

namespace App\Form\Model;

use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an email")
     * @Assert\Email()
     * @UniqueUser()
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Choose a password")
     * @Assert\Length(min=5, minMessage="too short", max=20, maxMessage="too long")
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(message="Please, agree with terms")
     */
    public $agreeTerms;
}
