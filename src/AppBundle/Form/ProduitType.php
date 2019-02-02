<?php

namespace AppBundle\Form;

use AppBundle\Entity\Integrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class ProduitType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /**
         * @var Integrateur $integrateur
         */
        $integrateur = $options['integrateur'];

        $a = array();
        for ($i=1;$i<21;$i++) $a[$i] = $i;

        $builder
            ->add('nom')
            ->add('description')
            ->add('prix', MoneyType::class)
            ->add('categorie', ChoiceType::class, array(
                'choices'  => array(
                    'Ordinateur' => 'ordinateur',
                    'Livre' => 'livre',
                    'Produit Quotidien' => 'quotidien',
                )))
            ->add('nImage', ChoiceType::class, array(
                'choices' => $a,
            ))
            ->addEventListener(FormEvents::PRE_SET_DATA,
        array($this, 'onPreSetData'));

        if ($integrateur->getActif()) {
            $builder->add('integrateur', CheckboxType::class, array(
                'mapped' => false,
                'required' => false,
            ));
        }

    }

    public function onPreSetData(FormEvent $event)
    {
        $produit = $event->getData();
        $form = $event->getForm();
        if (!$produit->getNom()) {
            $form
                ->add('cout', MoneyType::class)
                ->add('quantite');
        }
        else {
            $form
                ->add('cout', MoneyType::class, array(
                    'disabled' => true,
                ))
                ->add('quantite', IntegerType::class, array(
                    'constraints' => [new GreaterThanOrEqual($produit->getQuantite())]
                ));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produit'
        ));

        $resolver->setRequired('integrateur');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_produit';
    }


}
