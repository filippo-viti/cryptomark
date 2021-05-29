<?php

namespace App\DataFixtures;

use App\Entity\Algorithm;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class AlgorithmFixtures extends Fixture implements DependentFixtureInterface
{
    public const RSA_REFERENCE = 'rsa';
    public const AES_REFERENCE = 'aes';
    public const SHA_REFERENCE = 'sha';
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager)
    {
        $this->entityManager->getConnection()->executeQuery('ALTER TABLE algorithm AUTO_INCREMENT = 1;');
        $rsa = new Algorithm();
        $rsa->setName("RSA");
        $rsa->setCreator("Rivest, Shamir, Adleman");
        $rsa->setYear(1977);
        $rsa->setKeyLength(1024);
        $rsa->setShortDescription("RSA (Rivest–Shamir–Adleman) is a public-key cryptosystem that is widely used for secure data transmission.");
        $rsa->setDescription('## Introduction  
RSA (Rivest–Shamir–Adleman) is a public-key cryptosystem that is widely used for secure data transmission. It is also one of the oldest. The acronym RSA comes from the surnames of Ron Rivest, Adi Shamir and Leonard Adleman, who publicly described the algorithm in 1977. An equivalent system was developed secretly, in 1973 at GCHQ (the British signals intelligence agency), by the English mathematician Clifford Cocks. That system was declassified in 1997.[1]

In a public-key cryptosystem, the encryption key is public and distinct from the decryption key, which is kept secret (private). An RSA user creates and publishes a public key based on two large prime numbers, along with an auxiliary value. The prime numbers are kept secret. Messages can be encrypted by anyone, via the public key, but can only be decoded by someone who knows the prime numbers.[2]

The security of RSA relies on the practical difficulty of factoring the product of two large prime numbers, the "factoring problem". Breaking RSA encryption is known as the RSA problem. Whether it is as difficult as the factoring problem is an open question.[3] There are no published methods to defeat the system if a large enough key is used.

RSA is a relatively slow algorithm. Because of this, it is not commonly used to directly encrypt user data. More often, RSA is used to transmit shared keys for symmetric key cryptography, which are then used for bulk encryption-decryption.'
        );
        $rsa->addTag($this->getReference(CategoryTagFixtures::PUBKEY_TAG_REFERENCE));

        $aes = new Algorithm();
        $aes->setName("AES");
        $aes->setCreator("Vincent Rijmen, Joan Daemen");
        $aes->setYear(1998);
        $aes->setKeyLength(256);
        $aes->setShortDescription("The Advanced Encryption Standard (AES), also known by its original name Rijndael, is a specification for the encryption of electronic data established by the U.S. National Institute of Standards");
        $aes->setDescription('## Introduction  
The Advanced Encryption Standard (AES), also known by its original name Rijndael (Dutch pronunciation: [ˈrɛindaːl]),[3] is a specification for the encryption of electronic data established by the U.S. National Institute of Standards and Technology (NIST) in 2001.[4]

AES is a subset of the Rijndael block cipher[3] developed by two Belgian cryptographers, Vincent Rijmen and Joan Daemen, who submitted a proposal[5] to NIST during the AES selection process.[6] Rijndael is a family of ciphers with different key and block sizes. For AES, NIST selected three members of the Rijndael family, each with a block size of 128 bits, but three different key lengths: 128, 192 and 256 bits.

AES has been adopted by the U.S. government. It supersedes the Data Encryption Standard (DES),[7] which was published in 1977. The algorithm described by AES is a symmetric-key algorithm, meaning the same key is used for both encrypting and decrypting the data.

In the United States, AES was announced by the NIST as U.S. FIPS PUB 197 (FIPS 197) on November 26, 2001.[4] This announcement followed a five-year standardization process in which fifteen competing designs were presented and evaluated, before the Rijndael cipher was selected as the most suitable (see Advanced Encryption Standard process for more details).

AES is included in the ISO/IEC 18033-3 standard. AES became effective as a U.S. federal government standard on May 26, 2002, after approval by the U.S. Secretary of Commerce. AES is available in many different encryption packages, and is the first (and only) publicly accessible cipher approved by the U.S. National Security Agency (NSA) for top secret information when used in an NSA approved cryptographic module (see Security of AES, below).
        ');
        $aes->addTag($this->getReference(CategoryTagFixtures::SYMMMETRIC_TAG_REFERENCE));

        $md5 = new Algorithm();
        $md5->setName("MD5");
        $md5->setCreator("Ronald Rivest");
        $md5->setYear(1992);
        $md5->setDigestSize(128);
        $md5->setShortDescription("The MD5 message-digest algorithm is a widely used hash function producing a 128-bit hash value.");
        $md5->setDescription('## Introduction  
        The MD5 message-digest algorithm is a widely used hash function producing a 128-bit hash value. Although MD5 was initially designed to be used as a cryptographic hash function, it has been found to suffer from extensive vulnerabilities. It can still be used as a checksum to verify data integrity, but only against unintentional corruption. It remains suitable for other non-cryptographic purposes, for example for determining the partition for a particular key in a partitioned database.[3]

MD5 was designed by Ronald Rivest in 1991 to replace an earlier hash function MD4,[4] and was specified in 1992 as RFC 1321.

One basic requirement of any cryptographic hash function is that it should be computationally infeasible to find two distinct messages that hash to the same value. MD5 fails this requirement catastrophically; such collisions can be found in seconds on an ordinary home computer.

The weaknesses of MD5 have been exploited in the field, most infamously by the Flame malware in 2012. The CMU Software Engineering Institute considers MD5 essentially "cryptographically broken and unsuitable for further use".[5]

As of 2019, MD5 continues to be widely used, in spite of its well-documented weaknesses and deprecation by security experts
');
        $md5->addTag($this->getReference(CategoryTagFixtures::HASH_TAG_REFERENCE));

        $sha = new Algorithm();
        $sha->setName("SHA-2");
        $sha->setCreator("NSA");
        $sha->setYear(2001);
        $sha->setDigestSize(256);
        $sha->setShortDescription("SHA-2 (Secure Hash Algorithm 2) is a set of cryptographic hash functions designed by the United States National Security Agency (NSA) and first published in 2001.");
        $sha->setDescription('## Introduction  
SHA-2 (Secure Hash Algorithm 2) is a set of cryptographic hash functions designed by the United States National Security Agency (NSA) and first published in 2001.[3][4] They are built using the Merkle–Damgård construction, from a one-way compression function itself built using the Davies–Meyer structure from a specialized block cipher.

SHA-2 includes significant changes from its predecessor, SHA-1. The SHA-2 family consists of six hash functions with digests (hash values) that are 224, 256, 384 or 512 bits: SHA-224, SHA-256, SHA-384, SHA-512, SHA-512/224, SHA-512/256. SHA-256 and SHA-512 are novel hash functions computed with eight 32-bit and 64-bit words, respectively. They use different shift amounts and additive constants, but their structures are otherwise virtually identical, differing only in the number of rounds. SHA-224 and SHA-384 are truncated versions of SHA-256 and SHA-512 respectively, computed with different initial values. SHA-512/224 and SHA-512/256 are also truncated versions of SHA-512, but the initial values are generated using the method described in Federal Information Processing Standards (FIPS) PUB 180-4.

SHA-2 was first published by the National Institute of Standards and Technology (NIST) as a U.S. federal standard (FIPS). The SHA-2 family of algorithms are patented in US patent 6829355.[5] The United States has released the patent under a royalty-free license.[6]

Currently, the best public attacks break preimage resistance for 52 out of 64 rounds of SHA-256 or 57 out of 80 rounds of SHA-512, and collision resistance for 46 out of 64 rounds of SHA-256.
');
        $sha->addTag($this->getReference(CategoryTagFixtures::HASH_TAG_REFERENCE));

        $manager->persist($rsa);
        $manager->persist($aes);
        $manager->persist($md5);
        $manager->persist($sha);
        $manager->flush();

        $this->addReference(self::RSA_REFERENCE, $rsa);
        $this->addReference(self::AES_REFERENCE, $aes);
        $this->addReference(self::SHA_REFERENCE, $sha);
    }

    public function getDependencies()
    {
        return [
            CategoryTagFixtures::class
        ];
    }
}
