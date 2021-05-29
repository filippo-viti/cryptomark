<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const ADMIN_USER_REFERENCE = 'admin-user';
    public const USER_1_REFERENCE = 'user-1';
    public const USER_2_REFERENCE = 'user-2';

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
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
