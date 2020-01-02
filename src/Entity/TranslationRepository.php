<?php

namespace Harentius\BlogBundle\Entity;

use Doctrine\ORM\Query;
use Gedmo\Tool\Wrapper\EntityWrapper;
use Gedmo\Translatable\Entity\Repository\TranslationRepository as BaseTranslationRepository;
use Gedmo\Translatable\TranslatableListener;

/**
 * @method Translation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Translation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Translation[] findAll()
 * @method Translation[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TranslationRepository extends BaseTranslationRepository
{
    /**
     * Current TranslatableListener instance used
     * in EntityManager.
     *
     * @var TranslatableListener
     */
    private $listener;

    /**
     * @param object $entity
     * @return array
     */
    public function findTranslations($entity)
    {
        $result = [];
        $wrapped = new EntityWrapper($entity, $this->_em);
        if ($wrapped->hasValidIdentifier()) {
            $entityId = $wrapped->getIdentifier();
            $entityClass = $wrapped->getMetadata()->getName();
            $translationMeta = $this->getClassMetadata(); // table inheritance support

            $config = $this
                ->getTranslatableListener()
                ->getConfiguration($this->_em, get_class($entity));

            $translationClass = isset($config['translationClass']) ?
                $config['translationClass'] :
                $translationMeta->rootEntityName;

            $qb = $this->_em->createQueryBuilder();
            $qb->select('trans.content, trans.field, trans.locale')
                ->from($translationClass, 'trans')
                ->where('trans.foreignKey = :entityId', 'trans.objectClass = :entityClass')
                ->orderBy('trans.locale');
            $q = $qb->getQuery();
            $data = $q->execute(
                compact('entityId', 'entityClass'),
                Query::HYDRATE_ARRAY
            );

            if ($data && is_array($data) && count($data)) {
                foreach ($data as $row) {
                    $result[$row['locale']][$row['field']] = $row['content'];
                }
            }
        }

        return $result;
    }

    /**
     * @return TranslatableListener
     */
    private function getTranslatableListener()
    {
        if (!$this->listener) {
            foreach ($this->_em->getEventManager()->getListeners() as $event => $listeners) {
                foreach ($listeners as $hash => $listener) {
                    if ($listener instanceof TranslatableListener) {
                        return $this->listener = $listener;
                    }
                }
            }

            throw new \Gedmo\Exception\RuntimeException('The translation listener could not be found');
        }

        return $this->listener;
    }
}
