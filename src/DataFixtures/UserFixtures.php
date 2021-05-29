<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const USER_1_REFERENCE = 'user-1';
    public const USER_2_REFERENCE = 'user-2';

    private $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $this->entityManager->getConnection()->executeQuery('ALTER TABLE user AUTO_INCREMENT = 1;');

        $user = new User();
        $user->setUsername("admin");
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            "admin"
        ));
        $user->setRoles([
            "ROLE_ADMIN",
            "ROLE_EDITOR"
        ]);
        $manager->persist($user);

        $user1 = new User();
        $user1->setUsername("dummy_user_1");
        $user1->setPassword($this->passwordHasher->hashPassword(
            $user1,
            "Abcd1234"
        ));

        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername("dummy_user_2");
        $user2->setPassword($this->passwordHasher->hashPassword(
            $user2,
            "Abcd1234"
        ));
        $manager->persist($user2);
        $manager->flush();

        $this->addReference(self::ADMIN_USER_REFERENCE, $user);
        $this->addReference(self::USER_1_REFERENCE, $user1);
        $this->addReference(self::USER_2_REFERENCE, $user2);
    }
}
