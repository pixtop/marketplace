<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 11/12/18
 * Time: 19:23
 */

namespace AppBundle\Form;


use AppBundle\Entity\Plateforme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class PlateformeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('inscriptionVendeur', MoneyType::class)
            ->add('inscriptionAcheteur', MoneyType::class)
            ->add('commissionVendeur', PercentType::class)
            ->add('commissionAcheteur', PercentType::class)
            ->addEventListener(FormEvents::PRE_SET_DATA,
                array($this, 'onPreSetData'));
    }

    public function onPreSetData(FormEvent $event)
    {
        /* @var Plateforme $plateforme */
        $plateforme = $event->getData();
        $form = $event->getForm();
        if ($plateforme->isInfoHote()) {
            $form->add('triChoix', ChoiceType::class, array(
                'choices' => array(
                    'Trie par popularité' => 0,
                    'Trie par prix croissant' => 1,
                    'Trie par avis décroissant' => 2,
                    'Trie par pertinence' => 3,
                ),
            ));
        }
        else {
            $form
                ->add('triChoix', ChoiceType::class, array(
                    'choices' => array(
                        'Trie par popularité' => 0,
                        'Trie par prix croissant' => 1,
                        'Trie par avis décroissant' => 2,
                    ),
                ))
                ->add('infoHote');
        }
    }
}