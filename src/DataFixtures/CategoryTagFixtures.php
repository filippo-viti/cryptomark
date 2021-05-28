<?php

namespace App\DataFixtures;

use App\Entity\CategoryTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryTagFixtures extends Fixture
{
    public const PUBKEY_TAG_REFERENCE = 'pubkey-tag';
    public const SYMMMETRIC_TAG_REFERENCE = 'symmetric-tag';
    public const HASH_TAG_REFERENCE = 'hash-tag';

    public function load(ObjectManager $manager)
    {
        $tag1 = new CategoryTag();
        $tag1->setName("Public key Cryptography");
        $tag1->setColor("#FF0000");
        $tag1->setDescription("Public-key cryptography, or asymmetric cryptography, is a cryptographic system that uses pairs of keys: public keys (which may be known to others), and private keys (which may never be known by any except the owner). The generation of such key pairs depends on cryptographic algorithms which are based on mathematical problems termed one-way functions. Effective security requires keeping the private key private; the public key can be openly distributed without compromising security");

        $tag2 = new CategoryTag();
        $tag2->setName("Symmetric key Cryptography");
        $tag2->setColor("#00FF00");
        $tag2->setDescription("Symmetric-key algorithms[a] are algorithms for cryptography that use the same cryptographic keys for both the encryption of plaintext and the decryption of ciphertext. The keys may be identical, or there may be a simple transformation to go between the two keys.[1] The keys, in practice, represent a shared secret between two or more parties that can be used to maintain a private information link.[2] The requirement that both parties have access to the secret key is one of the main drawbacks of symmetric-key encryption, in comparison to public-key encryption (also known as asymmetric-key encryption");

        $tag3 = new CategoryTag();
        $tag3->setName("Hash Function");
        $tag3->setColor("#0000FF");
        $tag3->setDescription("A hash function is any function that can be used to map data of arbitrary size to fixed-size values. The values returned by a hash function are called hash values, hash codes, digests, or simply hashes. The values are usually used to index a fixed-size table called a hash table. Use of a hash function to index a hash table is called hashing or scatter storage addressing");

        $manager->persist($tag1);
        $manager->persist($tag2);
        $manager->persist($tag3);
        $manager->flush();

        $this->addReference(self::PUBKEY_TAG_REFERENCE, $tag1);
        $this->addReference(self::SYMMMETRIC_TAG_REFERENCE, $tag2);
        $this->addReference(self::HASH_TAG_REFERENCE, $tag3);
    }
}
