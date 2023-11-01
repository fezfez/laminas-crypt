<?php

namespace LaminasTest\Crypt\BlockCipher;

use Laminas\Crypt\BlockCipher;
use Laminas\Crypt\Symmetric;

class OpensslTest extends AbstractBlockCipher
{
    public function setUp(): void
    {
        try {
            $this->cipher = new Symmetric\Openssl([
                'algorithm' => 'aes',
                'mode'      => 'cbc',
                'padding'   => 'pkcs7',
            ]);
        } catch (Symmetric\Exception\RuntimeException $e) {
            $this->markTestSkipped($e->getMessage());
        }
        parent::setUp();
    }

    public function testSetCipher()
    {
        $mcrypt = new Symmetric\Openssl();
        $result = $this->blockCipher->setCipher($this->cipher);
        $this->assertEquals($result, $this->blockCipher);
        $this->assertEquals($this->cipher, $this->blockCipher->getCipher());
    }

    /**
     * @requires PHP <= 8.2
     */
    public function testFactory()
    {
        $this->blockCipher = BlockCipher::factory('openssl', ['algo' => 'blowfish']);
        $this->assertInstanceOf(Symmetric\Openssl::class, $this->blockCipher->getCipher());
        $this->assertEquals('blowfish', $this->blockCipher->getCipher()->getAlgorithm());
    }

    public function testFactoryEmptyOptions()
    {
        $this->blockCipher = BlockCipher::factory('openssl');
        $this->assertInstanceOf(Symmetric\Openssl::class, $this->blockCipher->getCipher());
    }
}
