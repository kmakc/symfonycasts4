<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity(
 *     fields={"email"},
 *     message="You've already registered"
 * )
 */
class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(message="Please enter an email")
     * @Assert\Email()
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
