<?php
/**
 * Created by PhpStorm.
 * User: pixtop
 * Date: 13/11/18
 * Time: 20:44
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;

class InformationPersonnelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descriptionProjet')
            ->add('budgetOrdinateur', MoneyType::class)
            ->add('budgetLivre', MoneyType::class)
            ->add('budgetObjetCourant', MoneyType::class)
        ;
    }
}