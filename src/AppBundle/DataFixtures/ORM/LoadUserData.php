<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\AgeGroup;
use AppBundle\Entity\Tag;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $plainPassword = 'bieblo';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($userAdmin, $plainPassword);
        $userAdmin->setPassword($encoded);
        $userAdmin->setEmail('admin@bieblo.be');


        $manager->persist($userAdmin);
        $manager->flush();

        $ageGroups = array(
            array('name' => '6-8 jaar', 'queryString' => ''),
            array('name' => '9-11 jaar', 'queryString' => ''),
        );

        foreach ($ageGroups as $a) {
            $ageGroup = new AgeGroup();
            $ageGroup->setName($a['name']);
            $ageGroup->setQueryString($a['queryString']);
            $manager->persist($ageGroup);
            $manager->flush();
        }

        $tags = array(
            array('name' => 'Grappige verhalen'),
            array('name' => 'Fantasieverhalen'),
            array('name' => 'Spannende verhalen'),
            array('name' => 'Sportverhalen'),
            array('name' => 'Dieren'),
            array('name' => 'Andere landen'),
            array('name' => 'Liefdesverhalen'),
            array('name' => 'Geschiedenis'),
            array('name' => 'Prijsboeken'),
            array('name' => 'Vriendschap'),
        );

        foreach ($tags as $t) {
            $tag = new Tag();
            $tag->setName($t['name']);
            $tag->setSettings('{}');
            $manager->persist($tag);
            $manager->flush();
        }
    }
}
