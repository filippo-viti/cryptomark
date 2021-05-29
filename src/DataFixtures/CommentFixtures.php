<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $comment1 = new Comment();
        $comment1->setUser($this->getReference(UserFixtures::USER_1_REFERENCE));
        $comment1->setAlgorithm($this->getReference(AlgorithmFixtures::RSA_REFERENCE));
        $comment1->setText("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales.");
        $comment1->setUpvotes(10);

        $comment2 = new Comment();
        $comment2->setUser($this->getReference(UserFixtures::ADMIN_USER_REFERENCE));
        $comment2->setAlgorithm($this->getReference(AlgorithmFixtures::RSA_REFERENCE));
        $comment2->setText("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales.");
        $comment2->setUpvotes(1);
        $comment2->setParent($comment1);

        $comment3 = new Comment();
        $comment3->setUser($this->getReference(UserFixtures::USER_2_REFERENCE));
        $comment3->setAlgorithm($this->getReference(AlgorithmFixtures::RSA_REFERENCE));
        $comment3->setText("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam sodales.");
        $comment3->setUpvotes(5);

        $manager->persist($comment1);
        $manager->persist($comment2);
        $manager->persist($comment3);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            AlgorithmFixtures::class
        ];
    }
}
