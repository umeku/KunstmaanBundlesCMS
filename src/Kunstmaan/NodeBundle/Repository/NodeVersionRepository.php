<?php

namespace Kunstmaan\NodeBundle\Repository;

use Kunstmaan\NodeBundle\Entity\HasNodeInterface;
use Kunstmaan\NodeBundle\Entity\NodeTranslation;
use Kunstmaan\NodeBundle\Entity\NodeVersion;
use Kunstmaan\AdminBundle\Entity\AddCommand;
use Kunstmaan\AdminBundle\Entity\User;
use Kunstmaan\UtilitiesBundle\Helper\ClassLookup;

use Doctrine\ORM\EntityRepository;

/**
 * NodeRepository
 *
 */
class NodeVersionRepository extends EntityRepository
{
    /**
     * @param HasNodeInterface $hasNode
     *
     * @return NodeVersion
     */
    public function getNodeVersionFor(HasNodeInterface $hasNode)
    {
        return $this->findOneBy(array('refId' => $hasNode->getId(), 'refEntityName' => ClassLookup::getClass($hasNode)));
    }

    /**
     * @param HasNodeInterface $hasNode         The object
     * @param NodeTranslation  $nodeTranslation The nodetranslation
     * @param User             $owner           The user
     * @param string           $type            (public|draft)
     *
     * @throws \Exception
     * @return NodeVersion
     */
    public function createNodeVersionFor(HasNodeInterface $hasNode, NodeTranslation $nodeTranslation, $owner, $type = "public")
    {
        $em = $this->getEntityManager();

        $nodeVersion = new NodeVersion();
        $nodeVersion->setNodeTranslation($nodeTranslation);
        $nodeVersion->setType($type);
        $nodeVersion->setVersion($nodeTranslation->getNodeVersions()->count() + 1);
        $nodeVersion->setOwner($owner);
        $nodeVersion->setRef($hasNode);

        $em->persist($nodeVersion);
        $em->refresh($nodeVersion);
        // @todo logging $addcommand->execute("new version for page \"" . $nodeTranslation->getTitle() . "\" with locale: " . $nodeTranslation->getLang(), array('entity' => $nodeVersion));

        return $nodeVersion;
    }
}
