<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $date = new DateTime('1998');

        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setDescription('Je suis un admin');
        $admin->setAvatar('avatar-default.png');
        $admin->setEmail('admin@email.fr');
        $admin->setPseudo('administrator');
        $admin->setBirthYear($date);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'password'));

        $manager->persist($admin);

        $manager->flush();
    }
}
