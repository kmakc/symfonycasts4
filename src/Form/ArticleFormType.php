<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Article|null $article */
        $article = $options['data'] ?? null;
        $isEdit = $article && $article->getId();

        $location = $article ? $article->getLocation() : null;

        $builder
            ->add('title', TextType::class, [
                'help' => 'Choose some'
            ])
            ->add('content', null, [
                'rows' => 15
            ])

            ->add('author', UserSelectTextType::class, [
                'attr' => ['class' => 'test-class'],
                'disabled' => $isEdit
                //'invalid_message' => 'Hmm, user not found',
                //'finder_callback' => some custom callback..
            ])
            ->add('location', ChoiceType::class, [
                'placeholder' => 'choose location',
                'choices' => [
                    'The Solar System'   => 'solar_system',
                    'Near a star'        => 'star',
                    'Interstellar Space' => 'interstellar_space'
                ],
                'required' => false,
            ]);

            if ($location) {
                $builder->add('specificLocationName', ChoiceType::class, [
                    'placeholder' => 'where exactly?',
                    'choices' => $this->getLocationNameChoices($location),
                    'required' => false,
                ]);
            }

            /*->add('author', EntityType::class, [
                'class'        => User::class,
                'choice_label' => 'email', // оr callback function (User $user) {...}
                'placeholder'  => 'Choose an author',
                'choices'      => $this->userRepository
                                    ->findAllEmailAlphabetical(),
                'invalid_message' => 'invalid value'
            ])*/;

            if ($options['include_published_at']) {
                $builder->add('publishedAt', null, [
                    'widget' => 'single_text'
                ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'           => Article::class,
            'include_published_at' => false
        ]);
    }

    private function getLocationNameChoices(string $location)
    {
        $planets = [
            'Mercury',
            'Venus',
            'Earth',
            'Mars',
            'Jupiter',
            'Saturn',
            'Uranus',
            'Neptune',
        ];
        $stars = [
            'Polaris',
            'Sirius',
            'Alpha Centauari A',
            'Alpha Centauari B',
            'Betelgeuse',
            'Rigel',
            'Other'
        ];
        $locationNameChoices = [
            'solar_system' => array_combine($planets, $planets),
            'star' => array_combine($stars, $stars),
            'interstellar_space' => null,
        ];
        return $locationNameChoices[$location];
    }
}
