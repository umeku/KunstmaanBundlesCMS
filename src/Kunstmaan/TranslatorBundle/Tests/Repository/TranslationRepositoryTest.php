<?php
namespace Kunstmaan\TranslatorBundle\Tests\Service\Importer;

use Kunstmaan\TranslatorBundle\Tests\BaseTestCase;

class TranslationRepositoryTest extends BaseTestCase
{

    private $translationRepository;

    public function setUp()
    {
        parent::setUp();
        $this->translationRepository = $this->getContainer()->get('kunstmaan_translator.repository.translation');
    }

    public function testGetAllDomainsByLocale()
    {
        $result = $this->translationRepository->getAllDomainsByLocale();
        $firstItem = reset($result);
        $this->assertArrayHasKey('locale', $firstItem);
        $this->assertArrayHasKey('name', $firstItem);
    }

    /**
     * @group translation-repository
     */
    public function testGetLastChangedTranslationDate()
    {
        $date = $this->translationRepository->getLastChangedTranslationDate();
        $this->assertInstanceOf('\DateTime', $date);
    }
}
