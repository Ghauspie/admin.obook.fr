<?php

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminObookTest extends WebTestCase
{

    public function testLogin()
    {
        $client= static::createClient();
        $userRepository= static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('danista@hotmail.fr');

        $client->loginUser($testUser);

        $client->request('GET','/user');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1','Hello danista@hotmail.fr');

    }

    public function UserLogin()
    {
        return [
            ['danista@homail.fr','Obook7171'],
            ['test@obook.fr'],
            []
        ];
    }

    public function testFailingInclude()
    {
        $this->expectException(PHPUnit\Framework\Error\Error::class);
        include 'not_existing_file.php';
    }
}